<?php

namespace App\Models\Analytics;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $page
 * @property string $referrer
 * @property string $user_agent
 * @property string $anonymous_id
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
