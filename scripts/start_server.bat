@echo off
echo Starting Mismatch Dating Website...
echo ==================================

REM Check if PHP is installed
php --version >nul 2>&1
if errorlevel 1 (
    echo Error: PHP is not installed or not in PATH. Please install PHP first.
    pause
    exit /b 1
)

REM Check if database setup has been completed
if not exist "database_setup_complete" (
    echo Setting up database...
    php setup_database.php
    if errorlevel 1 (
        echo Error: Database setup failed. Please check your MySQL installation.
        pause
        exit /b 1
    )
    echo. > database_setup_complete
    echo Database setup completed successfully!
)

REM Start PHP development server
echo Starting PHP development server...
echo Visit http://localhost:8000 in your browser
echo Press Ctrl+C to stop the server
echo.

cd mismatch
php -S localhost:8000 