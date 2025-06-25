# Quick Installation Guide

## Ubuntu/Debian Linux

1. **Install PHP and MySQL:**
   ```bash
   sudo apt update
   sudo apt install php php-mysqli mysql-server
   ```

2. **Start MySQL service:**
   ```bash
   sudo systemctl start mysql
   sudo systemctl enable mysql
   ```

3. **Set up MySQL root password (if needed):**
   ```bash
   sudo mysql_secure_installation
   ```

4. **Run the setup:**
   ```bash
   php setup_database.php
   php test_connection.php
   ./start_server.sh
   ```

## CentOS/RHEL/Fedora

1. **Install PHP and MySQL:**
   ```bash
   sudo dnf install php php-mysqli mysql-server
   # or for older versions: sudo yum install php php-mysqli mysql-server
   ```

2. **Start MySQL service:**
   ```bash
   sudo systemctl start mysqld
   sudo systemctl enable mysqld
   ```

3. **Set up MySQL root password:**
   ```bash
   sudo mysql_secure_installation
   ```

4. **Run the setup:**
   ```bash
   php setup_database.php
   php test_connection.php
   ./start_server.sh
   ```

## macOS

1. **Install PHP and MySQL using Homebrew:**
   ```bash
   brew install php mysql
   ```

2. **Start MySQL service:**
   ```bash
   brew services start mysql
   ```

3. **Set up MySQL root password:**
   ```bash
   mysql_secure_installation
   ```

4. **Run the setup:**
   ```bash
   php setup_database.php
   php test_connection.php
   ./start_server.sh
   ```

## Windows

1. **Install XAMPP or WAMP:**
   - Download XAMPP from: https://www.apachefriends.org/
   - Or download WAMP from: https://www.wampserver.com/

2. **Start Apache and MySQL services**

3. **Run the setup:**
   ```cmd
   php setup_database.php
   php test_connection.php
   start_server.bat
   ```

## Docker (Alternative)

If you prefer using Docker:

1. **Create a docker-compose.yml file:**
   ```yaml
   version: '3.8'
   services:
     mysql:
       image: mysql:8.0
       environment:
         MYSQL_ROOT_PASSWORD: root
         MYSQL_DATABASE: mismatchdb
       ports:
         - "3306:3306"
       volumes:
         - mysql_data:/var/lib/mysql
     
     php:
       image: php:8.0-apache
       ports:
         - "8000:80"
       volumes:
         - .:/var/www/html
       depends_on:
         - mysql
       command: >
         bash -c "apt-get update && apt-get install -y default-mysql-client
         && docker-php-ext-install mysqli
         && apache2-foreground"

   volumes:
     mysql_data:
   ```

2. **Run with Docker:**
   ```bash
   docker-compose up -d
   ```

3. **Update connectvars.php for Docker:**
   ```php
   define('DB_HOST', 'mysql');
   define('DB_USER', 'root');
   define('DB_PASSWORD', 'root');
   define('DB_NAME', 'mismatchdb');
   ```

## Troubleshooting

### Common Issues:

1. **"Access denied for user 'root'@'localhost'"**
   - Make sure MySQL is running
   - Check if you need to set a root password
   - Try using `sudo mysql` to access MySQL

2. **"Connection refused"**
   - Make sure MySQL service is started
   - Check if MySQL is listening on the correct port

3. **"PHP not found"**
   - Make sure PHP is installed and in your PATH
   - Try `which php` to locate PHP installation

4. **"mysqli extension not loaded"**
   - Install the mysqli extension for PHP
   - On Ubuntu: `sudo apt install php-mysqli`
   - On CentOS: `sudo dnf install php-mysqli`

### Getting Help:

1. Run the test script: `php test_connection.php`
2. Check MySQL status: `sudo systemctl status mysql`
3. Check PHP version: `php -v`
4. Check PHP modules: `php -m | grep mysqli` 