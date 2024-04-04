<?php

namespace App\Models\Analytics;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $page URL of the page visited
 * @property string $referrer URL of the page that referred the user
 * @property string $user_agent User agent string of the visitor (only stored for bots)
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
}
