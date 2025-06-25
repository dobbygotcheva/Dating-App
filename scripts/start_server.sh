#!/bin/bash

echo "Starting Mismatch Dating Website..."
echo "=================================="

# Check if PHP is installed
if ! command -v php &> /dev/null; then
    echo "Error: PHP is not installed. Please install PHP first."
    exit 1
fi

# Check if MySQL is running
if ! command -v mysql &> /dev/null; then
    echo "Warning: MySQL command not found. Make sure MySQL is installed and running."
fi

# Run database setup if it hasn't been done
if [ ! -f "database_setup_complete" ]; then
    echo "Setting up database..."
    php setup_database.php
    if [ $? -eq 0 ]; then
        touch database_setup_complete
        echo "Database setup completed successfully!"
    else
        echo "Error: Database setup failed. Please check your MySQL installation."
        exit 1
    fi
fi

# Start PHP development server
echo "Starting PHP development server..."
echo "Visit http://localhost:8000 in your browser"
echo "Press Ctrl+C to stop the server"
echo ""

cd mismatch
php -S localhost:8000 