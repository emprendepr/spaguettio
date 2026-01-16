# 🍝 Spaguettio Chat

Un sistema de chat en tiempo real estilo LatinChat con diseño retro-moderno para el proyecto Spaguettio.

## 🌟 Características

- **Chat en tiempo real** con actualización automática cada 2 segundos
- **Nombres de usuario** generados automáticamente (Usuario + número aleatorio)
- **Colores únicos** para cada usuario
- **Cambio de nombre** con notificación en el sistema
- **9 emoticons** clickeables: 😀 😂 ❤️ 😍 😎 🎉 🔥 👍 🍝
- **Lista de usuarios en línea** con indicador verde pulsante
- **Mención de usuarios** haciendo click en su nombre (agrega @usuario)
- **Mensajes del sistema** con fondo amarillo
- **Diseño responsive** para dispositivos móviles
- **Sin base de datos** - usa archivos JSON para persistencia
- **Auto-scroll inteligente** - solo cuando el usuario está al final
- **Protección XSS** con escape de HTML

## 📋 Requisitos

- PHP 7.0 o superior
- Sesiones PHP habilitadas
- Permisos de escritura en el directorio del proyecto

## 🚀 Instalación

1. Copia todos los archivos en tu servidor web:
   - `chat.php`
   - `chat-style.css`
   - `chat-script.js`
   - `chat-api.php`

2. Asegúrate de que el directorio tenga permisos de escritura para crear archivos JSON

3. Abre `chat.php` en tu navegador

¡Eso es todo! No requiere configuración adicional ni base de datos.

## 📁 Estructura de Archivos

```
/
├── chat.php              # Página principal del chat
├── chat-style.css        # Estilos CSS con diseño retro-moderno
├── chat-script.js        # JavaScript del cliente
├── chat-api.php          # API backend REST
├── chat_messages.json    # Almacenamiento de mensajes (auto-generado)
└── chat_users.json       # Usuarios activos (auto-generado)
```

## 🎨 Diseño

### Paleta de Colores
- Gradiente principal: `#667eea` → `#764ba2` (morado-azul)
- Mensajes propios: Gradiente morado
- Mensajes otros: Fondo blanco con borde
- Mensajes sistema: Fondo amarillo `#fff9c4`

### Layout
- **Header**: Título y nombre de usuario
- **Sidebar**: Lista de usuarios en línea (250px)
- **Área de chat**: Mensajes con scroll
- **Barra de emoticons**: 9 emojis clickeables
- **Input**: Campo de mensaje + botón enviar

## 🔧 Configuración

Puedes ajustar estos parámetros en `chat-api.php`:

```php
$maxMessages = 100;  // Límite de mensajes históricos
$userTimeout = 30;   // Segundos antes de marcar usuario como inactivo
```

Y en `chat-script.js`:

```javascript
const UPDATE_FREQUENCY = 2000; // Milisegundos entre actualizaciones (2s)
```

## 🛡️ Seguridad

- **Sanitización de entrada**: Todas las entradas son sanitizadas
- **Escape HTML**: Previene ataques XSS
- **Validación de longitud**: Mensajes máx. 500 caracteres, nombres 30 caracteres
- **File locking**: Previene condiciones de carrera en escrituras concurrentes
- **Validación de caracteres**: Nombres solo permiten letras, números y espacios
- **Control de sesiones**: Usuarios autenticados por sesión PHP

## 🧪 Pruebas

Para probar el chat con múltiples usuarios:

1. Abre `chat.php` en un navegador
2. Abre `chat.php` en modo incógnito o en otro navegador
3. Envía mensajes desde ambas ventanas
4. Verifica que aparezcan en tiempo real
5. Prueba cambiar nombres y usar emoticons
6. Click en nombres de usuarios para mencionarlos

## 📱 Responsive

El diseño es completamente responsive:

- **Desktop**: Layout de 3 columnas con sidebar
- **Móvil**: Layout apilado con sidebar horizontal
- **Tablets**: Se adapta automáticamente

## 🔄 API Endpoints

### POST /chat-api.php
- `action=send` - Enviar mensaje
  - Parámetros: `message`
- `action=change_name` - Cambiar nombre
  - Parámetros: `new_name`

### GET /chat-api.php
- `action=get_messages` - Obtener mensajes nuevos
  - Parámetros: `last_id` (opcional)
- `action=get_users` - Obtener usuarios activos

## 📊 Formato de Datos

### Mensaje
```json
{
  "id": 1,
  "username": "Juan",
  "color": "#D2388D",
  "message": "¡Hola!",
  "time": "14:30",
  "timestamp": 1768523820,
  "type": "user"
}
```

### Usuario
```json
{
  "session_id": {
    "username": "Juan",
    "color": "#D2388D",
    "last_activity": 1768523820
  }
}
```

## 🐛 Solución de Problemas

### Los mensajes no se guardan
- Verifica permisos de escritura en el directorio
- Comprueba que PHP puede crear archivos

### Los usuarios no aparecen en línea
- Los usuarios inactivos por más de 30 segundos son removidos automáticamente
- Verifica que JavaScript esté habilitado

### El chat no actualiza en tiempo real
- Asegúrate de que `chat-api.php` sea accesible
- Revisa la consola del navegador para errores

## 📝 Licencia

Este código es parte del proyecto Spaguettio.

## 👨‍💻 Contribuir

Para contribuir al proyecto:

1. Haz fork del repositorio
2. Crea una rama para tu feature
3. Haz commit de tus cambios
4. Envía un pull request

## 🙏 Créditos

Inspirado en el clásico diseño de LatinChat con un toque moderno.
