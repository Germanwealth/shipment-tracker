<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DisableCsrf
{
    public function handle(Request $request, Closure $next)
    {
        error_log("DisableCsrf middleware hit");
        return $next($request);
    }
}
