# Mismatch - Dating Website (SQLite Version)

A PHP-based dating website where "opposites attract" - users can find matches based on their responses to questionnaires. This version uses SQLite for easy setup without requiring a separate database server.

## Features

- User registration and login system
- Profile management with photo uploads
- Questionnaire system for matching
- User profile viewing
- Session management with cookies
- **SQLite database** - No separate database server required!

## Prerequisites

- PHP 7.0 or higher
- PHP SQLite3 extension
- Web server (Apache/Nginx) or PHP built-in server

## Installation

### 1. Install PHP and SQLite Extension

**Ubuntu/Debian:**
```bash
sudo apt update
sudo apt install php php-sqlite3
```

**CentOS/RHEL/Fedora:**
```bash
sudo dnf install php php-sqlite3
# or for older versions: sudo yum install php php-sqlite3
```

**macOS:**
```bash
brew install php
# SQLite3 extension is usually included by default
```

**Windows:**
- Download XAMPP from: https://www.apachefriends.org/
- SQLite3 extension is included by default

### 2. Set Up the Database

Run the SQLite database setup script:

```bash
php setup_sqlite.php
```

This will:
- Create the `mismatch.db` SQLite database file
- Import all the necessary tables and sample data

### 3. Test the Setup

Verify everything is working:

```bash
php test_sqlite_connection.php
```

### 4. Start the Application

#### Option A: Using the Startup Script (Recommended)

**Linux/macOS:**
```bash
./start_sqlite_server.sh
```

**Windows:**
```cmd
start_sqlite_server.bat
```

#### Option B: Manual Start

```bash
cd mismatch
php -S localhost:8000
```

Then visit `http://localhost:8000` in your browser.

## Database Structure

The application uses three main tables in the SQLite database:

- `mismatch_user` - User accounts and profiles
- `mismatch_topic` - Questionnaire topics
- `mismatch_category` - Response categories

The database file is stored as `mismatch/mismatch.db`.

## Sample Users

The database comes with 14 sample users for testing:

- Username: `sidneyk`, Password: `sidneyk`
- Username: `nevilj`, Password: `nevilj`
- Username: `alexc`, Password: `alexc`
- Username: `sdaniels`, Password: `sdaniels`
- And more...

## File Structure

```
mismatch/
├── appvars.php              # Application constants
├── connectvars.php          # SQLite database connection
├── mismatch.db              # SQLite database file
├── index.php               # Home page
├── login.php               # Login page
├── signup.php              # Registration page
├── mymismatch.php          # User dashboard
├── questionnaire.php       # Questionnaire system
├── viewprofile.php         # Profile viewing
├── editprofile.php         # Profile editing
├── logout.php              # Logout functionality
├── startsession.php        # Session management
├── header.php              # Page header
├── footer.php              # Page footer
├── navmenu.php             # Navigation menu
├── style.css               # Stylesheet
└── images/                 # User profile pictures
```

## Advantages of SQLite Version

1. **No Database Server Required** - SQLite is file-based
2. **Easy Setup** - No MySQL installation or configuration needed
3. **Portable** - Database file can be easily backed up or moved
4. **Lightweight** - Perfect for development and small deployments
5. **No Authentication** - No need to manage database users/passwords

## Troubleshooting

### Common Issues:

1. **"SQLite3 extension not loaded"**
   - Install the SQLite3 extension: `sudo apt install php-sqlite3`
   - Restart your web server after installation

2. **"Database file not writable"**
   - Ensure the `mismatch` directory has write permissions
   - Run: `chmod 755 mismatch/`

3. **"Database file not found"**
   - Run the setup script: `php setup_sqlite.php`

4. **"Permission denied"**
   - Make sure the startup script is executable: `chmod +x start_sqlite_server.sh`

### Getting Help:

1. Run the test script: `php test_sqlite_connection.php`
2. Check PHP version: `php -v`
3. Check SQLite3 extension: `php -m | grep sqlite3`
4. Check database file: `ls -la mismatch/mismatch.db`

## Security Notes

- This is a development/demo application
- Passwords are stored in plain text (not recommended for production)
- No input validation or SQL injection protection
- Should not be used in production without security improvements

## Migration from MySQL

If you were previously using the MySQL version:

1. The database structure remains the same
2. All PHP files have been updated to use SQLite
3. No data migration is needed - the setup script creates fresh sample data
4. The application functionality is identical

## License

This is a demo application for educational purposes. 