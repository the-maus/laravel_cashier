<?php

use App\Models\User;

it('tests if non-logged user can\'t access Plans page', function () {
    $response = $this->get('/plans')->assertRedirect('/login');

    expect($response->status())->toBe(302);
});

it('tests if logged (non-subscribed) user is redirected to Plans page when accessing default route', function () {
    $user = User::find(1);

    $response = $this->actingAs($user)->get('/')->assertRedirect('/plans');

    expect($response->status())->toBe(302);
});

it('tests if logged (non-subscribed) user can access Plans page', function () {
    $user = User::find(1);

    $this->actingAs($user)->get('/plans')->assertOk();
});