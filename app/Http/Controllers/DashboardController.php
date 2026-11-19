<?php

namespace App\Http\Controllers;

use App\Models\ServiceOrder;
use App\ServiceOrderPriority;
use App\ServiceOrderStatus;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $statusCounts = collect(ServiceOrderStatus::cases())
            ->mapWithKeys(fn (ServiceOrderStatus $status): array => [$status->value => ServiceOrder::where('status', $status->value)->count()]);

        $stats = [
            'total' => ServiceOrder::count(),
            'open' => $statusCounts->get(ServiceOrderStatus::Open->value, 0),
            'in_progress' => $statusCounts->get(ServiceOrderStatus::InProgress->value, 0),
            'completed' => $statusCounts->get(ServiceOrderStatus::Completed->value, 0),
            'urgent' => ServiceOrder::where('priority', ServiceOrderPriority::Urgent->value)
                ->whereNotIn('status', [ServiceOrderStatus::Completed->value, ServiceOrderStatus::Cancelled->value])
                ->count(),
        ];

        $recentOrders = ServiceOrder::query()
            ->with(['customer:id,name', 'assignedTechnician:id,name'])
            ->latest()
            ->limit(6)
            ->get();

        return view('dashboard', compact('stats', 'recentOrders'));
    }
}
