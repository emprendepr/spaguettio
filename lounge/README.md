# Lounge - Componente de Chat para OSSN

Chat en tiempo real estilo LatinChat integrado con el framework OSSN.

## 🌟 Características

- **Integración total con OSSN**: Usa el layout y sistema de usuarios de OSSN
- **Chat en tiempo real** con actualización cada 2 segundos
- **Nombres automáticos**: Si el usuario está logueado, usa su nombre de OSSN
- **Colores únicos** por usuario
- **9 emoticons** clickeables: 😀 😂 ❤️ 😍 😎 🎉 🔥 👍 🍝
- **Lista de usuarios en línea** con indicador verde
- **Mención de usuarios** haciendo click en su nombre
- **Panel de administración** (solo para administradores de OSSN)
- **Diseño responsive** para móviles
- **Almacenamiento en JSON** (no requiere base de datos adicional)

## 📦 Instalación

1. Copia la carpeta `lounge` a `components/` en tu instalación de OSSN
2. Activa el componente desde el panel de administración de OSSN
3. El chat estará disponible en `/lounge`

## 🔗 URLs

- **Chat**: `http://tu-sitio/lounge`
- **Admin**: `http://tu-sitio/lounge-admin` (solo administradores)

## 📁 Estructura

```
lounge/
├── ossn_com.php              # Archivo principal del componente
├── ossn_com.xml              # Metadatos del componente
├── actions/                  # Acciones AJAX
│   ├── send.php
│   ├── get_messages.php
│   ├── get_users.php
│   └── change_name.php
├── locale/                   # Traducciones
│   ├── ossn.es.php
│   └── ossn.en.php
└── plugins/default/lounge/   # Vistas, CSS y JS
    ├── page.php              # Vista principal
    ├── admin.php             # Vista de admin
    ├── css.php               # Estilos
    └── js.php                # JavaScript
```

## 🎨 Diseño

- Gradiente morado-azul (#667eea → #764ba2)
- Sidebar de 250px con usuarios en línea
- Mensajes propios a la derecha con gradiente
- Mensajes de otros a la izquierda con fondo blanco
- Mensajes del sistema con fondo amarillo
- Totalmente responsive

## ⚙️ Configuración

Los mensajes se almacenan en:
- `ossn_data/components/lounge/lounge_messages.json`
- `ossn_data/components/lounge/lounge_users.json`

Límites por defecto:
- Máximo 100 mensajes en historial
- Timeout de usuarios: 30 segundos
- Longitud máxima de mensaje: 500 caracteres
- Longitud máxima de nombre: 30 caracteres

## 🔐 Seguridad

- Validación de entrada en todos los campos
- Escape HTML para prevenir XSS
- File locking para prevenir race conditions
- Validación de caracteres en nombres de usuario
- Panel de administración solo para admins de OSSN

## 👥 Permisos

- Cualquier usuario (logueado o anónimo) puede usar el chat
- Solo administradores de OSSN pueden acceder al panel de administración
- Los usuarios logueados usan su nombre de OSSN automáticamente

## 🌐 Idiomas

- Español (es)
- Inglés (en)

## 📝 Licencia

MIT License

## 👨‍💻 Autor

Spaguettio Team
