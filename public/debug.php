<?php
/**
 * Debug endpoint for troubleshooting
 * Remove this file in production
 */

header('Content-Type: text/plain');

echo "=== Shipment Tracker Debug Info ===\n\n";

// Environment
echo "Environment Variables:\n";
echo "APP_ENV: " . (getenv('APP_ENV') ?: 'NOT SET') . "\n";
echo "APP_DEBUG: " . (getenv('APP_DEBUG') ?: 'NOT SET') . "\n";
echo "DATABASE_URL: " . (getenv('DATABASE_URL') ? 'SET' : 'NOT SET') . "\n";

echo "\n.env file exists: " . (file_exists(__DIR__ . '/../.env') ? 'YES' : 'NO') . "\n";

// Storage directories
echo "\nStorage Directories:\n";
$dirs = [
    'storage' => __DIR__ . '/../storage',
    'storage/logs' => __DIR__ . '/../storage/logs',
    'storage/framework' => __DIR__ . '/../storage/framework',
    'bootstrap/cache' => __DIR__ . '/../bootstrap/cache',
];

foreach ($dirs as $name => $path) {
    $exists = file_exists($path);
    $writable = is_writable($path);
    echo "$name: " . ($exists ? 'EXISTS' : 'MISSING') . " | " . ($writable ? 'WRITABLE' : 'NOT WRITABLE') . "\n";
}

// Database test
echo "\n\nTesting Database Connection...\n";
try {
    $dbUrl = getenv('DATABASE_URL');
    if (!$dbUrl) {
        echo "ERROR: DATABASE_URL not set\n";
    } else {
        echo "DATABASE_URL: " . substr($dbUrl, 0, 50) . "...\n";
        
        // Try to parse the URL
        $parsed = parse_url($dbUrl);
        echo "\nParsed Connection:\n";
        echo "Host: " . ($parsed['host'] ?? 'NOT FOUND') . "\n";
        echo "Port: " . ($parsed['port'] ?? 'NOT FOUND') . "\n";
        echo "User: " . ($parsed['user'] ?? 'NOT FOUND') . "\n";
        echo "Database: " . ltrim($parsed['path'] ?? '', '/') . "\n";
        
        // Try to connect
        if (extension_loaded('pdo_pgsql')) {
            try {
                $dsn = "pgsql:host={$parsed['host']};port={$parsed['port']};dbname=" . ltrim($parsed['path'], '/');
                $pdo = new PDO($dsn, $parsed['user'], $parsed['pass']);
                echo "\n✓ Database connection successful!\n";
            } catch (Exception $e) {
                echo "\n✗ Database connection failed: " . $e->getMessage() . "\n";
            }
        } else {
            echo "\n✗ PDO PostgreSQL extension not loaded\n";
        }
    }
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}

// PHP Extensions
echo "\n\nPHP Extensions:\n";
echo "pdo_pgsql: " . (extension_loaded('pdo_pgsql') ? 'LOADED' : 'NOT LOADED') . "\n";
echo "bcmath: " . (extension_loaded('bcmath') ? 'LOADED' : 'NOT LOADED') . "\n";

// Try to bootstrap Laravel
echo "\n\nBootstrapping Laravel...\n";
try {
    require_once __DIR__ . '/../vendor/autoload.php';
    $app = require_once __DIR__ . '/../bootstrap/app.php';
    echo "✓ Laravel bootstrap successful\n";
} catch (Exception $e) {
    echo "✗ Laravel bootstrap failed: " . $e->getMessage() . "\n";
    echo "\nFull error:\n";
    echo $e;
}

echo "\n=== End Debug Info ===\n";
