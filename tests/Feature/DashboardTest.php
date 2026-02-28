<?php

use App\Models\User;

it('tests if non-logged user can\'t access Dashboard', function () {
    $response = $this->get('/dashboard')->assertRedirect('/login');

    expect($response->status())->toBe(302);
});

it('tests if logged (non-subscribed) user can\'t access Dashboard (redirect to plans)', function () {
    $response = $this->actingAs(User::find(1))->get('/dashboard')->assertRedirect('/plans');

    expect($response->status())->toBe(302);
});
