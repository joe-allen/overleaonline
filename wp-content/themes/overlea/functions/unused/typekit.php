<?php
/**
 * Typekit
 *
 * Adds Typekit if using the JS version (stylesheet is preferred)
 *
 * @package BoogieDown\Overlea\Functions
 * @author  Vitamin
 * @version 1.0.0
 */

/**
 * Enqueues the Typekit script
 *
 * @return void
 */
function v_theme_typekit() {
	wp_enqueue_script( 'theme_typekit', '//use.typekit.net/caa0afp.js', [], '1', false );
}
add_action( 'wp_enqueue_scripts', 'v_theme_typekit' );


/**
 * Adds the inline script to load Typekit
 *
 * @return void
 */
function v_theme_typekit_inline() {
	if ( wp_script_is( 'theme_typekit', 'done' ) ) {
		echo '<script type="text/javascript">try{Typekit.load();}catch(e){}</script>';
	}
}
add_action( 'wp_head', 'v_theme_typekit_inline' );
