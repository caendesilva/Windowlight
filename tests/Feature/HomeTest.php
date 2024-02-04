<?php

test('can render index page', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});
