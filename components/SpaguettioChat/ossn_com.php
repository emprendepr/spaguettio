<?php
/**
 * Spaguettio Chat Component
 * 
 * A LatinChat-style chat room component for OSSN
 * 
 * @package   SpaguettioChat
 * @author    Spaguettio
 * @license   GPL
 */

define('__SPAGUETTIO_CHAT__', ossn_route()->com . 'SpaguettioChat/');

/**
 * Initialize Spaguettio Chat component
 */
function spaguettio_chat_init() {
    // Register page handlers
    ossn_register_page('chat', 'spaguettio_chat_page_handler');
    ossn_register_page('chat-admin', 'spaguettio_chat_admin_page_handler');
    
    // Register actions
    ossn_register_action('chat/send', __SPAGUETTIO_CHAT__ . 'actions/send.php');
    ossn_register_action('chat/get_messages', __SPAGUETTIO_CHAT__ . 'actions/get_messages.php');
    ossn_register_action('chat/get_users', __SPAGUETTIO_CHAT__ . 'actions/get_users.php');
    ossn_register_action('chat/register_user', __SPAGUETTIO_CHAT__ . 'actions/register_user.php');
    ossn_register_action('chat/unregister_user', __SPAGUETTIO_CHAT__ . 'actions/unregister_user.php');
    ossn_register_action('chat/accept_terms', __SPAGUETTIO_CHAT__ . 'actions/accept_terms.php');
    
    // Register admin actions
    ossn_register_action('chat/get_rooms', __SPAGUETTIO_CHAT__ . 'actions/get_rooms.php');
    ossn_register_action('chat/create_room', __SPAGUETTIO_CHAT__ . 'actions/create_room.php');
    ossn_register_action('chat/edit_room', __SPAGUETTIO_CHAT__ . 'actions/edit_room.php');
    ossn_register_action('chat/delete_room', __SPAGUETTIO_CHAT__ . 'actions/delete_room.php');
    ossn_register_action('chat/get_statistics', __SPAGUETTIO_CHAT__ . 'actions/get_statistics.php');
    ossn_register_action('chat/clear_history', __SPAGUETTIO_CHAT__ . 'actions/clear_history.php');
    ossn_register_action('chat/save_settings', __SPAGUETTIO_CHAT__ . 'actions/save_settings.php');
    
    // Add CSS
    ossn_extend_view('css/ossn.default', 'css/spaguettio_chat');
    
    // Add JS
    ossn_extend_view('js/ossn.site', 'js/spaguettio_chat');
    
    // Add menu items
    if (ossn_isLoggedin()) {
        // Add sidebar link to chat room
        ossn_register_menu_item('sidebar', array(
            'name' => 'chat',
            'text' => ossn_print('spaguettio:chat:menu'),
            'href' => ossn_site_url('chat'),
            'icon' => 'fa-comments',
            'priority' => 5,
        ));
    }
    
    // Add admin topbar link
    if (ossn_isAdminLoggedin()) {
        ossn_register_menu_item('topbar_admin', array(
            'name' => 'chat_admin',
            'text' => ossn_print('spaguettio:chat:admin:menu'),
            'href' => ossn_site_url('chat-admin'),
            'icon' => 'fa-cog',
            'priority' => 10,
        ));
    }
}

/**
 * Chat room page handler
 */
function spaguettio_chat_page_handler($pages) {
    $page = $pages[0] ?? 'terms';
    
    if (!ossn_isLoggedin()) {
        redirect(ossn_site_url('login'));
        return false;
    }
    
    // Check if user has accepted terms
    $user = ossn_loggedin_user();
    $user_guid = $user->guid;
    $db = ossn_database();
    
    $terms_check = "SELECT * FROM ossn_spaguettio_chat_terms WHERE user_guid = {$user_guid} AND accepted = 1 LIMIT 1";
    $has_accepted = $db->getRow($terms_check);
    
    // If accessing 'room' directly but hasn't accepted terms, show terms
    if ($page === 'room' && !$has_accepted) {
        $page = 'terms';
    }
    
    // If hasn't accepted terms and not explicitly viewing 'terms', show terms
    if (!$has_accepted && $page !== 'terms') {
        $page = 'terms';
    }
    
    // Show terms page
    if ($page === 'terms') {
        $title = ossn_print('spaguettio:chat:terms:title');
        $content = ossn_plugin_view('chat/terms');
        
        $params = array(
            'title' => $title,
            'content' => $content,
        );
        
        $contents = ossn_set_page_layout('newsfeed', $params);
        echo ossn_view_page($title, $contents);
        return;
    }
    
    // Show chat room (only if terms accepted)
    if ($page === 'room' && $has_accepted) {
        $title = ossn_print('spaguettio:chat:title');
        $content = ossn_plugin_view('chat/room');
        
        $params = array(
            'title' => $title,
            'content' => $content,
        );
        
        $contents = ossn_set_page_layout('newsfeed', $params);
        echo ossn_view_page($title, $contents);
        return;
    }
    
    // Default: redirect to terms
    redirect(ossn_site_url('chat/terms'));
}

/**
 * Chat admin page handler
 */
function spaguettio_chat_admin_page_handler($pages) {
    ossn_trigger_callback('page', 'load:admin');
    
    if (!ossn_isAdminLoggedin()) {
        redirect(ossn_site_url());
        return false;
    }
    
    $title = ossn_print('spaguettio:chat:admin:title');
    $content = ossn_plugin_view('chat/admin');
    
    $params = array(
        'title' => $title,
        'content' => $content,
    );
    
    $contents = ossn_set_page_layout('administrator', $params);
    echo ossn_view_page($title, $contents);
}

/**
 * Install component
 */
function spaguettio_chat_install_handler() {
    require_once(__SPAGUETTIO_CHAT__ . 'schema.php');
    return spaguettio_chat_install();
}

/**
 * Uninstall component
 */
function spaguettio_chat_uninstall_handler() {
    require_once(__SPAGUETTIO_CHAT__ . 'schema.php');
    return spaguettio_chat_uninstall();
}

// Register initialization callback
ossn_register_callback('ossn', 'init', 'spaguettio_chat_init');

// Register installation callbacks
ossn_register_callback('component', 'install', 'spaguettio_chat_install_handler');
ossn_register_callback('component', 'uninstall', 'spaguettio_chat_uninstall_handler');
