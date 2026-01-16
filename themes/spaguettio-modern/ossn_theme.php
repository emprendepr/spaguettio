<?php
/**
 * Spaguettio Modern Theme
 * Modern landing page theme with neon design
 * 
 * @package Spaguettio Modern Theme
 * @author Spaguettio Team
 * @license Custom
 */

/**
 * Initialize the theme
 * Register CSS, JS and override views for non-logged users
 */
function spaguettio_modern_init() {
    // Registrar CSS
    ossn_extend_view('css/ossn.default', 'css/spaguettio-modern');
    
    // Registrar JavaScript
    ossn_extend_view('js/opensource.socialnetwork', 'js/spaguettio-modern');
    
    // Sobrescribir la página home para visitantes no logueados
    if(!ossn_isLoggedin()) {
        ossn_extend_view('page/elements/home', 'theme/page/elements/home');
    }
}

// Register theme initialization callback
ossn_register_callback('ossn', 'init', 'spaguettio_modern_init');
