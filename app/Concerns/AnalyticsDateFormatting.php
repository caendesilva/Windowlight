<?php

namespace App\Concerns;

use Illuminate\Support\Carbon;

trait AnalyticsDateFormatting
{
    public function getCreatedAtAttribute(string $date): Carbon
    {
        // Include the timezone when casting the date to a string
        return Carbon::parse($date)->settings(['toStringFormat' => 'Y-m-d H:i:s T']);
    }
}
