<?php

test('can render about page', function () {
    $response = $this->get('/about');

    $response->assertStatus(200);
});
