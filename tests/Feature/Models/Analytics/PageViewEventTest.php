<?php

use App\Models\Analytics\PageViewEvent;

test('can create model', function () {
    $model = PageViewEvent::factory()->create();

    expect($model)->toBeInstanceOf(PageViewEvent::class)
        ->and($model->exists)->toBeTrue()
        ->and($model->id)->toBeInt()
        ->and($model->page)->toBeString()
        ->and($model->anonymous_id)->toBeString();
});

test('anonymous id is sha1 string', function () {
    $model = PageViewEvent::factory()->create();

    expect($model->anonymous_id)->toBeString()->toHaveLength(40)->toMatch('/^[a-f0-9]{40}$/');
});

test('referrer uses only the domain', function (string $referrer) {
    $model = PageViewEvent::factory()->create([
        'referrer' => $referrer,
    ]);

    expect($model->referrer)->toBeString()->toBe('example.com');
})->with([
    'https://example.com',
    'https://example.com/path',
    'https://example.com/path?query=string',
]);

test('user agents are null for non-bot users', function (string $agent) {
    $model = PageViewEvent::factory()->create([
        'user_agent' => $agent,
    ]);

    expect($model->user_agent)->toBeNull();
})->with('user_agents');

test('user agents are null for non-bot users case insensitively', function (string $agent) {
    $model = PageViewEvent::factory()->create([
        'user_agent' => strtolower($agent),
    ]);

    expect($model->user_agent)->toBeNull();
})->with('user_agents');

test('user agents are stored for bot users', function (string $agent) {
    $model = PageViewEvent::factory()->create([
        'user_agent' => $agent,
    ]);

    expect($model->user_agent)->toBeString()->toBe($agent);
})->with('bot_user_agents');

test('user agents are stored for bot users case insensitively', function (string $agent) {
    $model = PageViewEvent::factory()->create([
        'user_agent' => strtolower($agent),
    ]);

    expect($model->user_agent)->toBeString()->toBe(strtolower($agent));
})->with('bot_user_agents');

/** @noinspection HttpUrlsUsage */
test('referrer domain normalization', function ($url) {
    expect(PageViewEvent::normalizeDomain($url))->toBe('example.com');
})->with([
    'https://example.com',
    'http://example.com',
    'example.com',
    'example.com/path',
    'example.com/path?query=string',
    'www.example.com',
    'www.example.com/path',
    'www.example.com/path?query=string',
    'http://www.example.com',
    'https://www.example.com',
    'http://www.example.com/path',
    'https://www.example.com/path',
]);
