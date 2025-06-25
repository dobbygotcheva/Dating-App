#!/bin/bash

echo "Starting Mismatch Dating Website (SQLite Version)..."
echo "=================================================="

# Check if PHP is installed
if ! command -v php &> /dev/null; then
    echo "Error: PHP is not installed. Please install PHP first."
    exit 1
fi

# Check if SQLite3 extension is loaded
if ! php -m | grep -q sqlite3; then
    echo "Warning: SQLite3 extension not loaded. Installing..."
    sudo apt update
    sudo apt install php-sqlite3
fi

# Run SQLite database setup if it hasn't been done
if [ ! -f "sqlite_setup_complete" ]; then
    echo "Setting up SQLite database..."
    php setup_sqlite.php
    if [ $? -eq 0 ]; then
        touch sqlite_setup_complete
        echo "SQLite database setup completed successfully!"
    else
        echo "Error: SQLite database setup failed."
        exit 1
    fi
fi

# Test the connection
echo "Testing database connection..."
php test_sqlite_connection.php

# Start PHP development server
echo "Starting PHP development server..."
echo "Visit http://localhost:8000 in your browser"
echo "Press Ctrl+C to stop the server"
echo ""

cd mismatch
php -S localhost:8000 