<?php
/**
 * ACF Options Page
 *
 * Add Options pages to the WP admin via Intervention
 *
 * @package Vitamin\Vanilla_Theme\Functions
 * @author  Vitamin
 * @version 1.1.0
 */

if ( function_exists( 'acf_add_options_page' ) ) {
	acf_add_options_page(
		[
			'page_title' => 'Global Settings',
			'menu_title' => 'Global Settings',
			'icon_url'   => 'dashicons-admin-site',
			'position'   => '32.1',
		]
	);
}
