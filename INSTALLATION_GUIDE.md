# Installation Guide: Spaguettio Modern Theme

## Prerequisites

- OSSN 6.x or higher installed and configured
- PHP 7.4 or higher
- Admin access to OSSN installation
- Basic understanding of file system permissions

## Installation Steps

### Method 1: Direct Upload (Recommended)

1. **Download the Theme**
   ```bash
   # If downloading from repository
   git clone https://github.com/emprendepr/spaguettio.git
   cd spaguettio
   ```

2. **Locate Your OSSN Installation**
   ```bash
   # Common locations:
   # /var/www/html/ossn/
   # /home/username/public_html/ossn/
   # C:\xampp\htdocs\ossn\
   ```

3. **Copy Theme Files**
   ```bash
   # Copy the theme directory to OSSN themes folder
   cp -r themes/spaguettio-modern /path/to/ossn/themes/
   
   # Or on Windows:
   xcopy themes\spaguettio-modern C:\path\to\ossn\themes\spaguettio-modern /E /I
   ```

4. **Set Permissions (Linux/Mac)**
   ```bash
   cd /path/to/ossn/themes/spaguettio-modern
   
   # Set directory permissions
   find . -type d -exec chmod 755 {} \;
   
   # Set file permissions
   find . -type f -exec chmod 644 {} \;
   
   # Ensure OSSN can read the files
   chown -R www-data:www-data /path/to/ossn/themes/spaguettio-modern
   ```

5. **Activate the Theme**
   - Log in to OSSN as administrator
   - Navigate to: **Admin Panel** → **Themes**
   - Find "Spaguettio Modern" in the list
   - Click **"Enable"** or **"Activate"**

6. **Verify Installation**
   - Log out of OSSN
   - Open your site in a private/incognito window
   - You should see the new modern landing page

### Method 2: FTP/SFTP Upload

1. **Connect to Your Server**
   - Use an FTP client (FileZilla, Cyberduck, etc.)
   - Connect to your server using your credentials

2. **Navigate to OSSN Themes Directory**
   ```
   /public_html/ossn/themes/
   or
   /var/www/html/ossn/themes/
   ```

3. **Upload Theme Folder**
   - Upload the entire `spaguettio-modern` folder
   - Ensure all subdirectories and files are uploaded

4. **Set Permissions**
   - In your FTP client, set permissions:
     - Folders: 755
     - Files: 644

5. **Activate in Admin Panel**
   - Follow steps 5-6 from Method 1

### Method 3: Manual Installation via cPanel

1. **Access cPanel File Manager**
   - Log in to cPanel
   - Open "File Manager"

2. **Navigate to Themes Directory**
   ```
   public_html/ossn/themes/
   ```

3. **Upload Theme**
   - Click "Upload"
   - Upload a ZIP file of `spaguettio-modern`
   - Extract the ZIP file

4. **Set Permissions**
   - Select the `spaguettio-modern` folder
   - Click "Change Permissions"
   - Set to 755 for folders, 644 for files

5. **Activate in Admin Panel**
   - Follow steps 5-6 from Method 1

## Verification Checklist

After installation, verify these items:

### ✅ File Structure Check
```bash
cd /path/to/ossn/themes/spaguettio-modern

# Verify structure
ls -la
# Should show:
# - ossn_theme.xml
# - ossn_theme.php
# - plugins/
# - README.md

# Verify plugins structure
ls -la plugins/default/
# Should show:
# - js/
# - theme/
```

### ✅ Theme Appears in Admin Panel
1. Go to Admin Panel → Themes
2. "Spaguettio Modern" should be listed
3. If not visible, check:
   - File permissions
   - XML file is valid
   - Cache cleared

### ✅ Landing Page Displays
1. **Test as Non-Logged User:**
   - Open site in incognito/private window
   - Should see modern landing page
   - Check all sections load

2. **Test as Logged User:**
   - Log in to OSSN
   - Should see normal OSSN interface
   - Landing page should NOT appear

### ✅ Functionality Tests
- [ ] Header appears with logo and buttons
- [ ] "Login" button links to login page
- [ ] "Register" button scrolls to form
- [ ] Animated circle rotates
- [ ] Form fields are visible
- [ ] All sections are present
- [ ] Footer displays correctly
- [ ] Responsive on mobile
- [ ] No console errors

## Troubleshooting

### Theme Not Appearing in Admin Panel

**Problem:** Theme doesn't show in Themes list

**Solutions:**
1. Check XML file syntax:
   ```bash
   cat /path/to/ossn/themes/spaguettio-modern/ossn_theme.xml
   ```
   Ensure it's valid XML

2. Check file permissions:
   ```bash
   ls -la /path/to/ossn/themes/spaguettio-modern/
   ```
   Should be readable by web server

3. Clear OSSN cache:
   - Admin Panel → System Settings → Clear Cache
   - Or delete: `/path/to/ossn/cache/*`

4. Check OSSN logs:
   ```bash
   tail -f /path/to/ossn/ossn_data/logs/ossn_error.log
   ```

### Landing Page Not Showing

**Problem:** Theme active but landing page doesn't appear

**Solutions:**
1. Verify you're logged out completely
2. Clear browser cache and cookies
3. Check if `home.php` exists:
   ```bash
   ls -la /path/to/ossn/themes/spaguettio-modern/plugins/default/theme/page/elements/home.php
   ```

4. Check PHP error logs:
   ```bash
   tail -f /var/log/apache2/error.log
   # or
   tail -f /var/log/nginx/error.log
   ```

### CSS Not Loading

**Problem:** Page shows but no styling

**Solutions:**
1. Check CSS file exists:
   ```bash
   ls -la /path/to/ossn/themes/spaguettio-modern/plugins/default/theme/css/spaguettio-modern.css
   ```

2. Verify file permissions (should be 644)

3. Clear OSSN cache

4. Check browser console for 404 errors

5. Verify CSS path in browser:
   ```
   https://yoursite.com/ossn/themes/spaguettio-modern/plugins/default/theme/css/spaguettio-modern.css
   ```

### JavaScript Not Working

**Problem:** Smooth scroll, animations not working

**Solutions:**
1. Check JavaScript file:
   ```bash
   ls -la /path/to/ossn/themes/spaguettio-modern/plugins/default/js/spaguettio-modern.js
   ```

2. Open browser console (F12) and check for errors

3. Verify JS loads:
   ```
   https://yoursite.com/ossn/themes/spaguettio-modern/plugins/default/js/spaguettio-modern.js
   ```

4. Check if jQuery conflicts exist

### Form Not Submitting

**Problem:** Registration form doesn't work

**Solutions:**
1. Verify OSSN registration is enabled:
   - Admin Panel → Settings → User Settings
   - Ensure "Allow users to register" is enabled

2. Check form action URL in browser console

3. Test default OSSN registration to isolate issue

4. Check OSSN logs for form submission errors

### Permission Issues (Linux)

**Problem:** Permission denied errors

**Solutions:**
```bash
# Fix ownership
sudo chown -R www-data:www-data /path/to/ossn/themes/spaguettio-modern

# Fix directory permissions
sudo find /path/to/ossn/themes/spaguettio-modern -type d -exec chmod 755 {} \;

# Fix file permissions
sudo find /path/to/ossn/themes/spaguettio-modern -type f -exec chmod 644 {} \;
```

## Uninstallation

If you need to remove the theme:

1. **Deactivate Theme First**
   - Admin Panel → Themes
   - Activate a different theme (e.g., "Default")

2. **Delete Theme Files**
   ```bash
   rm -rf /path/to/ossn/themes/spaguettio-modern
   ```

3. **Clear Cache**
   - Admin Panel → Clear Cache

## Customization After Installation

### Change Colors

Edit: `/path/to/ossn/themes/spaguettio-modern/plugins/default/theme/css/spaguettio-modern.css`

```css
:root {
    --primary-color: #c8ff00;  /* Change to your color */
    --bg-dark: #0a0a0a;        /* Change background */
}
```

### Update Content

Edit: `/path/to/ossn/themes/spaguettio-modern/plugins/default/theme/page/elements/home.php`

- Hero title (line ~45)
- Services list (line ~60)
- Features descriptions (line ~200)
- Stats numbers (line ~260)
- Footer content (line ~320)

### Update Links

Replace placeholder links (#) with actual URLs in `home.php`:
- Footer links
- Social media links
- Terms and conditions link

## Backup Recommendations

Before installing, backup:

1. **Current Theme (if customized)**
   ```bash
   cp -r /path/to/ossn/themes/current-theme /backup/location/
   ```

2. **Database**
   ```bash
   mysqldump -u username -p database_name > ossn_backup.sql
   ```

3. **OSSN Configuration**
   ```bash
   cp /path/to/ossn/configurations/ossn.config.site.php /backup/location/
   ```

## Support and Updates

### Getting Help

1. Check documentation:
   - `README.md` in theme folder
   - `IMPLEMENTATION_SUMMARY.md`
   - `VISUAL_MOCKUP.md`

2. Check OSSN forums:
   - https://www.opensource-socialnetwork.org/community

3. Review browser console for errors (F12)

4. Check server error logs

### Updating the Theme

When updates are released:

1. Backup current theme folder
2. Replace with new version
3. Clear OSSN cache
4. Test thoroughly
5. Re-apply any customizations

## Performance Optimization

After installation, optimize performance:

1. **Enable OSSN Cache**
   - Admin Panel → System Settings
   - Enable caching if not already enabled

2. **Minify Assets (Optional)**
   ```bash
   # Minify CSS
   csso spaguettio-modern.css -o spaguettio-modern.min.css
   
   # Minify JS
   uglifyjs spaguettio-modern.js -o spaguettio-modern.min.js
   ```
   Then update references in theme files

3. **Enable Gzip Compression**
   Add to `.htaccess`:
   ```apache
   <IfModule mod_deflate.c>
     AddOutputFilterByType DEFLATE text/css text/javascript
   </IfModule>
   ```

4. **Browser Caching**
   Add to `.htaccess`:
   ```apache
   <IfModule mod_expires.c>
     ExpiresActive On
     ExpiresByType text/css "access plus 1 month"
     ExpiresByType application/javascript "access plus 1 month"
   </IfModule>
   ```

## Security Notes

- Keep OSSN updated to latest version
- Use strong admin passwords
- Regular backups
- Monitor error logs
- Keep theme files with proper permissions

## Next Steps

After successful installation:

1. ✅ Customize colors to match your brand
2. ✅ Update content and text
3. ✅ Replace placeholder links
4. ✅ Add actual social media links
5. ✅ Test registration flow
6. ✅ Test on multiple devices
7. ✅ Set up analytics (optional)
8. ✅ Configure email notifications

---

**Congratulations!** Your Spaguettio Modern theme is now installed. Enjoy your new landing page! 🎉
