# Installation Guide - Spaguettio Modern Theme

## Quick Start

### Prerequisites
- OSSN (Open Source Social Network) 6.0 or higher installed
- PHP 7.4 or higher
- Access to OSSN admin panel
- FTP/SFTP access or SSH access to your server

### Installation Steps

#### 1. Download the Theme
If you're using this from the repository:
```bash
git clone https://github.com/emprendepr/spaguettio.git
cd spaguettio/themes/spaguettio-modern
```

#### 2. Copy Theme to OSSN Installation

**Option A: Using Command Line (SSH)**
```bash
# Copy the entire theme directory
cp -r /path/to/spaguettio/themes/spaguettio-modern /path/to/your/ossn_data/themes/

# Example:
cp -r ./themes/spaguettio-modern /var/www/html/ossn_data/themes/
```

**Option B: Using FTP/SFTP**
1. Connect to your server using an FTP client (FileZilla, WinSCP, etc.)
2. Navigate to your OSSN data directory (usually `ossn_data/themes/`)
3. Upload the entire `spaguettio-modern` folder
4. Ensure all files are uploaded successfully

**Option C: Using cPanel File Manager**
1. Zip the `spaguettio-modern` folder
2. Upload the zip file to `ossn_data/themes/`
3. Extract the zip file
4. Delete the zip file after extraction

#### 3. Set Correct Permissions
```bash
# Navigate to themes directory
cd /path/to/your/ossn_data/themes/spaguettio-modern

# Set directory permissions
find . -type d -exec chmod 755 {} \;

# Set file permissions
find . -type f -exec chmod 644 {} \;
```

#### 4. Activate the Theme

1. **Login to OSSN Admin Panel**
   - Go to your OSSN site URL
   - Login with your admin credentials

2. **Navigate to Themes**
   - Click on **Administrator** in the top navigation
   - Click on **Themes** in the left sidebar

3. **Activate Spaguettio Modern**
   - Find "Spaguettio Modern" in the list of available themes
   - Click the **Enable** button
   - Wait for confirmation message

4. **Clear Cache**
   - Go to **Administrator** > **Cache**
   - Click **Clear All Cache** button
   - This ensures all CSS and JS files are loaded fresh

#### 5. Verify Installation

1. **Test as Non-Logged-In User**
   - Open a private/incognito browser window
   - Visit your site URL
   - You should see the new modern landing page

2. **Test as Logged-In User**
   - Login with your account
   - You should see the normal OSSN dashboard (not the landing page)

3. **Test Responsiveness**
   - Resize your browser window
   - Test on mobile device
   - Ensure all elements display correctly

## Troubleshooting

### Theme doesn't appear in admin panel

**Solution:**
```bash
# Check file permissions
ls -la /path/to/ossn_data/themes/spaguettio-modern/

# Ensure ossn_theme.xml exists
cat /path/to/ossn_data/themes/spaguettio-modern/ossn_theme.xml

# Check OSSN error logs
tail -f /path/to/ossn/error_log
```

### Styles don't apply after activation

**Solution:**
1. Clear OSSN cache from admin panel
2. Clear browser cache (Ctrl+F5 or Cmd+Shift+R)
3. Check browser console for JavaScript errors (F12)
4. Verify CSS file exists:
   ```bash
   ls -la themes/spaguettio-modern/plugins/default/theme/css/core/spaguettio-modern.css
   ```

### Landing page not showing

**Solution:**
- Landing page only shows for **non-logged-in users**
- Logout or use incognito window to see it
- Check that theme is activated in admin panel

### Registration form doesn't work

**Solution:**
1. Verify OSSN is configured correctly for user registration
2. Check OSSN settings: **Administrator** > **Settings** > **Site Settings**
3. Ensure "Allow users to signup" is enabled
4. Check error logs for PHP errors

### Translations not showing

**Solution:**
```bash
# Verify locale files exist
ls -la themes/spaguettio-modern/plugins/default/locale/

# Should show: ossn.en.php and ossn.es.php

# Check OSSN language setting
# Go to: Administrator > Settings > Basic Settings > Language
```

### White screen or PHP errors

**Solution:**
```bash
# Check PHP error log
tail -f /var/log/php_errors.log

# Or check OSSN error log
tail -f /path/to/ossn/error_log

# Verify PHP syntax
php -l themes/spaguettio-modern/ossn_theme.php
```

## Advanced Configuration

### Changing Colors

Edit `plugins/default/theme/css/core/spaguettio-modern.css`:

```css
:root {
    --bg-primary: #0a0a0a;        /* Change background */
    --accent-primary: #c8ff00;    /* Change accent color */
    --text-primary: #ffffff;      /* Change text color */
}
```

### Customizing Text

Edit locale files:
- English: `plugins/default/locale/ossn.en.php`
- Spanish: `plugins/default/locale/ossn.es.php`

Example:
```php
'spaguettio:hero:title:line5' => 'YOUR CUSTOM TEXT',
```

### Modifying Statistics

Edit `plugins/default/theme/page/layouts/home.php` around line 189:

```php
<div class="spaguettio-stat-number">10K+</div>  <!-- Change this -->
```

### Adding Custom CSS

Create a new file: `plugins/default/theme/css/core/custom.css`

Update `ossn_theme.php`:
```php
ossn_extend_view('css/ossn.default', 'css/core/custom');
```

## Uninstalling

### Complete Removal

1. **Deactivate Theme**
   - Go to OSSN Admin Panel > Themes
   - Activate a different theme (e.g., "GoBlue")

2. **Delete Theme Files**
   ```bash
   rm -rf /path/to/ossn_data/themes/spaguettio-modern
   ```

3. **Clear Cache**
   - Admin Panel > Cache > Clear All Cache

### Temporary Disable

Just activate a different theme from the admin panel. The files remain for future use.

## Support

### Getting Help

1. **Check Documentation**
   - Read README.md in theme directory
   - Check this installation guide

2. **Validate Theme Structure**
   ```bash
   bash themes/spaguettio-modern/validate-theme.sh
   ```

3. **Check Logs**
   - OSSN error log: `/path/to/ossn/error_log`
   - PHP error log: `/var/log/php_errors.log`
   - Web server log: `/var/log/apache2/error.log` or `/var/log/nginx/error.log`

4. **Community Support**
   - Visit https://spaguettio.com
   - Open an issue on GitHub repository

### Reporting Bugs

When reporting issues, include:
- OSSN version
- PHP version
- Theme version
- Browser and version
- Error messages from logs
- Steps to reproduce

## Performance Optimization

### Enable GZIP Compression

Add to `.htaccess`:
```apache
<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE text/css
    AddOutputFilterByType DEFLATE application/javascript
</IfModule>
```

### Browser Caching

Add to `.htaccess`:
```apache
<IfModule mod_expires.c>
    ExpiresActive On
    ExpiresByType text/css "access plus 1 year"
    ExpiresByType application/javascript "access plus 1 year"
</IfModule>
```

### Minify Assets

For production, consider minifying CSS and JS files using tools like:
- UglifyJS for JavaScript
- CSSNano for CSS

## Updates

### Checking for Updates

```bash
cd /path/to/spaguettio
git pull origin main
```

### Applying Updates

1. Backup current theme
2. Download latest version
3. Replace theme files
4. Clear OSSN cache
5. Test thoroughly

---

**Version:** 1.0  
**Last Updated:** 2026-01-16  
**Maintained by:** Spaguettio Team
