<?php
// Test script to verify SQLite database connection and basic functionality

echo "Testing Mismatch SQLite Application Setup\n";
echo "=========================================\n\n";

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

// Test 2: Check SQLite extension
echo "\n2. Checking SQLite extension...\n";
if (extension_loaded('sqlite3')) {
    echo "   ✓ SQLite3 extension loaded\n";
} else {
    echo "   ✗ SQLite3 extension not loaded\n";
    echo "   Install with: sudo apt install php-sqlite3\n";
}

// Test 3: Check database connection
echo "\n3. Testing database connection...\n";
require_once('mismatch/connectvars.php');

try {
    $dbc = new SQLite3(DB_PATH);
    if ($dbc) {
        echo "   ✓ SQLite database connection successful\n";
        
        // Test 4: Check if tables exist
        echo "\n4. Checking database tables...\n";
        $tables = ['mismatch_user', 'mismatch_topic', 'mismatch_category'];
        
        foreach ($tables as $table) {
            $query = "SELECT name FROM sqlite_master WHERE type='table' AND name='$table'";
            $result = $dbc->query($query);
            if ($result && $result->fetchArray()) {
                echo "   ✓ Table '$table' exists\n";
            } else {
                echo "   ✗ Table '$table' missing\n";
            }
        }
        
        // Test 5: Check sample data
        echo "\n5. Checking sample data...\n";
        $query = "SELECT COUNT(*) as count FROM mismatch_user";
        $result = $dbc->query($query);
        $row = $result->fetchArray(SQLITE3_ASSOC);
        echo "   ✓ Found {$row['count']} users in database\n";
        
        // Test 6: Test login with sample user
        echo "\n6. Testing login functionality...\n";
        $test_username = 'sidneyk';
        $test_password = 'sidneyk';
        $query = "SELECT user_id, username FROM mismatch_user WHERE username = '$test_username' AND password = '$test_password'";
        $result = $dbc->query($query);
        
        if ($result && $result->fetchArray()) {
            echo "   ✓ Sample user login test passed\n";
        } else {
            echo "   ✗ Sample user login test failed\n";
        }
        
        $dbc->close();
    } else {
        echo "   ✗ Database connection failed\n";
    }
} catch (Exception $e) {
    echo "   ✗ Database connection error: " . $e->getMessage() . "\n";
}

// Test 7: Check PHP extensions
echo "\n7. Checking PHP extensions...\n";
$required_extensions = ['session'];
foreach ($required_extensions as $ext) {
    if (extension_loaded($ext)) {
        echo "   ✓ $ext extension loaded\n";
    } else {
        echo "   ✗ $ext extension not loaded\n";
    }
}

echo "\nSetup test completed!\n";
echo "If all tests passed, you can start the application with:\n";
echo "  cd mismatch && php -S localhost:8000\n";
echo "Then visit: http://localhost:8000\n";
?> 