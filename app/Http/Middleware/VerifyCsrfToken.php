<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '*',  // Disable CSRF for all routes temporarily
    ];
    
    public function handle($request, \Closure $next)
    {
        error_log("VerifyCsrfToken middleware - request path: " . $request->path());
        // Just pass through without verifying
        return $next($request);
    }
}


