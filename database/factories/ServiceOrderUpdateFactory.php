<?php

namespace Database\Factories;

use App\Models\ServiceOrder;
use App\Models\ServiceOrderUpdate;
use App\ServiceOrderStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<ServiceOrderUpdate> */
class ServiceOrderUpdateFactory extends Factory
{
    public function definition(): array
    {
        return [
            'service_order_id' => ServiceOrder::factory(),
            'user_id' => null,
            'previous_status' => null,
            'status' => ServiceOrderStatus::Open->value,
            'note' => fake()->optional()->sentence(),
        ];
    }
}
