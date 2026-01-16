# Spaguettio Landing Page

## Descripción

Landing page moderna para Spaguettio, la primera red social diseñada para parejas verificadas en Puerto Rico. Incluye mockups visuales atractivos de las interfaces desktop (laptop) y mobile (smartphone) sin necesidad de usar imágenes pesadas.

## Características

### 🎨 Mockups CSS-Only
- **Laptop Mockup**: Muestra el dashboard principal con tarjetas de parejas verificadas
  - Marco de laptop realista con efecto 3D
  - Barra de navegador con dots de macOS
  - Dashboard con feed de parejas
  - Hover effect interactivo
  
- **Mobile Mockup**: Smartphone flotante con perfil de pareja
  - Frame de smartphone con notch moderno
  - Animación de flotación suave
  - Interfaz de app móvil completa
  - Stats de conexiones y eventos

### ⚡ Características Técnicas
- **100% CSS**: Sin imágenes pesadas, todo renderizado con CSS
- **Responsive**: Adaptable a desktop (1920px), laptop (1440px), tablet (1024px), y mobile (768px, 375px)
- **Animaciones Suaves**: Floating animation, parallax scroll, hover effects
- **Diseño Moderno**: Dark theme con color de marca #c8ff00 (lime green)

### 📱 Secciones
1. **Hero Section**
   - Grid 60/40 con contenido a la izquierda y mockups a la derecha
   - Título impactante con call-to-action
   - Botones CTA: "Comenzar Ahora" y "Ver Demo"
   - Features: Parejas Verificadas, Eventos Exclusivos, 100% Seguro

2. **Registration Section**
   - Formulario de registro movido del hero
   - Inputs para ambos miembros de la pareja
   - Validación básica con JavaScript

## Archivos

- `home.php` - Landing page HTML principal
- `spaguettio-modern.css` - Estilos CSS con mockups y responsive design
- `spaguettio-modern.js` - JavaScript para animaciones parallax y validación

## Uso

### Desarrollo Local
```bash
# Opción 1: PHP built-in server
php -S localhost:8000

# Opción 2: Python HTTP server
python3 -m http.server 8080

# Luego visita: http://localhost:8080/home.php
```

### Integración con OSSN
Para integrar con Open Source Social Network:
1. Copiar los archivos a la carpeta del theme
2. Modificar `home.php` para usar el sistema de templates de OSSN
3. Registrar la ruta en el componente

## Personalización

### Colores
El color principal de marca está definido como `#c8ff00` en el CSS. Para cambiar:
```css
/* Buscar y reemplazar #c8ff00 con tu color */
.highlight { color: #TU_COLOR; }
.btn-primary { background: #TU_COLOR; }
```

### Contenido de Mockups
Los datos de las parejas en los mockups son ficticios. Para cambiar:
- Desktop: Editar `.mock-card` en `home.php` (líneas ~65-95)
- Mobile: Editar `.profile-header` y `.profile-stats` (líneas ~110-135)

## Responsive Breakpoints

- **Desktop Large**: 1920px+ (diseño completo)
- **Desktop**: 1440px (mockups ligeramente reducidos)
- **Tablet**: 1024px (layout en columna, mockups centrados)
- **Mobile**: 768px (layout vertical, mockups escalados)
- **Mobile Small**: 375px (optimización adicional)

## Animaciones

### Floating Animation
El smartphone flota suavemente con rotación:
```css
@keyframes float {
    0%, 100% { transform: translateY(0px) rotate(2deg); }
    50% { transform: translateY(-20px) rotate(-2deg); }
}
```

### Parallax Scroll
Los mockups se mueven a diferentes velocidades al hacer scroll:
```javascript
desktop.style.transform = `translateY(${scrolled * 0.1}px)`;
mobile.style.transform = `translateY(${scrolled * 0.15}px) rotate(2deg)`;
```

## Testing

✅ Verificado en:
- Chrome/Edge (Desktop & Mobile)
- Firefox
- Safari
- Diferentes resoluciones: 1920px, 1440px, 1024px, 768px, 375px

## Performance

- **Sin imágenes**: Todo CSS, carga instantánea
- **Optimizado**: Animaciones GPU-accelerated con `transform`
- **Lightweight**: ~23KB total (HTML + CSS + JS)

## Créditos

Diseñado y desarrollado para Spaguettio - Red Social para Parejas en Puerto Rico

## Licencia

Custom - Ver LICENSE en el repositorio principal
