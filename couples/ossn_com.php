<?php
/**
 * Couples - Relaciones de pareja para Spaguettio (OSSN)
 */

define('COUPLES', ossn_route()->com . 'couples/');

/**
 * Inicialización del componente
 */
function couples_init() {
    // Registrar página /couples
    ossn_register_page('couples', 'couples_page_handler');

    // Registrar acciones
    ossn_register_action('couples/request', COUPLES . 'actions/request.php');
    ossn_register_action('couples/accept', COUPLES . 'actions/accept.php');
    ossn_register_action('couples/remove', COUPLES . 'actions/remove.php');

    // Extender formulario de edición de perfil
    ossn_extend_view('forms/OssnProfile/edit', 'couples/edit_block');

    // Cargar idiomas
    include_once(COUPLES . 'locale/ossn.en.php');
    include_once(COUPLES . 'locale/ossn.es.php');
}

/**
 * Page handler para /couples
 */
function couples_page_handler($pages) {
    if(!ossn_isLoggedin()) {
        ossn_error_page();
    }

    $user = ossn_loggedin_user();
    $title = ossn_print('couples:page:title');

    $contents = ossn_view('couples/requests', array(
        'user' => $user,
    ));

    $params = array(
        'title' => $title,
        'contents' => $contents,
    );

    $page = ossn_view_layout('contents', $params);
    echo ossn_view_page($title, $page);
}

ossn_register_callback('ossn', 'init', 'couples_init');
