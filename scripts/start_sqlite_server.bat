@echo off
echo Starting Mismatch Dating Website (SQLite Version)...
echo ==================================================

REM Check if PHP is installed
php --version >nul 2>&1
if errorlevel 1 (
    echo Error: PHP is not installed or not in PATH. Please install PHP first.
    pause
    exit /b 1
)

REM Check if SQLite database setup has been completed
if not exist "sqlite_setup_complete" (
    echo Setting up SQLite database...
    php setup_sqlite.php
    if errorlevel 1 (
        echo Error: SQLite database setup failed.
        pause
        exit /b 1
    )
    echo. > sqlite_setup_complete
    echo SQLite database setup completed successfully!
)

REM Test the connection
echo Testing database connection...
php test_sqlite_connection.php

REM Start PHP development server
echo Starting PHP development server...
echo Visit http://localhost:8000 in your browser
echo Press Ctrl+C to stop the server
echo.

cd mismatch
php -S localhost:8000 