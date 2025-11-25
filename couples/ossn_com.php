<?php
/**
 * Couples - Parejas verificadas múltiples para Spaguettio
 * Versión con sugerencias de usuario (autocomplete) y sin uso de bind().
 */

define('COUPLES_COMPONENT', ossn_route()->com . 'couples/');

// Cargar la clase directamente
$couples_class_file = COUPLES_COMPONENT . 'classes/Couples.php';
if(is_file($couples_class_file)){
    require_once($couples_class_file);
}

function couples_init() {
    // Acciones
    ossn_register_action('couples/request', COUPLES_COMPONENT . 'actions/request.php');
    ossn_register_action('couples/accept',  COUPLES_COMPONENT . 'actions/accept.php');
    ossn_register_action('couples/remove',  COUPLES_COMPONENT . 'actions/remove.php');

    // Bloque dentro del formulario de editar perfil
    ossn_extend_view('forms/OssnProfile/edit', 'couples/edit_block');

    // Página para ver/manejar solicitudes y endpoint de sugerencias
    ossn_register_page('couples', 'couples_page_handler');
}

function couples_page_handler($pages) {
    // Endpoint JSON para sugerencias: /couples/suggest?q=texto
    if(isset($pages[0]) && $pages[0] == 'suggest'){
        if(!ossn_isLoggedin()){
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(array());
            return;
        }
        $q = input('q');
        $c = new Couples();
        $users = $c->searchUsers($q);
        $out = array();
        if($users){
            foreach($users as $u){
                $out[] = array(
                    'guid'     => (int) $u->guid,
                    'username' => $u->username,
                    'fullname' => trim($u->first_name . ' ' . $u->last_name),
                );
            }
        }
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($out);
        return;
    }

    // Página normal de solicitudes de pareja: /couples
    if(!ossn_isLoggedin()){
        ossn_error_page();
    }
    $content = ossn_plugin_view('couples/requests');
    $params  = array(
        'title'   => ossn_print('couples:requests:title'),
        'content' => $content,
    );
    echo ossn_view_page(
        ossn_print('couples:requests:title'),
        ossn_view_layout('contents', $params)
    );
}

ossn_register_callback('ossn', 'init', 'couples_init');
