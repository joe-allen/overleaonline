<?php
/**
 * Timber Setup
 *
 * Check if Timber exists.
 * Tell Timber where it's being used
 *
 * @package Vitamin\Vanilla_Theme\Functions
 * @author  Vitamin
 * @version 1.0.0
 */

use Timber\Timber;

if ( class_exists( 'Timber' ) ) {
	Timber::$locations = [
		get_template_directory() . '/components',
		get_template_directory() . '/templates',
		get_template_directory() . '/helpers',
	];
}

/**
 * Store global options
 *
 * @param array $context Timber context
 *
 * @return array
 */
function v_timber_content_options( $context ) {
	$context['options'] = get_fields( 'options' );

	return $context;
}
add_filter( 'timber_context', 'v_timber_content_options' );
