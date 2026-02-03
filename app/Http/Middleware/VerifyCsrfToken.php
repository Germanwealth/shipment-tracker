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
    
    public function getExcludedPaths()
    {
        // Temporarily log and force admin/login to be excluded
        error_log("=== getExcludedPaths called, returning: " . json_encode($this->except));
        return array_merge($this->except, ['admin/login']);
    }
}


