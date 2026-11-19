<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreServiceOrderRequest;
use App\Http\Requests\UpdateServiceOrderRequest;
use App\Http\Requests\UpdateServiceOrderStatusRequest;
use App\Models\Customer;
use App\Models\ServiceOrder;
use App\Models\ServiceOrderUpdate;
use App\Models\User;
use App\ServiceOrderPriority;
use App\ServiceOrderStatus;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceOrderController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('search')->trim()->toString();
        $status = $request->string('status')->toString();
        $priority = $request->string('priority')->toString();

        $orders = ServiceOrder::query()
            ->with(['customer:id,name', 'assignedTechnician:id,name'])
            ->when($search !== '', function (Builder $query) use ($search): void {
                $query->where(function (Builder $query) use ($search): void {
                    $query->where('number', 'like', "%{$search}%")
                        ->orWhere('title', 'like', "%{$search}%")
                        ->orWhereHas('customer', fn (Builder $customerQuery) => $customerQuery->where('name', 'like', "%{$search}%"));
                });
            })
            ->when(in_array($status, array_column(ServiceOrderStatus::cases(), 'value'), true), fn (Builder $query) => $query->where('status', $status))
            ->when(in_array($priority, array_column(ServiceOrderPriority::cases(), 'value'), true), fn (Builder $query) => $query->where('priority', $priority))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $statusCounts = collect(ServiceOrderStatus::cases())
            ->mapWithKeys(fn (ServiceOrderStatus $item): array => [$item->value => ServiceOrder::where('status', $item->value)->count()]);

        return view('service-orders.index', [
            'orders' => $orders,
            'search' => $search,
            'status' => $status,
            'priority' => $priority,
            'statuses' => ServiceOrderStatus::cases(),
            'priorities' => ServiceOrderPriority::cases(),
            'statusCounts' => $statusCounts,
        ]);
    }

    public function create(Request $request): View
    {
        return view('service-orders.create', array_merge(
            $this->formData(),
            ['selectedCustomerId' => $request->integer('customer_id')],
        ));
    }

    public function store(StoreServiceOrderRequest $request): RedirectResponse
    {
        $serviceOrder = DB::transaction(function () use ($request): ServiceOrder {
            $serviceOrder = ServiceOrder::create($request->validated());
            $serviceOrder->update([
                'number' => 'OS-'.str_pad((string) $serviceOrder->id, 6, '0', STR_PAD_LEFT),
                'completed_at' => $serviceOrder->status === ServiceOrderStatus::Completed ? now() : null,
            ]);

            $this->recordUpdate($serviceOrder, null, 'Ordem de serviço criada.');

            return $serviceOrder;
        });

        return redirect()->route('service-orders.show', $serviceOrder)
            ->with('success', 'Ordem de serviço criada com sucesso.');
    }

    public function show(ServiceOrder $serviceOrder): View
    {
        $serviceOrder->load([
            'customer',
            'assignedTechnician:id,name,email',
            'updates' => fn ($query) => $query->with('user:id,name')->latest(),
        ]);

        return view('service-orders.show', compact('serviceOrder'));
    }

    public function edit(ServiceOrder $serviceOrder): View
    {
        return view('service-orders.edit', array_merge(['serviceOrder' => $serviceOrder], $this->formData()));
    }

    public function update(UpdateServiceOrderRequest $request, ServiceOrder $serviceOrder): RedirectResponse
    {
        $previousStatus = $serviceOrder->status->value;
        $serviceOrder->update($request->validated());
        $newStatus = $serviceOrder->status->value;
        $serviceOrder->update([
            'completed_at' => $newStatus === ServiceOrderStatus::Completed->value
                ? ($serviceOrder->completed_at ?? now())
                : null,
        ]);

        if ($previousStatus !== $newStatus) {
            $this->recordUpdate($serviceOrder, $previousStatus, 'Dados da ordem atualizados.');
        }

        return redirect()->route('service-orders.show', $serviceOrder)
            ->with('success', 'Ordem de serviço atualizada com sucesso.');
    }

    public function updateStatus(UpdateServiceOrderStatusRequest $request, ServiceOrder $serviceOrder): RedirectResponse
    {
        $previousStatus = $serviceOrder->status->value;
        $data = $request->validated();
        $serviceOrder->update([
            'status' => $data['status'],
            'completed_at' => $data['status'] === ServiceOrderStatus::Completed->value ? now() : null,
        ]);

        if ($previousStatus !== $data['status'] || filled($data['note'] ?? null)) {
            $this->recordUpdate($serviceOrder, $previousStatus, $data['note'] ?? null);
        }

        return back()->with('success', 'Status da ordem atualizado.');
    }

    /** @return array{customers: Collection<int, Customer>, technicians: Collection<int, User>, statuses: array<int, ServiceOrderStatus>, priorities: array<int, ServiceOrderPriority>} */
    private function formData(): array
    {
        return [
            'customers' => Customer::query()->orderBy('name')->get(['id', 'name']),
            'technicians' => User::query()->orderBy('name')->get(['id', 'name']),
            'statuses' => ServiceOrderStatus::cases(),
            'priorities' => ServiceOrderPriority::cases(),
        ];
    }

    private function recordUpdate(ServiceOrder $serviceOrder, ?string $previousStatus, ?string $note): void
    {
        ServiceOrderUpdate::create([
            'service_order_id' => $serviceOrder->id,
            'user_id' => auth()->id(),
            'previous_status' => $previousStatus,
            'status' => $serviceOrder->status->value,
            'note' => $note,
        ]);
    }
}
