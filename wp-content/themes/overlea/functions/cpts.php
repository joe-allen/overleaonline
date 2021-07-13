<?php
/**
 * CPTS (Custom Post Types)
 *
 * Register custom post types
 *
 * @package BoogieDown\Overlea\Functions
 * @author  Vitamin
 * @version 1.0.0
 */

/**
 * Use extended custom post types to register post types and taxonomies
 *
 * @return void
 */
function v_register_post_types() {
	register_extended_post_type(
		'leadership',
		[
			'menu_icon'          => 'dashicons-groups',
			'menu_position'      => 20.6,
			'has_archive'        => false,
			'featured_image'     => 'Headshot',
			'publicly_queryable' => false,
			'supports'           => [
				'title',
				'thumbnail',
			],
		],
		[
			'singular' => 'Member',
			'plural'   => 'Leadership',
		]
	);
}
add_action( 'init', 'v_register_post_types' );

/**
 * Keep terms in order when checked
 *
 * @param array $args    An array of arguments
 * @param int   $post_id ID of the current post
 *
 * @return array $args
 */
function v_keep_terms_in_order( $args, $post_id ) {
	$args['checked_ontop'] = false;
	return $args;
}
add_filter( 'wp_terms_checklist_args', 'v_keep_terms_in_order', 10, 2 );
