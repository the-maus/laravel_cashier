<?php

use Illuminate\Support\Facades\Crypt;

it('tests if non-logged user can\'t subscribe to plan', function () {
    $monthlySubscriptionId = Crypt::encryptString(env('STRIPE_PRODUCT_ID') . "|" . env('STRIPE_MONTHLY_PRICE_ID'));
    $planSubscriptionUrl = route('plans.select', ['id' => $monthlySubscriptionId], false);
    $response = $this->get($planSubscriptionUrl)->assertRedirect('/login');

    expect($response->status())->toBe(302);
});

it('tests if non-logged user can\'t access Subscription Success page', function () {
    $response = $this->get('/subscription/success')->assertRedirect('/login');

    expect($response->status())->toBe(302);
});

it('tests if non-logged user can\'t download invoice', function () {
    // not a real invoice since we're only testing the feature access
    $response = $this->get('/invoice/id')->assertRedirect('/login');

    expect($response->status())->toBe(302);
});

