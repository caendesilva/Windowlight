<?php

use App\Models\Analytics\PageViewEvent;

test('can create model', function () {
    $model = PageViewEvent::factory()->create();

    expect($model->id)->toBeInt();
    expect($model->page)->toBeString();
    expect($model->referrer)->toBeString();
    expect($model->user_agent)->toBeString();
});
