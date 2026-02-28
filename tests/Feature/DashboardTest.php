<?php

it('tests if non-logged user can\'t access Dashboard', function () {
    $response = $this->get('/dashboard')->assertRedirect('/login');

    expect($response->status())->toBe(302);
});
