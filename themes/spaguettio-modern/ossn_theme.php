<?php
/**
 * Spaguettio Modern Theme
 * Tema personalizado para la red social Spaguettio
 */

define('SPAGUETTIO_MODERN_THEME', ossn_route()->themes . 'spaguettio-modern/');

function spaguettio_modern_init() {
    // Registrar CSS
    ossn_extend_view('css/ossn.default', 'css/core/spaguettio-modern');
    
    // Registrar JavaScript
    ossn_extend_view('js/opensource.socialnetwork', 'js/spaguettio-modern');
    
    // Extender el layout de la página principal solo para usuarios no logueados
    if (!ossn_isLoggedin()) {
        ossn_extend_view('page/layouts/body', 'theme/page/layouts/home');
    }
}

ossn_register_callback('ossn', 'init', 'spaguettio_modern_init');
