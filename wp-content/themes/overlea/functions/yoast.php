<?php
/**
 * Yoast
 *
 * Set better defaults for Yoast settings,
 * modify output as needed
 *
 * @package BoogieDown\Overlea\Functions
 * @author Vitamin
 * @version 1.0.0
 */

use Yoast\WP\SEO\Config\Schema_IDs;

/**
 * Change author in Schema
 *
 * @param array $data Schema.org data array.
 * @return array $data Schema.org data array.
 */
function v_change_schema_author( $data ) {
	$data['author'] = [ '@id' => home_url( '/' ) . Schema_IDs::ORGANIZATION_HASH ];
	return $data;
}
add_filter( 'wpseo_schema_article', 'v_change_schema_author' );
add_filter( 'wpseo_schema_webpage', 'v_change_schema_author' );

// Disable @Person schema
add_filter( 'wpseo_schema_needs_author', '__return_false' );

// Disable author data
add_filter(
	'wpseo_enhanced_slack_data',
	function() {
		return [];
	}
);
