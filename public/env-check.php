<?php
// Simple script to check if environment variables are being read correctly

echo "=== Environment Variable Check ===\n\n";

// Check .env file
echo ".env file contents (first 10 lines):\n";
$env_lines = array_slice(file('.env'), 0, 10);
foreach ($env_lines as $line) {
    if (strpos($line, 'APP_KEY') !== false) {
        echo $line;
    }
}

echo "\n\nPHP $_ENV variables:\n";
echo "APP_KEY from \$_ENV: " . ($_ENV['APP_KEY'] ?? 'NOT SET') . "\n";
echo "APP_ENV from \$_ENV: " . ($_ENV['APP_ENV'] ?? 'NOT SET') . "\n";

echo "\n\nPHP getenv():\n";
echo "APP_KEY from getenv: " . (getenv('APP_KEY') ? "SET (length: " . strlen(getenv('APP_KEY')) . ")" : 'NOT SET') . "\n";
echo "APP_ENV from getenv: " . (getenv('APP_ENV') ? getenv('APP_ENV') : 'NOT SET') . "\n";

echo "\n\nDotenv values (if using php-dotenv):\n";
if (file_exists('.env')) {
    $lines = file('.env');
    $count = 0;
    foreach ($lines as $line) {
        if (strpos($line, 'APP_') === 0 && $count < 5) {
            echo trim($line) . "\n";
            $count++;
        }
    }
}

echo "\n\n=== End ===\n";
?>
