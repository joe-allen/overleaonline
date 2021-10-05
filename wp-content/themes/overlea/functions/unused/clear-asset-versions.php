<?php
/**
 * Clear Asset Versions
 *
 * Remove versioning from static assets to improve caching
 *
 * @package Vitamin\Vanilla_Theme\Functions
 * @author  Vitamin
 * @version 1.0.0
 */

/**
 * Split file source and remove query string
 *
 * @param mixed $src File URL
 *
 * @return string
 */
function v_cleanup_query_string( $src ) {
	$parts = explode( '?', $src );
	return $parts[0];
}
add_filter( 'script_loader_src', 'v_cleanup_query_string', 15, 1 );
add_filter( 'style_loader_src', 'v_cleanup_query_string', 15, 1 );
