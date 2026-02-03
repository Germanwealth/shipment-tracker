<?php
/**
 * Quick test endpoint to see if the app is responding
 * This file is public and will show you what's wrong
 */

// Try to bootstrap Laravel
try {
    require_once __DIR__ . '/../bootstrap/app.php';
    
    echo "App bootstrapped successfully!\n\n";
    
    // Try to check database
    $db = app('db');
    $db->statement("SELECT 1");
    echo "Database connected successfully!\n\n";
    
    // Try to load config
    echo "APP_ENV: " . config('app.env') . "\n";
    echo "APP_DEBUG: " . (config('app.debug') ? 'true' : 'false') . "\n";
    echo "APP_KEY set: " . (config('app.key') ? 'yes' : 'NO - THIS IS THE PROBLEM!') . "\n";
    
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n\n";
    echo $e;
}
