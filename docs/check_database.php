<?php
// Check database structure
echo "Checking Database Structure\n";
echo "==========================\n\n";

require_once('mismatch/connectvars.php');

try {
    $dbc = new SQLite3(DB_PATH);
    
    // Check user table structure
    echo "User table structure:\n";
    $query = "PRAGMA table_info(mismatch_user)";
    $result = $dbc->query($query);
    
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        echo "  {$row['name']} - {$row['type']}";
        if ($row['notnull']) echo " NOT NULL";
        if ($row['pk']) echo " PRIMARY KEY";
        if ($row['dflt_value']) echo " DEFAULT {$row['dflt_value']}";
        echo "\n";
    }
    
    // Check if we can insert a test record
    echo "\nTesting insert functionality:\n";
    $test_username = 'testuser_' . time();
    $test_password = 'testpass';
    
    $query = "INSERT INTO mismatch_user (username, password, join_date) VALUES ('$test_username', '$test_password', datetime('now'))";
    $result = $dbc->exec($query);
    
    if ($result !== false) {
        echo "✓ Insert test successful\n";
        
        // Clean up
        $query = "DELETE FROM mismatch_user WHERE username = '$test_username'";
        $dbc->exec($query);
        echo "✓ Cleanup successful\n";
    } else {
        echo "✗ Insert test failed: " . $dbc->lastErrorMsg() . "\n";
    }
    
    // Check current user count
    $query = "SELECT COUNT(*) as count FROM mismatch_user";
    $result = $dbc->query($query);
    $row = $result->fetchArray(SQLITE3_ASSOC);
    echo "Current user count: {$row['count']}\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

$dbc->close();
?> 