# Spaguettio - Social Network Platform

Welcome to the Spaguettio repository! This repository contains custom components and themes for the Spaguettio social network platform, built on OSSN (Open Source Social Network).

## 📁 Repository Contents

### 🎨 Themes

#### Spaguettio Modern Theme (`themes/spaguettio-modern/`)
A modern landing page theme with neon design aesthetic for non-logged users.

**Features:**
- Modern black background with neon lime-yellow accent (#c8ff00)
- Animated rotating circle and smooth transitions
- Fully responsive design (mobile, tablet, desktop)
- Integrated OSSN registration form
- 6 feature cards, statistics section, and comprehensive footer
- Only displays to non-logged users

**Documentation:**
- [Theme README](themes/spaguettio-modern/README.md)
- [Installation Guide](INSTALLATION_GUIDE.md)
- [Visual Mockup](VISUAL_MOCKUP.md)
- [Implementation Summary](IMPLEMENTATION_SUMMARY.md)

### 💑 Components

#### Couples Component (`couples/`)
A relationship verification system for couples on Spaguettio.

**Features:**
- Couple relationship requests and management
- Profile integration for couple status
- Verification system
- Bilingual support (English/Spanish)

**Files:**
- Actions: `accept.php`, `remove.php`, `request.php`
- Classes: `Couples.php`
- Locales: `ossn.en.php`, `ossn.es.php`
- Views: Profile edit block, requests page, suggestions

## 🚀 Quick Start

### For the Modern Theme

1. **Copy Theme to OSSN:**
   ```bash
   cp -r themes/spaguettio-modern /path/to/ossn/themes/
   ```

2. **Activate Theme:**
   - Log in to OSSN Admin Panel
   - Navigate to Themes
   - Enable "Spaguettio Modern"

3. **Verify:**
   - Log out and view your site
   - You should see the modern landing page

For detailed installation instructions, see [INSTALLATION_GUIDE.md](INSTALLATION_GUIDE.md).

### For the Couples Component

1. **Copy Component to OSSN:**
   ```bash
   cp -r couples /path/to/ossn/components/
   ```

2. **Activate Component:**
   - Log in to OSSN Admin Panel
   - Navigate to Components
   - Enable "Couples"

## 📋 Requirements

- OSSN 6.x or higher
- PHP 7.4 or higher
- MySQL 5.6 or higher
- Modern web browser (Chrome 90+, Firefox 88+, Safari 14+, Edge 90+)

## 📖 Documentation

### Theme Documentation
- **[README](themes/spaguettio-modern/README.md)** - Theme overview and features
- **[Installation Guide](INSTALLATION_GUIDE.md)** - Step-by-step installation with troubleshooting
- **[Visual Mockup](VISUAL_MOCKUP.md)** - Layout structure and design specifications
- **[Implementation Summary](IMPLEMENTATION_SUMMARY.md)** - Technical implementation details

### Component Documentation
- See component-specific README files in each component directory

## 🎨 Design System

### Color Palette
```css
Primary:    #c8ff00  /* Neon lime-yellow */
Background: #0a0a0a  /* Deep black */
Cards:      rgba(20, 20, 20, 0.6)  /* Semi-transparent dark */
Text Gray:  #888
Text Light: #e0e0e0
Text White: #ffffff
```

### Typography
- Font Family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto
- Hero Title: 72px / 900 weight / Uppercase
- Section Title: 48px / 900 weight / Uppercase
- Body Text: 14-18px / 400 weight

## 🔧 Development

### Theme Development

**File Structure:**
```
themes/spaguettio-modern/
├── ossn_theme.xml           # Theme metadata
├── ossn_theme.php           # Theme initialization
├── README.md                # Documentation
└── plugins/default/
    ├── js/
    │   └── spaguettio-modern.js      # JavaScript
    └── theme/
        ├── css/
        │   └── spaguettio-modern.css # Styles
        └── page/elements/
            └── home.php              # Landing page
```

**Making Changes:**
1. Edit files in `themes/spaguettio-modern/`
2. Clear OSSN cache (Admin Panel → Clear Cache)
3. Refresh browser to see changes

### Component Development

**File Structure:**
```
couples/
├── ossn_com.xml             # Component metadata
├── ossn_com.php             # Component initialization
├── actions/                 # Form handlers
├── classes/                 # PHP classes
├── locale/                  # Translations
└── plugins/default/couples/ # Views
```

## 🐛 Troubleshooting

### Theme Issues

**Theme not appearing:**
- Check file permissions (755 for directories, 644 for files)
- Verify XML file is valid
- Clear OSSN cache

**Styling not loading:**
- Check CSS file exists and is readable
- Clear browser cache
- Check browser console for errors

**Form not working:**
- Verify OSSN registration is enabled
- Check browser console for JavaScript errors
- Verify OSSN action URLs are correct

For more troubleshooting, see [INSTALLATION_GUIDE.md](INSTALLATION_GUIDE.md).

## 🔒 Security

- All code has been scanned with CodeQL
- No security vulnerabilities found
- OSSN security tokens implemented
- Proper input validation
- HTML escaping applied

## 📊 Performance

- Theme size: ~43 KB (uncompressed)
- No external dependencies
- CSS-only animations (no heavy libraries)
- Vanilla JavaScript (no jQuery required for theme)
- Optimized for fast loading

## 🌐 Browser Support

| Browser | Version | Support |
|---------|---------|---------|
| Chrome  | 90+     | ✅ Full |
| Firefox | 88+     | ✅ Full |
| Safari  | 14+     | ✅ Full |
| Edge    | 90+     | ✅ Full |
| IE 11   | -       | ❌ No   |

## 📱 Responsive Breakpoints

- **Desktop:** 1920px+ (Full 2-column layout)
- **Laptop:** 1200px-1919px (Adjusted grid)
- **Tablet:** 768px-1199px (Stacked sections)
- **Mobile:** 320px-767px (Single column)

## 🤝 Contributing

### Code Style
- Follow OSSN coding conventions
- Use meaningful variable names
- Comment complex logic
- Keep functions small and focused

### Submitting Changes
1. Create a new branch
2. Make your changes
3. Test thoroughly
4. Submit a pull request

## 📄 License

Custom license - Spaguettio Team

## 👥 Authors

- **Spaguettio Team**
- Email: info@spaguettio.com
- Website: https://spaguettio.com

## 🙏 Acknowledgments

- Built on [OSSN](https://www.opensource-socialnetwork.org/) (Open Source Social Network)
- Icons: Emoji icons used for features
- Design inspiration: Modern neon aesthetic

## 📞 Support

For support:
1. Check the documentation first
2. Review [INSTALLATION_GUIDE.md](INSTALLATION_GUIDE.md) for troubleshooting
3. Check OSSN community forums
4. Contact Spaguettio support

## 🗺️ Roadmap

### Planned Features
- [ ] Theme customization panel
- [ ] Additional color schemes
- [ ] More language translations
- [ ] Enhanced animations
- [ ] Newsletter integration
- [ ] Analytics dashboard

### Version History
- **1.0** (2026-01) - Initial release
  - Modern landing page theme
  - Couples component
  - Complete documentation

## 📚 Additional Resources

- [OSSN Documentation](https://www.opensource-socialnetwork.org/wiki)
- [OSSN Community](https://www.opensource-socialnetwork.org/community)
- [PHP Documentation](https://www.php.net/docs.php)
- [CSS Reference](https://developer.mozilla.org/en-US/docs/Web/CSS)

---

**Made with ❤️ for the Spaguettio community**

For the latest updates and releases, visit our GitHub repository.
