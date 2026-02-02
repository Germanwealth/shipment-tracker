<?php
// Simple database connection test
$dsn = "pgsql:host=gondola.proxy.rlwy.net;port=42360;dbname=railway;user=postgres;password=fCSilQKKhYSUPobAWMffNXJGwygLfhwp";

try {
    $pdo = new PDO($dsn);
    echo "✓ Database connection successful!\n";
    
    // Test a simple query
    $result = $pdo->query("SELECT version()");
    $version = $result->fetch();
    echo "PostgreSQL version: " . $version[0] . "\n";
    
} catch (PDOException $e) {
    echo "✗ Database connection failed!\n";
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}
?>
