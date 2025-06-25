# Deployment Guide

This guide will help you deploy the Mismatch Dating Website to a production environment.

## 🚀 Production Deployment

### Prerequisites
- Web server (Apache/Nginx)
- PHP 7.4+ with SQLite3 extension
- SSL certificate (recommended)
- Domain name

### Step 1: Server Setup

#### Apache Configuration
Create a virtual host configuration:

```apache
<VirtualHost *:80>
    ServerName yourdomain.com
    DocumentRoot /var/www/mismatch
    
    <Directory /var/www/mismatch>
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog ${APACHE_LOG_DIR}/mismatch_error.log
    CustomLog ${APACHE_LOG_DIR}/mismatch_access.log combined
</VirtualHost>
```

#### Nginx Configuration
```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /var/www/mismatch;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

### Step 2: File Upload

1. Upload the `mismatch` directory to your web server
2. Set proper permissions:
   ```bash
   chmod 755 /var/www/mismatch
   chmod 777 /var/www/mismatch/images
   chown -R www-data:www-data /var/www/mismatch
   ```

### Step 3: Database Setup

1. Run the database setup script:
   ```bash
   cd /var/www/mismatch
   php database/setup_sqlite.php
   ```

2. Ensure the database file is writable:
   ```bash
   chmod 664 mismatch.db
   chown www-data:www-data mismatch.db
   ```

### Step 4: Security Configuration

#### File Permissions
```bash
# Make sure only necessary files are writable
find /var/www/mismatch -type f -exec chmod 644 {} \;
find /var/www/mismatch -type d -exec chmod 755 {} \;
chmod 777 /var/www/mismatch/images
chmod 664 /var/www/mismatch/mismatch.db
```

#### PHP Configuration
Edit your `php.ini`:
```ini
; Security settings
expose_php = Off
display_errors = Off
log_errors = On
error_log = /var/log/php_errors.log

; File upload settings
upload_max_filesize = 2M
post_max_size = 8M
max_file_uploads = 20

; Session security
session.cookie_httponly = 1
session.cookie_secure = 1
session.use_strict_mode = 1
```

### Step 5: SSL Configuration (Recommended)

#### Let's Encrypt (Free SSL)
```bash
# Install Certbot
sudo apt install certbot python3-certbot-apache

# Get SSL certificate
sudo certbot --apache -d yourdomain.com

# Auto-renewal
sudo crontab -e
# Add: 0 12 * * * /usr/bin/certbot renew --quiet
```

### Step 6: Performance Optimization

#### Enable Caching
Add to your `.htaccess` file:
```apache
# Browser caching
<IfModule mod_expires.c>
    ExpiresActive On
    ExpiresByType image/jpg "access plus 1 month"
    ExpiresByType image/jpeg "access plus 1 month"
    ExpiresByType image/gif "access plus 1 month"
    ExpiresByType image/png "access plus 1 month"
    ExpiresByType text/css "access plus 1 month"
    ExpiresByType application/pdf "access plus 1 month"
    ExpiresByType text/javascript "access plus 1 month"
    ExpiresByType application/javascript "access plus 1 month"
    ExpiresByType application/x-javascript "access plus 1 month"
    ExpiresByType application/x-shockwave-flash "access plus 1 month"
    ExpiresByType image/x-icon "access plus 1 year"
    ExpiresDefault "access plus 2 days"
</IfModule>

# Gzip compression
<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE text/plain
    AddOutputFilterByType DEFLATE text/html
    AddOutputFilterByType DEFLATE text/xml
    AddOutputFilterByType DEFLATE text/css
    AddOutputFilterByType DEFLATE application/xml
    AddOutputFilterByType DEFLATE application/xhtml+xml
    AddOutputFilterByType DEFLATE application/rss+xml
    AddOutputFilterByType DEFLATE application/javascript
    AddOutputFilterByType DEFLATE application/x-javascript
</IfModule>
```

### Step 7: Monitoring

#### Log Monitoring
Set up log rotation:
```bash
# Create logrotate configuration
sudo nano /etc/logrotate.d/mismatch

# Add:
/var/log/mismatch_*.log {
    daily
    missingok
    rotate 52
    compress
    delaycompress
    notifempty
    create 644 www-data www-data
}
```

#### Health Check
Create a health check endpoint:
```php
// Add to your application
<?php
header('Content-Type: application/json');
echo json_encode(['status' => 'healthy', 'timestamp' => date('Y-m-d H:i:s')]);
?>
```

## 🔧 Environment Variables

For production, consider using environment variables:

```php
// config.php
<?php
define('DB_PATH', $_ENV['DB_PATH'] ?? 'mismatch.db');
define('MM_UPLOADPATH', $_ENV['UPLOAD_PATH'] ?? 'images/');
define('MM_MAXFILESIZE', $_ENV['MAX_FILE_SIZE'] ?? 32768);
?>
```

## 🚨 Security Checklist

- [ ] SSL certificate installed
- [ ] File permissions set correctly
- [ ] Error reporting disabled
- [ ] Database file secured
- [ ] Upload directory protected
- [ ] Regular backups configured
- [ ] Log monitoring enabled
- [ ] Firewall configured
- [ ] PHP security settings applied

## 📊 Backup Strategy

### Database Backup
```bash
#!/bin/bash
# backup.sh
DATE=$(date +%Y%m%d_%H%M%S)
cp /var/www/mismatch/mismatch.db /backup/mismatch_$DATE.db
find /backup -name "mismatch_*.db" -mtime +7 -delete
```

### Full Backup
```bash
#!/bin/bash
# full_backup.sh
DATE=$(date +%Y%m%d_%H%M%S)
tar -czf /backup/mismatch_full_$DATE.tar.gz /var/www/mismatch
find /backup -name "mismatch_full_*.tar.gz" -mtime +30 -delete
```

## 🆘 Troubleshooting

### Common Issues

1. **500 Internal Server Error**
   - Check file permissions
   - Review error logs
   - Verify PHP configuration

2. **Database Connection Issues**
   - Ensure SQLite3 extension is installed
   - Check database file permissions
   - Verify database path

3. **File Upload Problems**
   - Check upload directory permissions
   - Verify PHP upload settings
   - Review file size limits

### Log Locations
- Apache: `/var/log/apache2/`
- Nginx: `/var/log/nginx/`
- PHP: `/var/log/php_errors.log`
- Application: `/var/log/mismatch_*.log`

## 📈 Performance Tips

1. **Enable OPcache**
2. **Use CDN for static assets**
3. **Implement database indexing**
4. **Optimize images**
5. **Use caching headers**
6. **Monitor server resources**

---

For additional support, check the main README.md file or open an issue on GitHub. 