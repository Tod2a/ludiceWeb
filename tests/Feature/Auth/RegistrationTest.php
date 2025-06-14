<?php

use App\Models\Role;

beforeEach(function () {
    Role::create(['name' => Role::MASTER]);
    Role::create(['name' => Role::ADMIN]);
    Role::create(['name' => Role::USER]);
});

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

test('new users can register', function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'PasZgdmSdQsDfT12*',
        'policy_accepted' => true,
        'password_confirmation' => 'PasZgdmSdQsDfT12*',
    ]);

    $response->assertRedirect(route('connected.homepage', absolute: false));

    $this->get('/library')->assertRedirect(route('verification.notice', absolute: false));
});
