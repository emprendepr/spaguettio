# Spaguettio Modern Theme

Tema moderno y elegante para Spaguettio con diseño oscuro y acentos neón.

## Descripción

Este tema transforma la landing page de Spaguettio en una experiencia moderna y atractiva, especialmente diseñada para la comunidad swinger. Presenta un diseño oscuro sofisticado con acentos en color lima neón (#c8ff00) y animaciones suaves.

## Características

✨ **Diseño moderno** con colores neón y fondo oscuro (#0a0a0a)
🎨 **Grid background** animado con efectos visuales sutiles
📱 **Totalmente responsive** - funciona en desktop, tablet y móvil
🔐 **Formulario de registro integrado** con validación en tiempo real
💫 **Animaciones suaves** con Intersection Observer
🎯 **Optimizado para conversión** con CTAs estratégicos
⚡ **Sin dependencias externas** - CSS y JavaScript puros
🌐 **Soporte multiidioma** (español incluido)

## Secciones Incluidas

1. **Header fijo** con navegación y logo
2. **Hero section** con título animado y círculo rotatorio
3. **Formulario de registro** con backdrop blur y validación
4. **Features section** con 6 tarjetas de características
5. **Stats section** con estadísticas destacadas
6. **CTA section** para conversión final
7. **Footer completo** con enlaces y redes sociales

## Instalación

### Paso 1: Copiar archivos

Copia la carpeta `themes/spaguettio-modern` a tu instalación de OSSN:

```bash
# Si estás en un servidor
cp -r themes/spaguettio-modern /ruta/a/tu/ossn_data/themes/

# O usa FTP/SFTP para subir la carpeta completa
```

### Paso 2: Activar el tema

1. Inicia sesión como administrador en tu sitio OSSN
2. Ve a **Panel de Administración** > **Configuración** > **Temas**
3. Busca "Spaguettio Modern" en la lista de temas disponibles
4. Haz clic en **Activar**

### Paso 3: Limpiar caché

1. Ve a **Panel de Administración** > **Configuración** > **Caché**
2. Haz clic en **Limpiar toda la caché**

### Paso 4: Verificar

1. Cierra sesión o abre una ventana de incógnito
2. Visita tu sitio - deberías ver la nueva landing page moderna
3. Los usuarios logueados verán el dashboard normal de OSSN

## Estructura de Archivos

```
themes/spaguettio-modern/
├── ossn_theme.php                    # Inicialización del tema
├── ossn_theme.xml                    # Metadata del tema
├── plugins/
│   └── default/
│       ├── theme/
│       │   ├── page/
│       │   │   └── layouts/
│       │   │       └── home.php      # Layout del landing page
│       │   └── css/
│       │       └── core/
│       │           └── spaguettio-modern.css  # Estilos principales
│       ├── js/
│       │   └── spaguettio-modern.js  # JavaScript para animaciones
│       └── locale/
│           └── ossn.es.php           # Traducciones en español
└── README.md                         # Este archivo
```

## Personalización

### Cambiar colores

Edita las variables CSS en `spaguettio-modern.css`:

```css
:root {
    --bg-primary: #0a0a0a;           /* Fondo principal */
    --accent-primary: #c8ff00;       /* Color de acento */
    --text-primary: #ffffff;         /* Texto principal */
    --text-secondary: #888888;       /* Texto secundario */
}
```

### Modificar textos

Edita las traducciones en `plugins/default/locale/ossn.es.php`:

```php
'spaguettio:hero:title:line1' => 'TU TEXTO AQUÍ',
```

### Cambiar estadísticas

Edita el archivo `plugins/default/theme/page/layouts/home.php` y busca la sección de estadísticas.

## Compatibilidad

- ✅ OSSN 6.x o superior
- ✅ PHP 7.4 o superior
- ✅ Todos los navegadores modernos (Chrome, Firefox, Safari, Edge)
- ✅ Compatible con el componente "couples"
- ✅ Compatible con otros componentes de OSSN

## Funcionalidades JavaScript

### Smooth Scroll
Navegación suave entre secciones del landing page.

### Validación de Formularios
- Validación en tiempo real de campos
- Verificación de contraseñas coincidentes
- Validación de formato de email
- Feedback visual de errores

### Animaciones
- Intersection Observer para fade-in de elementos
- Parallax sutil en el hero section
- Animaciones de interacción en botones

### Efectos Visuales
- Círculo rotatorio en hero
- Grid background pulsante
- Hover effects en tarjetas

## Solución de Problemas

### El tema no aparece en la lista
- Verifica que la carpeta esté en `ossn_data/themes/`
- Verifica que `ossn_theme.xml` exista y sea válido
- Limpia la caché de OSSN

### Los estilos no se aplican
- Limpia la caché del navegador (Ctrl+F5)
- Limpia la caché de OSSN desde el admin panel
- Verifica que el archivo CSS exista en la ruta correcta

### El formulario no funciona
- Verifica que las rutas de OSSN estén configuradas correctamente
- Asegúrate de que el token de seguridad se esté generando
- Revisa los logs de error de OSSN

### La landing page no se muestra
- Solo se muestra para usuarios NO logueados
- Verifica que el tema esté activado
- Revisa que `home.php` esté en la ruta correcta

## Soporte

Para problemas o preguntas:
- Abre un issue en el repositorio de GitHub
- Contacta al equipo de Spaguettio en https://spaguettio.com

## Créditos

**Desarrollado por:** Spaguettio Team  
**Diseño:** Inspirado en diseños modernos con estética neón  
**Versión:** 1.0  
**Licencia:** Custom

## Changelog

### Versión 1.0 (2026-01-16)
- ✨ Lanzamiento inicial
- 🎨 Diseño completo de landing page
- 📱 Responsive design implementado
- 🔐 Formulario de registro integrado
- 💫 Animaciones y efectos visuales
- 🌐 Traducciones en español

---

**¡Disfruta de tu nuevo tema moderno para Spaguettio!** 🎉
