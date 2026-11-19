<?php

use App\Models\Customer;

it('creates a customer and redirects to its profile', function () {
    $response = $this->post(route('customers.store'), [
        'name' => 'Maria Oliveira',
        'company' => 'Oliveira & Filhos',
        'email' => 'maria@example.com',
        'phone' => '(11) 99999-0000',
    ]);

    $customer = Customer::query()->first();

    $response->assertRedirect(route('customers.show', $customer));
    $this->assertDatabaseHas('customers', [
        'id' => $customer->id,
        'name' => 'Maria Oliveira',
        'email' => 'maria@example.com',
    ]);
});

it('escapes customer content in the profile page', function () {
    $customer = Customer::factory()->create([
        'name' => "<script>alert('x')</script>",
    ]);

    $response = $this->get(route('customers.show', $customer));

    $response->assertOk()->assertSee('&lt;script&gt;', false)->assertDontSee("<script>alert('x')</script>", false);
});

it('does not delete a customer that has service orders', function () {
    $customer = Customer::factory()->create();
    $customer->serviceOrders()->create([
        'title' => 'Atendimento existente',
        'status' => 'open',
        'priority' => 'normal',
    ]);

    $response = $this->delete(route('customers.destroy', $customer));

    $response->assertRedirect()->assertSessionHas('error');
    $this->assertDatabaseHas('customers', ['id' => $customer->id]);
});
