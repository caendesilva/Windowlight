<?php

namespace App\Concerns;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

trait AnonymizesRequests
{
    protected static function anonymizeRequest(Request $request): string
    {
        // As we are not interested in tracking users, we generate an ephemeral hash
        // based on the IP, user agent, and a salt to track unique visits per day.
        // This system is designed so that a visitor cannot be tracked across days, nor can it be tied to a specific person.
        // Due to the salting with a secret environment value, it can't be reverse engineered by creating rainbow tables.
        // The current date is also included in the hash in order to make them unique per day.

        // The hash is made using the SHA-256 algorithm and truncated to 40 characters to save space, as we're not too worried about collisions.

        $forwardIp = $request->header('X-Forwarded-For');

        if ($forwardIp !== null) {
            // If the request is proxied, we use the first IP in the address list,
            // as the actual IP belongs to the proxy which may change frequently.

            $ip = Str::before($forwardIp, ',');
        } else {
            $ip = $request->ip();
        }

        return substr(hash('sha256', $ip.$request->userAgent().config('hashing.anonymizer_salt').now()->format('Y-m-d')), 0, 40);
    }
}
