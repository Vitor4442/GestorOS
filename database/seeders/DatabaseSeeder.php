<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\ServiceOrder;
use App\Models\ServiceOrderUpdate;
use App\Models\User;
use App\ServiceOrderPriority;
use App\ServiceOrderStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $technicians = collect([
            ['name' => 'Ana Souza', 'email' => 'ana@gestoros.test'],
            ['name' => 'Carlos Lima', 'email' => 'carlos@gestoros.test'],
            ['name' => 'Marina Alves', 'email' => 'marina@gestoros.test'],
        ])->map(fn (array $attributes): User => User::factory()->create($attributes));

        User::factory()->create([
            'name' => 'Gestor OS',
            'email' => 'gestor@gestoros.test',
        ]);

        $customers = Customer::factory()->count(8)->create();
        $statuses = [
            ServiceOrderStatus::Open,
            ServiceOrderStatus::InProgress,
            ServiceOrderStatus::WaitingParts,
            ServiceOrderStatus::Completed,
            ServiceOrderStatus::Open,
            ServiceOrderStatus::InProgress,
        ];

        foreach (range(0, 15) as $index) {
            $status = $statuses[$index % count($statuses)];
            $serviceOrder = ServiceOrder::factory()->create([
                'customer_id' => $customers[$index % $customers->count()]->id,
                'assigned_to' => $technicians[$index % $technicians->count()]->id,
                'status' => $status,
                'priority' => $index % 6 === 0 ? ServiceOrderPriority::Urgent : ServiceOrderPriority::Normal,
                'completed_at' => $status === ServiceOrderStatus::Completed ? now()->subDays($index % 5) : null,
                'final_cost' => $status === ServiceOrderStatus::Completed ? fake()->randomFloat(2, 200, 5000) : null,
            ]);

            ServiceOrderUpdate::create([
                'service_order_id' => $serviceOrder->id,
                'user_id' => $technicians[$index % $technicians->count()]->id,
                'status' => $status->value,
                'note' => $status === ServiceOrderStatus::Open ? 'Ordem recebida e aguardando triagem.' : 'Atendimento atualizado pela equipe.',
            ]);
        }
    }
}
