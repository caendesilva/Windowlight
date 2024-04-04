<?php

namespace App\Models\Analytics;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
