<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\ServiceOrder;
use App\ServiceOrderPriority;
use App\ServiceOrderStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<ServiceOrder> */
class ServiceOrderFactory extends Factory
{
    public function definition(): array
    {
        return [
            'number' => 'OS-'.fake()->unique()->numerify('######'),
            'customer_id' => Customer::factory(),
            'assigned_to' => null,
            'title' => fake()->sentence(4),
            'description' => fake()->optional()->paragraph(),
            'status' => ServiceOrderStatus::Open,
            'priority' => ServiceOrderPriority::Normal,
            'scheduled_at' => fake()->optional()->dateTimeBetween('now', '+15 days'),
            'completed_at' => null,
            'estimated_cost' => fake()->randomFloat(2, 100, 5000),
            'final_cost' => null,
        ];
    }
}
