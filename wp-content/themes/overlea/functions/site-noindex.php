<?php
/**
 * Site No Index
 *
 * Sets checkbox to true for discouraging search engines
 * from indexing  site unless on production server
 *
 * @package Vitamin\Vanilla_Theme\Functions
 * @author  Vitamin
 * @version 1.0.0
 */

/**
 * Disable site indexing outside of production
 *
 * @return void
 */
function v_disable_site_indexing() {
	if ( 'production' !== $_ENV['location'] ) {
		add_action( 'pre_option_blog_public', '__return_zero' );
	} else {
		add_action( 'pre_option_blog_public', '__return_true' );
	}
}
add_action( 'admin_init', 'v_disable_site_indexing' );
