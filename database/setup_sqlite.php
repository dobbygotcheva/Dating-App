<?php
// SQLite database setup script for Mismatch application
echo "Setting up Mismatch SQLite database...\n";

require_once('mismatch/connectvars.php');

// Create SQLite database
try {
    $db = new SQLite3(DB_PATH);
    echo "SQLite database created successfully.\n";
} catch (Exception $e) {
    die("Error creating database: " . $e->getMessage() . "\n");
}

// Read and execute SQLite SQL files
$sqlFiles = [
    'mismatch_category.sqlite.sql',
    'mismatch_topic.sqlite.sql',
    'mismatch_user.sqlite.sql',
    'mismatch_response.sqlite.sql'
];

foreach ($sqlFiles as $file) {
    if (file_exists($file)) {
        echo "Importing $file...\n";
        $sql = file_get_contents($file);
        
        // Split SQL into individual statements
        $statements = explode(';', $sql);
        
        foreach ($statements as $statement) {
            $statement = trim($statement);
            if (!empty($statement)) {
                try {
                    $result = $db->exec($statement);
                    if ($result !== false) {
                        echo "Executed statement successfully.\n";
                    } else {
                        echo "Error executing statement: " . $db->lastErrorMsg() . "\n";
                    }
                } catch (Exception $e) {
                    echo "Error executing statement: " . $e->getMessage() . "\n";
                }
            }
        }
    } else {
        echo "Warning: $file not found.\n";
    }
}

echo "SQLite database setup completed!\n";
$db->close();
?> 