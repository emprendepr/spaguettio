<?php
/**
 * Lounge - Chat en tiempo real estilo LatinChat
 * 
 * @package Lounge
 * @author Spaguettio Team
 * @license MIT
 */

define('LOUNGE', ossn_route()->com . 'lounge/');

/**
 * Inicialización del componente
 */
function lounge_init() {
    // Registrar páginas
    ossn_register_page('lounge', 'lounge_page_handler');
    ossn_register_page('lounge-admin', 'lounge_admin_page_handler');
    
    // Registrar acciones
    ossn_register_action('lounge/send', LOUNGE . 'actions/send.php');
    ossn_register_action('lounge/get_messages', LOUNGE . 'actions/get_messages.php');
    ossn_register_action('lounge/get_users', LOUNGE . 'actions/get_users.php');
    ossn_register_action('lounge/change_name', LOUNGE . 'actions/change_name.php');
    
    // Acciones de administración
    ossn_register_action('lounge/admin/clear_messages', LOUNGE . 'actions/admin/clear_messages.php');
    ossn_register_action('lounge/admin/clear_users', LOUNGE . 'actions/admin/clear_users.php');
    ossn_register_action('lounge/admin/delete_message', LOUNGE . 'actions/admin/delete_message.php');
    ossn_register_action('lounge/admin/kick_user', LOUNGE . 'actions/admin/kick_user.php');
    
    // Agregar CSS y JS
    ossn_extend_view('css/ossn.default', 'lounge/css');
    ossn_extend_view('js/ossn.site', 'lounge/js');
    
    // Agregar enlace al menú
    ossn_register_menu_link('lounge', 'lounge', 'lounge', 'topbar_dropdown');
    
    // Cargar idiomas
    ossn_load_locale('es', LOUNGE . 'locale/ossn.es.php');
    ossn_load_locale('en', LOUNGE . 'locale/ossn.en.php');
}

/**
 * Page handler para /lounge
 */
function lounge_page_handler($pages) {
    // Inicializar sesión de chat si no existe
    if (!isset($_SESSION['lounge_username'])) {
        if (ossn_isLoggedin()) {
            $user = ossn_loggedin_user();
            $_SESSION['lounge_username'] = $user->first_name . ' ' . $user->last_name;
        } else {
            $_SESSION['lounge_username'] = 'Usuario' . rand(1000, 9999);
        }
    }
    
    if (!isset($_SESSION['lounge_color'])) {
        $_SESSION['lounge_color'] = sprintf('#%06X', mt_rand(0x333333, 0xFFFFFF));
    }
    
    $title = ossn_print('lounge:title');
    
    $contents = ossn_plugin_view('lounge/page', array(
        'username' => $_SESSION['lounge_username'],
        'color' => $_SESSION['lounge_color']
    ));
    
    $params = array(
        'title' => $title,
        'content' => $contents,
    );
    
    $content = ossn_set_page_layout('contents', $params);
    echo ossn_view_page($title, $content);
}

/**
 * Page handler para /lounge-admin
 */
function lounge_admin_page_handler($pages) {
    // Solo administradores
    if (!ossn_isLoggedin() || !ossn_isAdminLoggedin()) {
        ossn_error_page();
        return;
    }
    
    $title = ossn_print('lounge:admin:title');
    
    $contents = ossn_plugin_view('lounge/admin', array());
    
    $params = array(
        'title' => $title,
        'content' => $contents,
    );
    
    $content = ossn_set_page_layout('contents', $params);
    echo ossn_view_page($title, $content);
}

/**
 * Funciones auxiliares para manejo de archivos JSON
 */
function lounge_get_messages_file() {
    return ossn_get_userdata('components/lounge/lounge_messages.json');
}

function lounge_get_users_file() {
    return ossn_get_userdata('components/lounge/lounge_users.json');
}

function lounge_load_messages() {
    $file = lounge_get_messages_file();
    if (!file_exists($file)) {
        return [];
    }
    $content = @file_get_contents($file);
    if ($content === false) {
        return [];
    }
    $messages = json_decode($content, true);
    return is_array($messages) ? $messages : [];
}

function lounge_save_messages($messages) {
    $file = lounge_get_messages_file();
    $dir = dirname($file);
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
    
    $json = json_encode($messages, JSON_PRETTY_PRINT);
    $fp = fopen($file, 'c');
    if ($fp) {
        if (flock($fp, LOCK_EX)) {
            ftruncate($fp, 0);
            fwrite($fp, $json);
            fflush($fp);
            flock($fp, LOCK_UN);
        }
        fclose($fp);
    }
}

function lounge_load_users() {
    $file = lounge_get_users_file();
    if (!file_exists($file)) {
        return [];
    }
    $content = @file_get_contents($file);
    if ($content === false) {
        return [];
    }
    $users = json_decode($content, true);
    return is_array($users) ? $users : [];
}

function lounge_save_users($users) {
    $file = lounge_get_users_file();
    $dir = dirname($file);
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
    
    $json = json_encode($users, JSON_PRETTY_PRINT);
    $fp = fopen($file, 'c');
    if ($fp) {
        if (flock($fp, LOCK_EX)) {
            ftruncate($fp, 0);
            fwrite($fp, $json);
            fflush($fp);
            flock($fp, LOCK_UN);
        }
        fclose($fp);
    }
}

function lounge_update_user_activity() {
    if (!isset($_SESSION['lounge_username'])) {
        return;
    }
    
    $users = lounge_load_users();
    $sessionId = session_id();
    
    $users[$sessionId] = [
        'username' => $_SESSION['lounge_username'],
        'color' => $_SESSION['lounge_color'],
        'last_activity' => time()
    ];
    
    lounge_save_users($users);
}

// Registrar callback de inicialización
ossn_register_callback('ossn', 'init', 'lounge_init');
