<?php

it('renders the Fortify login screen', function () {
    $response = $this->get(route('login'));

    $response->assertOk()
        ->assertSee('Bem-vindo de volta')
        ->assertSee('name="email"', false)
        ->assertSee('name="password"', false);
});

it('renders the registration screen when registration is enabled', function () {
    $response = $this->get(route('register'));

    $response->assertOk()
        ->assertSee('Crie seu acesso')
        ->assertSee('name="password_confirmation"', false);
});

it('renders the password recovery screen', function () {
    $response = $this->get(route('password.request'));

    $response->assertOk()
        ->assertSee('Recupere seu acesso')
        ->assertSee(route('password.email'), false);
});

it('redirects guests to Fortify login when they access the dashboard', function () {
    $response = $this->get(route('dashboard'));

    $response->assertRedirect(route('login'));
});
