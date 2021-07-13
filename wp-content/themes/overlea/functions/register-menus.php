<?php
/**
 * Register Menus
 *
 * Sets nav menus in WP admin
 *
 * @package BoogieDown\Overlea\Functions
 * @author  Vitamin
 * @version 1.0.0
 */

/**
 * Register menus
 *
 * @return void
 */
function v_register_menus() {
	register_nav_menu( 'header_nav', 'Header Nav' );
	register_nav_menu( 'footer_nav', 'Footer Nav' );
}
add_action( 'after_setup_theme', 'v_register_menus' );
