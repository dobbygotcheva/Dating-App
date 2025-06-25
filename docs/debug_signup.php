<?php
// Debug script for signup functionality
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "Debugging Signup Functionality\n";
echo "==============================\n\n";

require_once('mismatch/connectvars.php');

// Test database connection
try {
    $dbc = new SQLite3(DB_PATH);
    echo "✓ Database connection successful\n";
} catch (Exception $e) {
    echo "✗ Database connection failed: " . $e->getMessage() . "\n";
    exit;
}

// Test if we can query the user table
try {
    $query = "SELECT COUNT(*) as count FROM mismatch_user";
    $result = $dbc->query($query);
    if ($result) {
        $row = $result->fetchArray(SQLITE3_ASSOC);
        echo "✓ User table accessible, found {$row['count']} users\n";
    } else {
        echo "✗ Cannot query user table\n";
    }
} catch (Exception $e) {
    echo "✗ Error querying user table: " . $e->getMessage() . "\n";
}

// Test inserting a user
try {
    $test_username = 'testuser_' . time();
    $test_password = 'testpass';
    
    // Check if user exists
    $query = "SELECT * FROM mismatch_user WHERE username = '$test_username'";
    $result = $dbc->query($query);
    if (!$result->fetchArray()) {
        // Insert test user
        $query = "INSERT INTO mismatch_user (username, password, join_date) VALUES ('$test_username', '$test_password', datetime('now'))";
        $result = $dbc->exec($query);
        
        if ($result !== false) {
            echo "✓ Test user insertion successful\n";
            
            // Verify the user was inserted
            $query = "SELECT * FROM mismatch_user WHERE username = '$test_username'";
            $result = $dbc->query($query);
            if ($result->fetchArray()) {
                echo "✓ Test user verification successful\n";
            } else {
                echo "✗ Test user verification failed\n";
            }
            
            // Clean up - delete test user
            $query = "DELETE FROM mismatch_user WHERE username = '$test_username'";
            $dbc->exec($query);
            echo "✓ Test user cleaned up\n";
        } else {
            echo "✗ Test user insertion failed: " . $dbc->lastErrorMsg() . "\n";
        }
    } else {
        echo "✗ Test user already exists\n";
    }
} catch (Exception $e) {
    echo "✗ Error during test user insertion: " . $e->getMessage() . "\n";
}

// Check database file permissions
echo "\nDatabase file info:\n";
if (file_exists(DB_PATH)) {
    echo "✓ Database file exists\n";
    echo "  Size: " . filesize(DB_PATH) . " bytes\n";
    echo "  Permissions: " . substr(sprintf('%o', fileperms(DB_PATH)), -4) . "\n";
    echo "  Writable: " . (is_writable(DB_PATH) ? "Yes" : "No") . "\n";
} else {
    echo "✗ Database file does not exist\n";
}

$dbc->close();
echo "\nDebug completed.\n";
?> 