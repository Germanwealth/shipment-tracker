<?php

use Illuminate\Foundation\Application;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function ($middleware) {
        // Force HTTPS in production
        if (config('app.env') === 'production') {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }
    })
    ->withExceptions(function ($exceptions) {
        // Log all exceptions to stderr so they appear in Docker logs
        $exceptions->render(function (Throwable $e) {
            error_log("LARAVEL EXCEPTION: " . get_class($e));
            error_log("Message: " . $e->getMessage());
            error_log("File: " . $e->getFile() . ":" . $e->getLine());
            error_log("Trace: " . $e->getTraceAsString());
            return null; // Let Laravel handle the response
        });
    })
    ->create();

