<?php
// Simple test page to debug signup form
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "Testing Signup Page\n";
echo "==================\n\n";

// Test 1: Check if required files exist
echo "1. Checking required files...\n";
$files = ['header.php', 'footer.php', 'appvars.php', 'connectvars.php'];
foreach ($files as $file) {
    if (file_exists($file)) {
        echo "   ✓ $file exists\n";
    } else {
        echo "   ✗ $file missing\n";
    }
}

// Test 2: Check database connection
echo "\n2. Testing database connection...\n";
require_once('connectvars.php');
try {
    $dbc = new SQLite3(DB_PATH);
    echo "   ✓ Database connection successful\n";
    $dbc->close();
} catch (Exception $e) {
    echo "   ✗ Database connection failed: " . $e->getMessage() . "\n";
}

// Test 3: Check if we can include header and footer
echo "\n3. Testing header/footer inclusion...\n";
try {
    $page_title = 'Test Page';
    ob_start();
    require_once('header.php');
    $header_output = ob_get_clean();
    echo "   ✓ Header included successfully\n";
} catch (Exception $e) {
    echo "   ✗ Header inclusion failed: " . $e->getMessage() . "\n";
}

echo "\nTest completed.\n";
?> 