<?php
// Simple test for homepage
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "Testing Homepage\n";
echo "================\n\n";

// Test 1: Check if index.php exists
if (file_exists('index.php')) {
    echo "✓ index.php exists\n";
} else {
    echo "✗ index.php missing\n";
}

// Test 2: Check if required files exist
$required_files = ['startsession.php', 'header.php', 'appvars.php', 'connectvars.php', 'navmenu.php', 'footer.php'];
foreach ($required_files as $file) {
    if (file_exists($file)) {
        echo "✓ $file exists\n";
    } else {
        echo "✗ $file missing\n";
    }
}

// Test 3: Test database connection
echo "\nTesting database connection...\n";
require_once('connectvars.php');
try {
    $dbc = new SQLite3(DB_PATH);
    echo "✓ Database connection successful\n";
    
    // Test query
    $query = "SELECT COUNT(*) as count FROM mismatch_user";
    $result = $dbc->query($query);
    $row = $result->fetchArray(SQLITE3_ASSOC);
    echo "✓ Found {$row['count']} users in database\n";
    
    $dbc->close();
} catch (Exception $e) {
    echo "✗ Database connection failed: " . $e->getMessage() . "\n";
}

echo "\nTest completed. If all tests passed, try accessing http://localhost:8000\n";
?> 