<?php

it('tests if non-logged user can\'t access Plans page', function () {
    $response = $this->get('/plans')->assertRedirect('/login');

    expect($response->status())->toBe(302);
});
