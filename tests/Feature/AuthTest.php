<?php

it('tests if non-logged user is redirected to Login page when accessing default route', function() {
    $response = $this->get('/')->assertRedirect('/login');

    expect($response->status())->toBe(302);
});

it('tests if non-logged user can access Login page', function() {
    expect($this->get('/login')->status())->toBe(200);

    expect($this->get('/login')->content())->toContain("Login user 1");
});

it('tests if non-logged user can login', function() {
    $response = $this->get('/login/1');

    // checks if it redirects...
    expect($response->status())->toBe(302);

    $targetUrl = $response->getTargetUrl();

    // ...to either one: plans (non-subscribed user) or dashboard (subscribed user) page
    expect($targetUrl)->toBeIn([
        url('/plans'),
        url('/dashboard'),
    ]);
});