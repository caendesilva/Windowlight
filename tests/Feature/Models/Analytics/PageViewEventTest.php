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
})->with([
    // Faker generated user agents
    'Mozilla/5.0 (Macintosh; PPC Mac OS X 10_6_0 rv:2.0; sl-SI) AppleWebKit/533.46.4 (KHTML, like Gecko) Version/4.0.3 Safari/533.46.4',
    'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_5_2) AppleWebKit/5351 (KHTML, like Gecko) Chrome/40.0.889.0 Mobile Safari/5351',
    'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/532.0 (KHTML, like Gecko) Chrome/97.0.4090.93 Safari/532.0 EdgA/97.01049.41',
    'Mozilla/5.0 (Windows NT 6.0) AppleWebKit/5330 (KHTML, like Gecko) Chrome/39.0.824.0 Mobile Safari/5330',
    'Mozilla/5.0 (compatible; MSIE 11.0; Windows 98; Win 9x 4.90; Trident/4.1)',
    'Mozilla/5.0 (compatible; MSIE 5.0; Windows NT 6.1; Trident/5.1)',
    'Opera/8.69 (X11; Linux x86_64; nl-NL) Presto/2.9.163 Version/10.00',

    // Most common user agents
    'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.3',
    'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.3',
    'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:124.0) Gecko/20100101 Firefox/124.',
    'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Mobile Safari/537.3',
    'Mozilla/5.0 (iPhone; CPU iPhone OS 17_3_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.3.1 Mobile/15E148 Safari/604.',
    'Mozilla/5.0 (Linux; Android 11; SAMSUNG SM-A202F) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/23.0 Chrome/115.0.0.0 Mobile Safari/537.3',
    'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36',
    'Mozilla/5.0 (Macintosh; Intel Mac OS X 14.4; rv:124.0) Gecko/20100101 Firefox/124.0',
    'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36',
    'Mozilla/5.0 (iPhone; CPU iPhone OS 17_4 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/123.0.6312.52 Mobile/15E148 Safari/604.1',
]);

test('user agents are stored for bot users', function (string $agent) {
    $model = PageViewEvent::factory()->create([
        'user_agent' => $agent,
    ]);

    expect($model->user_agent)->toBeString()->toBe($agent);
})->with([
    // Common shorthand user agents
    'Googlebot',
    'Bingbot',
    'Slurp',
    'YandexBot',
    'DuckDuckBot',

    // Case-insensitive
    'googlebot',
    'bingbot',
    'slurp',
    'yandexbot',
    'duckduckbot',

    // Most common full user agents
    'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)',
    'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)',
    'Mozilla/5.0 (compatible; Yahoo! Slurp; http://help.yahoo.com/help/us/ysearch/slurp)',
    'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)',
    'DuckDuckBot/1.0; (+http://duckduckgo.com/duckduckbot.html)',
]);
