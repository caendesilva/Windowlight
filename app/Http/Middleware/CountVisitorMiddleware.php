<?php

namespace App\Http\Middleware;

use App\Models\Analytics\PageViewEvent;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CountVisitorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->header('X-UptimeRobot') === 'UptimeRobot') {
            return $next($request);
        }

        PageViewEvent::dispatch($request);

        return $next($request);
    }
}
