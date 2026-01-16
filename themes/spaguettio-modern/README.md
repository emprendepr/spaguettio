# Spaguettio Modern Theme

Modern landing page theme for Spaguettio with neon design aesthetic.

## Features

- **Modern Design**: Black background (#0a0a0a) with neon yellow-green accent (#c8ff00)
- **Grid Background**: Subtle grid pattern for visual depth
- **Animated Elements**: Rotating circle, hover effects, smooth transitions
- **Fully Responsive**: Optimized for desktop, tablet, and mobile devices
- **OSSN Integration**: Fully integrated registration form with OSSN
- **Security**: Only displays to non-logged users

## Installation

1. Copy the `spaguettio-modern` folder to your OSSN themes directory
2. Go to Admin Panel → Themes
3. Find "Spaguettio Modern" and click "Enable"

## File Structure

```
themes/spaguettio-modern/
├── ossn_theme.xml           # Theme metadata
├── ossn_theme.php           # Theme initialization
└── plugins/
    └── default/
        ├── js/
        │   └── spaguettio-modern.js      # Interactive features
        └── theme/
            ├── css/
            │   └── spaguettio-modern.css # Styles
            └── page/
                └── elements/
                    └── home.php          # Landing page template
```

## Sections

### Header
- Logo with Beta badge
- Login button (links to OSSN login page)
- Register button (smooth scrolls to form)

### Hero Section
- Main title with animated circle
- Subtitle and description
- Two CTA buttons
- Service list (6 items)
- Registration form card

### Features Section
- 6 feature cards with icons:
  - 💑 Parejas Verificadas
  - 🔒 Privacidad Total
  - 🌐 Comunidad Global
  - 📸 Galería Privada
  - 📅 Eventos Exclusivos
  - 💬 Chat Seguro

### Stats Section
- 4 statistics:
  - 50K+ Active Members
  - 15K+ Verified Couples
  - 98% Satisfaction
  - 24/7 Support

### CTA Section
- Secondary call-to-action
- Duplicate buttons for conversion

### Footer
- 5 columns with links
- Social media links
- Copyright and OSSN attribution

## Customization

### Colors

Edit the CSS variables in `spaguettio-modern.css`:

```css
:root {
    --primary-color: #c8ff00;    /* Neon accent color */
    --bg-dark: #0a0a0a;          /* Background color */
    --bg-card: rgba(20, 20, 20, 0.6); /* Card background */
    --text-gray: #888;            /* Secondary text */
}
```

### Form Fields

The registration form in `home.php` includes all required OSSN fields:
- firstname, lastname
- email, email_confirm
- username, password
- gender (male/female)
- birthdate
- terms and conditions

## Browser Support

- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+

## Performance

- Minimal dependencies
- CSS-only animations (no heavy libraries)
- Optimized images (when added)
- Lazy loading ready

## Notes

- Theme only shows to **non-logged** users
- Logged users see the default OSSN interface
- Footer links are placeholders (#) - update as needed
- Form submits to OSSN's standard registration handler

## License

Custom license - Spaguettio Team

## Version

1.0 - Initial Release
