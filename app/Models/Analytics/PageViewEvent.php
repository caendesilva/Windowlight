<?php

namespace App\Models\Analytics;

use App\Concerns\AnonymizesRequests;
use Database\Factories\Analytics\PageViewEventFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * @property string $page URL of the page visited
 * @property ?string $referrer URL of the page that referred the user
 * @property ?string $user_agent User agent string of the visitor (only stored for bots)
 * @property string $anonymous_id Ephemeral anonymized visitor identifier that cannot be tied to a user
 *
 * @method PageViewEventFactory factory($count = null, $state = [])
 */
class PageViewEvent extends Model
{
    use AnonymizesRequests;
    use HasFactory;

    protected $fillable = [
        'page',
        'referrer',
        'user_agent',
        'anonymous_id',
    ];

    public const UPDATED_AT = null;

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (self $model): void {
            // We only store the domain of the referrer
            if ($model->referrer) {
                $model->referrer = Str::after(parse_url($model->referrer, PHP_URL_HOST), 'www.');
            } else {
                $model->referrer = null;
            }

            // We don't store user agents for non-bot users
            $crawlerKeywords = ['bot', 'crawl', 'spider', 'slurp', 'search', 'yahoo', 'facebook'];

            if (! Str::contains($model->user_agent, $crawlerKeywords, true)) {
                $model->user_agent = null;
            }
        });
    }

    public static function dispatch(Request $request): static
    {
        return static::create([
            'page' => $request->url(),
            'referrer' => $request->header('referer') ?? $request->header('referrer'),
            'user_agent' => $request->userAgent(),
            'anonymous_id' => self::anonymizeRequest($request),
        ]);
    }
}
