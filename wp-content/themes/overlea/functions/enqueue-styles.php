<?php
/**
 * Enqueue Styles
 *
 * Enqueue a CSS file
 *
 * @package Vitamin\Vanilla_Theme\Functions
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
	wp_enqueue_style( 'global', get_theme_file_uri( 'css/global.css' ), [], filemtime( get_theme_file_path( 'css/global.css' ) ), 'screen' );
}
add_action( 'wp_enqueue_scripts', 'v_register_files' );
