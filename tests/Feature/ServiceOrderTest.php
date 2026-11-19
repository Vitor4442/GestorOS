<?php

use App\Models\Customer;
use App\Models\ServiceOrder;
use App\ServiceOrderStatus;

it('renders the dashboard with the current service order metrics', function () {
    ServiceOrder::factory()->count(2)->create();

    $response = $this->get(route('dashboard'));

    $response->assertOk()->assertSee('Visão geral')->assertSee('Ordens recentes');
});

it('creates a service order and records its initial history', function () {
    $customer = Customer::factory()->create();

    $response = $this->post(route('service-orders.store'), [
        'customer_id' => $customer->id,
        'title' => 'Troca de compressor',
        'description' => 'Equipamento não resfria.',
        'status' => ServiceOrderStatus::Open->value,
        'priority' => 'high',
        'estimated_cost' => '850.00',
    ]);

    $serviceOrder = ServiceOrder::query()->first();

    $response->assertRedirect(route('service-orders.show', $serviceOrder));
    $this->assertDatabaseHas('service_orders', [
        'id' => $serviceOrder->id,
        'customer_id' => $customer->id,
        'title' => 'Troca de compressor',
        'number' => 'OS-000001',
    ]);
    $this->assertDatabaseHas('service_order_updates', [
        'service_order_id' => $serviceOrder->id,
        'status' => ServiceOrderStatus::Open->value,
    ]);
});

it('rejects a service order without the required customer and title', function () {
    $response = $this->from(route('service-orders.create'))
        ->post(route('service-orders.store'), []);

    $response->assertRedirect(route('service-orders.create'))->assertSessionHasErrors(['customer_id', 'title']);
    expect(ServiceOrder::count())->toBe(0);
});

it('updates the service order status and appends a history entry', function () {
    $serviceOrder = ServiceOrder::factory()->create(['status' => ServiceOrderStatus::Open]);

    $response = $this->patch(route('service-orders.status', $serviceOrder), [
        'status' => ServiceOrderStatus::InProgress->value,
        'note' => 'Técnico iniciou o diagnóstico.',
    ]);

    $response->assertRedirect();
    expect($serviceOrder->fresh()->status)->toBe(ServiceOrderStatus::InProgress);
    $this->assertDatabaseHas('service_order_updates', [
        'service_order_id' => $serviceOrder->id,
        'previous_status' => ServiceOrderStatus::Open->value,
        'status' => ServiceOrderStatus::InProgress->value,
        'note' => 'Técnico iniciou o diagnóstico.',
    ]);
});
