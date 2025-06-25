<?php
// Simple test for signup functionality
echo "Testing Signup Functionality\n";
echo "============================\n\n";

require_once('mismatch/connectvars.php');

try {
    $dbc = new SQLite3(DB_PATH);
    echo "✓ Database connected\n";
    
    // Test inserting a new user
    $test_username = 'testuser_' . time();
    $test_password = 'testpass';
    
    $query = "INSERT INTO mismatch_user (username, password, join_date) VALUES ('$test_username', '$test_password', datetime('now'))";
    $result = $dbc->exec($query);
    
    if ($result !== false) {
        echo "✓ User insertion successful\n";
        
        // Verify the user was inserted
        $query = "SELECT * FROM mismatch_user WHERE username = '$test_username'";
        $result = $dbc->query($query);
        if ($result && $result->fetchArray()) {
            echo "✓ User verification successful\n";
        } else {
            echo "✗ User verification failed\n";
        }
        
        // Clean up
        $query = "DELETE FROM mismatch_user WHERE username = '$test_username'";
        $dbc->exec($query);
        echo "✓ Test user cleaned up\n";
        
        echo "\n✅ Signup functionality is working correctly!\n";
    } else {
        echo "✗ User insertion failed: " . $dbc->lastErrorMsg() . "\n";
    }
    
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
}

$dbc->close();
?> 