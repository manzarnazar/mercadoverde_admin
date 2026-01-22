# Server Configuration for Large File Uploads

## Problem
Getting `413 (Content Too Large)` error when uploading addon files.

## Solution

The 413 error occurs at the **web server level** before the request reaches PHP/Laravel. You need to configure your web server to allow larger file uploads.

### For Nginx Servers

Add the following configuration to your Nginx server block (usually in `/etc/nginx/sites-available/your-site` or similar):

```nginx
server {
    # ... your existing configuration ...

    # Increase client body size limit (for file uploads)
    client_max_body_size 1024M;
    
    # Increase buffer sizes for large uploads
    client_body_buffer_size 128k;
    client_header_buffer_size 1k;
    large_client_header_buffers 4 16k;
    
    # Increase timeouts for large file uploads
    client_body_timeout 300s;
    client_header_timeout 300s;
    send_timeout 300s;
    
    # ... rest of your configuration ...
}
```

After making changes, reload Nginx:
```bash
sudo nginx -t  # Test configuration
sudo systemctl reload nginx  # Reload Nginx
```

### For Apache Servers

The `.htaccess` file has already been updated with PHP configuration. However, if you're using Apache, you may also need to update your Apache configuration file (usually `httpd.conf` or in `/etc/apache2/`):

```apache
# In your VirtualHost or main configuration
LimitRequestBody 1073741824  # 1GB in bytes
```

Or add to `.htaccess`:
```apache
php_value upload_max_filesize 1024M
php_value post_max_size 1024M
php_value max_execution_time 300
php_value max_input_time 300
```

After making changes, restart Apache:
```bash
sudo systemctl restart apache2  # or httpd
```

### PHP Configuration

Update your `php.ini` file (location varies by system):
```ini
upload_max_filesize = 1024M
post_max_size = 1024M
max_execution_time = 300
max_input_time = 300
memory_limit = 512M
```

After updating `php.ini`, restart your PHP-FPM service:
```bash
sudo systemctl restart php-fpm  # or php8.1-fpm, php8.2-fpm, etc.
```

### For Shared Hosting / cPanel

1. **cPanel**: Go to "Select PHP Version" → "Options" → Increase `upload_max_filesize` and `post_max_size`
2. **Contact your hosting provider** to increase Nginx/Apache limits if you don't have server access

### Verification

After making changes, check your PHP configuration:
```php
<?php
phpinfo();
// Look for upload_max_filesize and post_max_size
```

Or check via command line:
```bash
php -i | grep -E "upload_max_filesize|post_max_size"
```

## Application-Level Changes

The following changes have been made to the application:

1. ✅ Created `IncreaseUploadSize` middleware to set PHP limits
2. ✅ Applied middleware to the upload route
3. ✅ Updated `.htaccess` with PHP configuration
4. ✅ Updated `AddonController` to set PHP limits

However, **these won't help if the web server rejects the request first**. You must configure your web server (Nginx/Apache) as described above.
