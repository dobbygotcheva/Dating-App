<?php
// Database setup script for Mismatch application
echo "Setting up Mismatch database...\n";

// Database connection parameters
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'mismatchdb';

// Create connection
$conn = new mysqli($host, $user, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Connected to MySQL successfully.\n";

// Create database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS $database";
if ($conn->query($sql) === TRUE) {
    echo "Database '$database' created successfully or already exists.\n";
} else {
    echo "Error creating database: " . $conn->error . "\n";
}

// Select the database
$conn->select_db($database);

// Read and execute SQL files
$sqlFiles = [
    'mismatch_user.sql',
    'mismatch_topic.sql', 
    'mismatch_category.sql',
    'mismatch_response.sql'
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
                if ($conn->query($statement) === TRUE) {
                    echo "Executed statement successfully.\n";
                } else {
                    echo "Error executing statement: " . $conn->error . "\n";
                }
            }
        }
    } else {
        echo "Warning: $file not found.\n";
    }
}

echo "Database setup completed!\n";
$conn->close();
?> 