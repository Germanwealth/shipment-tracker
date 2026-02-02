<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.json')) {
    $maintenance = json_decode(file_get_contents($maintenance), true);

    if (isset($maintenance['until'])) {
        http_response_code(503);
        header('Retry-After: '.$maintenance['retry']);
        header('Content-Type: application/json');
        exit(json_encode([
            'message' => 'Application is in maintenance mode.',
            'retry_after' => $maintenance['retry'],
        ]));
    }
}

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
*/

require __DIR__.'/../vendor/autoload.php';

error_log("Bootstrap: Vendor autoload loaded");

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
*/

$app = require_once __DIR__.'/../bootstrap/app.php';

error_log("Bootstrap: App created");

$kernel = $app->make(Kernel::class);

error_log("Bootstrap: Kernel created");

$response = $kernel->handle(
    $request = Request::capture()
);

error_log("Bootstrap: Response status: " . $response->getStatusCode());
error_log("Bootstrap: Response headers: " . json_encode($response->headers->all()));

$response->send();

error_log("Bootstrap: Request handled and response sent");

$kernel->terminate($request, $response);
