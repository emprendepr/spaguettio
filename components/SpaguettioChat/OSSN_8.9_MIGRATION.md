# Adaptación de WebChat de OSSN 5.6 a OSSN 8.9

## Diferencias Clave entre OSSN 5.6 y 8.9

### 1. Creación de Tablas

**OSSN 5.6:**
- No había un archivo estándar
- Algunos componentes usaban `schema.php` con funciones install/uninstall

**OSSN 8.9:**
- Usa `enabled.php` para crear tablas cuando el componente se activa
- Ejemplo del WebChat oficial:
```php
$component = new OssnEntities;
$component->statement($query);
$component->execute();
```

### 2. Acceso a Base de Datos

**OSSN 5.6:**
- Podía usar `new OssnDatabase()` directamente
- Métodos menos consistentes

**OSSN 8.9:**
- **Usar `OssnEntities`** en lugar de `OssnDatabase`
- Patrón estándar: `statement() → execute() → fetch()`
```php
$db = new OssnEntities;
$db->statement("SELECT...");
$db->execute();
$result = $db->fetch();      // Una fila
$results = $db->fetch(true); // Múltiples filas
```

### 3. Estructura de Componente

**Archivos requeridos:**
```
ComponentName/
├── ossn_com.xml          # Metadatos del componente
├── ossn_com.php          # Inicialización principal
├── enabled.php           # Creación de tablas (NUEVO en 8.9)
├── classes/              # Clases PHP
├── actions/              # Manejadores de acciones
├── plugins/default/      # Vistas y assets
│   ├── css/
│   ├── js/
│   └── forms/
└── locale/               # Archivos de idioma
```

### 4. Registro de Menús

**Sidebar (igual en ambas versiones):**
```php
ossn_register_sections_menu('newsfeed', array(
    'name' => 'chat',
    'text' => ossn_print('menu:text'),
    'url' => ossn_site_url('chat'),
    'parent' => 'links',
    'icon' => $icon,
));
```

**Admin Topbar:**
```php
ossn_register_menu_link('componentname', 'text', 
    ossn_site_url('admin-page'), 'topbar_admin');
```

### 5. Vistas y Assets

**CSS:**
```php
// En ossn_com.php
ossn_extend_view('css/ossn.default', 'css/component_name');
```

**JavaScript:**
```php
// En ossn_com.php
ossn_extend_view('js/ossn.site', 'js/component_name');
```

### 6. Manejo de Errores

**OSSN 8.9 - Mejores prácticas:**
```php
try {
    $db->statement($query);
    $db->execute();
    $result = $db->fetch();
} catch (Exception $e) {
    // Manejar error
    error_log($e->getMessage());
    return false;
}
```

### 7. Seguridad

**Tokens de seguridad (obligatorio en formularios):**
```php
<?php echo ossn_plugin_view('input/security_token'); ?>
```

**Sanitización:**
```php
$input = input('field_name');  // Ya sanitizado por OSSN
$escaped = $db->escape($string);  // Para queries
```

### 8. Rutas y URLs

**Páginas:**
```php
ossn_register_page('pagename', 'callback_function');
```

**Acciones:**
```php
ossn_register_action('action/name', __COMPONENT__ . 'actions/file.php');
```

## Cambios Aplicados a SpaguettioChat

### ✅ Implementado:

1. **Creado `enabled.php`** con creación de tablas usando OssnEntities
2. **Cambiado de `OssnDatabase` a `OssnEntities`** en todos los archivos
3. **Añadido manejo de excepciones** para consultas de base de datos
4. **Uso correcto de `statement() + execute() + fetch()`**
5. **Registro correcto de menús** en sidebar y admin topbar
6. **Estructura de componente** conforme a OSSN 8.9

### Características Mantenidas del WebChat Original:

- Sistema de salas/grupos
- Mensajes con timestamps
- Sistema de usuarios activos
- Panel de administración
- Gestión de configuraciones

### Características Adicionales en SpaguettioChat:

- **Página de términos y condiciones** antes de entrar
- **Seguimiento de aceptación** de términos por usuario
- **Estadísticas en tiempo real** para administradores
- **Gestión de salas** desde panel admin
- **Limpieza automática** de usuarios inactivos

## Notas de Compatibilidad

- ✅ Compatible con OSSN 8.9
- ✅ Usa OssnEntities para base de datos
- ✅ Sigue convenciones de OSSN modernas
- ✅ Incluye enabled.php para instalación
- ✅ Manejo de errores robusto
- ✅ Tokens de seguridad en formularios

## Instalación

1. Copiar carpeta `SpaguettioChat` a `components/`
2. Ir al panel de administración → Components
3. Activar "Spaguettio Chat"
4. Las tablas se crean automáticamente via `enabled.php`
5. El link aparece en el sidebar

## Actualización desde Versiones Anteriores

Si actualizas el componente:
1. Desactivar en panel admin
2. Reemplazar archivos
3. Activar nuevamente
4. Limpiar caché de PHP (restart apache/php-fpm)
