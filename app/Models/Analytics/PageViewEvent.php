<?php

namespace App\Models\Analytics;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * @property string $page URL of the page visited
 * @property ?string $referrer URL of the page that referred the user
 * @property ?string $user_agent User agent string of the visitor (only stored for bots)
 * @property string $anonymous_id Ephemeral anonymized visitor identifier that cannot be tied to a user
 */
class PageViewEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'page',
        'referrer',
        'user_agent',
        'anonymous_id',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (self $model): void {
            // We only store the domain of the referrer
            $model->referrer = parse_url($model->referrer, PHP_URL_HOST);

            // We don't store user agents for non-bot users
            $crawlerKeywords = ['bot', 'crawl', 'spider', 'slurp', 'search', 'yahoo', 'facebook'];

            if (! Str::contains($model->user_agent, $crawlerKeywords, true)) {
                $model->user_agent = null;
            }
        });
    }

    public static function dispatch(Request $request): static
    {
        $anonymousId = self::anonymizeRequest($request);

        return static::create([
            'page' => $request->url(),
            'referrer' => $request->header('referer'),
            'user_agent' => $request->userAgent(),
            'anonymous_id' => $anonymousId,
        ]);
    }

    protected static function anonymizeRequest(Request $request): string
    {
        // As we are not interested in tracking users, we generate an ephemeral hash
        // based on the IP, user agent, and a salt to track unique visits per day.
        // This system is designed so that a visitor cannot be tracked across days, nor can it be tied to a specific person.
        // Due to the salting with a secret environment value, it can't be reverse engineered by creating rainbow tables.
        // The current date is also included in the hash in order to make them unique per day.

        $forwardIp = $request->header('X-Forwarded-For');

        if ($forwardIp !== null) {
            // If the request is proxied, we use the first IP in the address list,
            // as the actual IP belongs to the proxy which may change frequently.

            $ip = Str::before($forwardIp, ',');
        } else {
            $ip = $request->ip();
        }

        return sha1($ip . $request->userAgent() . config('hashing.anonymizer_salt'). now()->format('Y-m-d'));
    }
}
