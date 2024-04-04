<?php

use App\Concerns\AnonymizesRequests;
use Illuminate\Http\Request;

it('generates the expected anonymized hash', function () {
    // Time travel
    $this->travelTo('2024-01-01 00:00:00');

    // Set the anonymizer salt
    config(['hashing.anonymizer_salt' => 'test-salt']);

    // Create a sample request with mock data
    $request = new Request([], [], [], [], [], [
        'REMOTE_ADDR' => '192.168.1.1',
        'HTTP_USER_AGENT' => 'Test User Agent'
    ]);

    // Invoke the anonymizer function
    $anonymizedHash = Anonymizer::anonymize($request);

    // Assert that the generated anonymized hash matches the expected hash
    expect($anonymizedHash)->toBe('c57c021252ab5746543337d3f7a4d5266a98dd70');
});

it('changes hash daily', function () {
    // Time travel
    $this->travelTo('2024-01-01 00:00:00');

    // Set the anonymizer salt
    config(['hashing.anonymizer_salt' => 'test-salt']);

    // Create a sample request with mock data
    $request = new Request([], [], [], [], [], [
        'REMOTE_ADDR' => '192.168.1.1',
        'HTTP_USER_AGENT' => 'Test User Agent'
    ]);

    // Baseline test
    expect(Anonymizer::anonymize($request))->toBe('c57c021252ab5746543337d3f7a4d5266a98dd70');

    // Time travel 12 hours, and the hash should remain the same
    $this->travel(12)->hours();

    expect(Anonymizer::anonymize($request))->toBe('c57c021252ab5746543337d3f7a4d5266a98dd70');

    // Time travel 24 hours, and the hash should change

    $this->travel(12)->hours();

    expect(Anonymizer::anonymize($request))->toBe('dd92f8b1b8fabfd4145860c16963b67513060043');

    // Time travel another 24 hours, and the hash should change

    $this->travel(24)->hours();

    expect(Anonymizer::anonymize($request))->toBe('49eddcebd1ff9fe60c1db5af1c9040073350ea6a');
});

it('uses proxy headers for IP address', function () {
    $this->travelTo('2024-01-01 00:00:00');
    config(['hashing.anonymizer_salt' => 'test-salt']);

    $request = new Request([], [], [], [], [], [
        'REMOTE_ADDR' => '192.168.1.1',
        'HTTP_X_FORWARDED_FOR' => '192.168.1.10',
        'HTTP_USER_AGENT' => 'Test User Agent'
    ]);

    expect(Anonymizer::anonymize($request))->toBe('d62d82bc69857aa53e08f1e08cf3d1eb1eb7efd8');
});

it('uses the first proxy header for IP address', function () {
    $this->travelTo('2024-01-01 00:00:00');
    config(['hashing.anonymizer_salt' => 'test-salt']);

    $request = new Request([], [], [], [], [], [
        'REMOTE_ADDR' => '192.168.1.1',
        'HTTP_X_FORWARDED_FOR' => ['192.168.1.10', '192.168.1.25'],
        'HTTP_USER_AGENT' => 'Test User Agent'
    ]);

    expect(Anonymizer::anonymize($request))->toBe('d62d82bc69857aa53e08f1e08cf3d1eb1eb7efd8');
});

it('uses the anonymizer salt', function () {
    $this->travelTo('2024-01-01 00:00:00');

    config(['hashing.anonymizer_salt' => 'test-salt']);

    expect(Anonymizer::anonymize(new Request()))->toBe('abd0ae029320727985d7551d8a19dc9187015fdb');

    config(['hashing.anonymizer_salt' => 'another-salt']);

    expect(Anonymizer::anonymize(new Request()))->toBe('2f014adc054742aaa50608725e75ef4dc08f7acd');
});

class Anonymizer
{
    use AnonymizesRequests;

    public static function anonymize(Request $request): string
    {
        return static::anonymizeRequest($request);
     }
}
