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
        'admin/login',  // Allow login POST without CSRF (no leading slash)
    ];

    public function handle($request, \Closure $next)
    {
        error_log("VerifyCsrfToken: Request path = '" . $request->path() . "' | isPost = " . ($request->isMethod('post') ? 'true' : 'false'));
        
        // Skip CSRF for login POST requests
        if ($request->isMethod('post') && $request->path() === 'admin/login') {
            error_log("VerifyCsrfToken: Skipping CSRF for admin/login POST");
            return $next($request);
        }
        
        // For all other requests, verify CSRF token
        return parent::handle($request, $next);
    }
}


