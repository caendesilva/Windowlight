<?php

use App\Models\Analytics\PageViewEvent;

test('can create model', function () {
    $model = PageViewEvent::factory()->create();

    expect($model)->toBeInstanceOf(PageViewEvent::class)
        ->and($model->exists)->toBeTrue()
        ->and($model->id)->toBeInt()
        ->and($model->page)->toBeString();
});
