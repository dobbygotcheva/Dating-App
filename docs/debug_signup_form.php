<?php
// Debug version of signup form
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "Debug: Starting signup form test\n";

// Test 1: Check if we can include the required files
echo "Test 1: Including required files...\n";

try {
    require_once('appvars.php');
    echo "✓ appvars.php included\n";
} catch (Exception $e) {
    echo "✗ appvars.php failed: " . $e->getMessage() . "\n";
}

try {
    require_once('connectvars.php');
    echo "✓ connectvars.php included\n";
} catch (Exception $e) {
    echo "✗ connectvars.php failed: " . $e->getMessage() . "\n";
}

// Test 2: Check database connection
echo "\nTest 2: Database connection...\n";
try {
    $dbc = new SQLite3(DB_PATH);
    echo "✓ Database connected\n";
    $dbc->close();
} catch (Exception $e) {
    echo "✗ Database connection failed: " . $e->getMessage() . "\n";
}

// Test 3: Check if we can include header
echo "\nTest 3: Header inclusion...\n";
try {
    $page_title = 'Debug Sign Up';
    ob_start();
    require_once('header.php');
    $header_output = ob_get_clean();
    echo "✓ Header included successfully\n";
} catch (Exception $e) {
    echo "✗ Header inclusion failed: " . $e->getMessage() . "\n";
}

echo "\nDebug completed. If all tests passed, the form should work.\n";
?> 