<?php

test('can render examples page', function () {
    $response = $this->get('/examples');

    $response->assertStatus(200);
});
