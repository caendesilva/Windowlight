<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * This middleware boots the Hyde kernel for routes that require it.
 */
class BootHydeKernelMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Register the Hyde service provider
        app()->register(\App\Providers\HydeServiceProvider::class);

        return $next($request);
    }
}
