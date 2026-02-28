<?php

use App\Models\User;
use Illuminate\Support\Facades\Crypt;

it('tests if non-logged user can\'t subscribe to plan', function () {
    $monthlySubscriptionId = Crypt::encryptString(env('STRIPE_PRODUCT_ID') . "|" . env('STRIPE_MONTHLY_PRICE_ID'));
    $planSubscriptionUrl = route('plans.select', ['id' => $monthlySubscriptionId], false);
    $response = $this->get($planSubscriptionUrl)->assertRedirect('/login');

    expect($response->status())->toBe(302);
});

it('tests if logged (non-subscribed) user can subscribe to plan', function () {
    $user = User::find(1);

    $monthlySubscriptionId = Crypt::encryptString(env('STRIPE_PRODUCT_ID') . "|" . env('STRIPE_MONTHLY_PRICE_ID'));
    $planSubscriptionUrl = route('plans.select', ['id' => $monthlySubscriptionId], false);
    $response = $this->actingAs($user)->get($planSubscriptionUrl);

    expect($response->status())->toBe(303);
    expect($response->content())->toContain('Redirecting to https://checkout.stripe.com');
});

it('tests if non-logged user can\'t access Subscription Success page', function () {
    $response = $this->get('/subscription/success')->assertRedirect('/login');

    expect($response->status())->toBe(302);
});

it('tests if logged (non-subscribed) user can\'t access Subscription Success page (redirect to plans)', function () {
    $user = User::find(1);
    $response = $this->actingAs($user)->get('/subscription/success')->assertRedirect('/plans');

    expect($response->status())->toBe(302);
});

it('tests if non-logged user can\'t download invoice', function () {
    // not a real invoice since we're only testing the feature access
    $response = $this->get('/invoice/id')->assertRedirect('/login');

    expect($response->status())->toBe(302);
});

it('tests if ogged (non-subscribed) user can\'t download invoice (redirect to plans)', function () {
    // not a real invoice since we're only testing the feature access
    $response = $this->actingAs(User::find(1))->get('/invoice/id')->assertRedirect('/plans');

    expect($response->status())->toBe(302);
});

