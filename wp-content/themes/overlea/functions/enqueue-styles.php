<?php
/**
 * Enqueue Styles
 *
 * Enqueue a CSS file
 *
 * @package BoogieDown\Overlea\Functions
 * @author  Vitamin
 * @version 1.0.0
 */

/**
 * Enqueues styles
 *
 * @return void
 */
function v_register_files() {
	wp_dequeue_style( 'wp-block-library' );
	// wp_enqueue_style( 'tailwind', get_theme_file_uri( 'css/tailwind.css' ), [], filemtime( get_theme_file_path( 'css/tailwind.css' ) ), 'screen' );
	wp_enqueue_style( 'global', get_theme_file_uri( 'css/global.css' ), [], filemtime( get_theme_file_path( 'css/global.css' ) ), 'screen' );
}
add_action( 'wp_enqueue_scripts', 'v_register_files' );
