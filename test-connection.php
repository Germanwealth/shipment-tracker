<?php
// Test PostgreSQL connection directly
$url = 'postgresql://postgres:fCSilQKKhYSUPobAWMffNXJGwygLfhwp@gondola.proxy.rlwy.net:42360/railway';

echo "Testing PostgreSQL connection...\n";
echo "DATABASE_URL: $url\n\n";

try {
    $pdo = new PDO($url);
    echo "✓ Connection successful!\n";
    
    // Test a simple query
    $result = $pdo->query("SELECT version();");
    $version = $result->fetch();
    echo "PostgreSQL Version: " . $version[0] . "\n";
    
    // Check if tables exist
    $result = $pdo->query("SELECT table_name FROM information_schema.tables WHERE table_schema = 'public'");
    $tables = $result->fetchAll(PDO::FETCH_COLUMN);
    echo "\nExisting tables:\n";
    if (empty($tables)) {
        echo "  (none - database is empty)\n";
    } else {
        foreach ($tables as $table) {
            echo "  - $table\n";
        }
    }
    
} catch (PDOException $e) {
    echo "✗ Connection failed!\n";
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}
?>
