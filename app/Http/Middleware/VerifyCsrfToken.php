<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'admin/login',
    ];
    
    public function handle($request, \Closure $next)
    {
        error_log(">>> CSRF Middleware called for " . $request->path());
        // If the request path is in the except list, skip CSRF check
        if (in_array($request->path(), $this->except)) {
            error_log(">>> CSRF SKIPPED for " . $request->path());
            return $next($request);
        }
        
        error_log(">>> CSRF CHECK for " . $request->path());
        // Otherwise call parent CSRF verification
        return parent::handle($request, $next);
    }
}


