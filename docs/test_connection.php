<?php
// Test script to verify database connection and basic functionality

echo "Testing Mismatch Application Setup\n";
echo "==================================\n\n";

// Test 1: Check if required files exist
echo "1. Checking required files...\n";
$required_files = [
    'mismatch/connectvars.php',
    'mismatch/appvars.php',
    'mismatch/index.php',
    'mismatch/login.php',
    'mismatch/signup.php'
];

foreach ($required_files as $file) {
    if (file_exists($file)) {
        echo "   ✓ $file exists\n";
    } else {
        echo "   ✗ $file missing\n";
    }
}

// Test 2: Check database connection
echo "\n2. Testing database connection...\n";
require_once('mismatch/connectvars.php');

try {
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if ($dbc) {
        echo "   ✓ Database connection successful\n";
        
        // Test 3: Check if tables exist
        echo "\n3. Checking database tables...\n";
        $tables = ['mismatch_user', 'mismatch_topic', 'mismatch_category', 'mismatch_response'];
        
        foreach ($tables as $table) {
            $query = "SHOW TABLES LIKE '$table'";
            $result = mysqli_query($dbc, $query);
            if (mysqli_num_rows($result) > 0) {
                echo "   ✓ Table '$table' exists\n";
            } else {
                echo "   ✗ Table '$table' missing\n";
            }
        }
        
        // Test 4: Check sample data
        echo "\n4. Checking sample data...\n";
        $query = "SELECT COUNT(*) as count FROM mismatch_user";
        $result = mysqli_query($dbc, $query);
        $row = mysqli_fetch_array($result);
        echo "   ✓ Found {$row['count']} users in database\n";
        
        // Test 5: Test login with sample user
        echo "\n5. Testing login functionality...\n";
        $test_username = 'sidneyk';
        $test_password = 'sidneyk';
        $query = "SELECT user_id, username FROM mismatch_user WHERE username = '$test_username' AND password = SHA1('$test_password')";
        $result = mysqli_query($dbc, $query);
        
        if (mysqli_num_rows($result) == 1) {
            echo "   ✓ Sample user login test passed\n";
        } else {
            echo "   ✗ Sample user login test failed\n";
        }
        
        mysqli_close($dbc);
    } else {
        echo "   ✗ Database connection failed: " . mysqli_connect_error() . "\n";
    }
} catch (Exception $e) {
    echo "   ✗ Database connection error: " . $e->getMessage() . "\n";
}

// Test 6: Check PHP extensions
echo "\n6. Checking PHP extensions...\n";
$required_extensions = ['mysqli', 'session'];
foreach ($required_extensions as $ext) {
    if (extension_loaded($ext)) {
        echo "   ✓ $ext extension loaded\n";
    } else {
        echo "   ✗ $ext extension not loaded\n";
    }
}

echo "\nSetup test completed!\n";
echo "If all tests passed, you can start the application with:\n";
echo "  ./start_server.sh (Linux/Mac)\n";
echo "  start_server.bat (Windows)\n";
echo "  or manually: cd mismatch && php -S localhost:8000\n";
?> 