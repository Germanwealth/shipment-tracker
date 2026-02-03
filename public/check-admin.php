<?php
// Check if admin user exists
require_once __DIR__ . '/../bootstrap/app.php';

try {
    $app = require_once __DIR__ . '/../bootstrap/app.php';
    
    $admins = \App\Models\Admin::all();
    echo "Total admins: " . count($admins) . "\n\n";
    
    if (count($admins) > 0) {
        echo "Existing admins:\n";
        foreach ($admins as $admin) {
            echo "- Email: " . $admin->email . " | Name: " . $admin->name . "\n";
        }
    } else {
        echo "No admins found! Creating default admin...\n";
        $admin = \App\Models\Admin::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password123'),
        ]);
        echo "✓ Admin created: " . $admin->email . "\n";
    }
    
    // Test password verification
    echo "\n\nTesting password verification:\n";
    $testAdmin = \App\Models\Admin::where('email', 'admin@example.com')->first();
    if ($testAdmin) {
        $matches = \Illuminate\Support\Facades\Hash::check('password123', $testAdmin->password);
        echo "Password check: " . ($matches ? "✓ VALID" : "✗ INVALID") . "\n";
    }
    
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}
?>
