<?php
/**
 * CPTS (Custom Post Types)
 *
 * Register custom post types
 *
 * @package Vitamin\Vanilla_Theme\Functions
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
		'board',
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
			'plural'   => 'Board Members',
		]
	);

	register_extended_post_type(
		'reps',
		[
			'menu_icon'          => 'dashicons-bank',
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
			'singular' => 'Rep / Resource',
			'plural'   => 'Reps / Resources',
		]
	);

	register_extended_post_type(
		'events',
		[
			'menu_icon'          => 'dashicons-calendar-alt',
			'menu_position'      => 20.6,
			'has_archive'        => false,
			'featured_image'     => 'Image',
			'publicly_queryable' => true,
			'supports'           => [
				'title',
				'thumbnail',
			],
		],
		[
			'singular' => 'Event',
			'plural'   => 'Events',
		]
	);

	register_extended_post_type(
		'opportunity',
		[
			'menu_icon'          => 'dashicons-megaphone',
			'menu_position'      => 20.6,
			'has_archive'        => false,
			'featured_image'     => 'Image',
			'publicly_queryable' => false,
			'supports'           => [
				'title',
				'thumbnail',
			],
		],
		[
			'singular' => 'Opportunity',
			'plural'   => 'Opportunities',
		]
	);

	register_extended_post_type(
		'sponsors',
		[
			'menu_icon'          => 'dashicons-money-alt',
			'menu_position'      => 20.6,
			'has_archive'        => false,
			'featured_image'     => 'Logo',
			'publicly_queryable' => false,
			'supports'           => [
				'title',
				'thumbnail',
			],
		],
		[
			'singular' => 'Sponsor',
			'plural'   => 'Sponsors',
		]
	);
}
add_action( 'init', 'v_register_post_types' );

function v_register_taxonomies() {

	register_extended_taxonomy(
		'categories',
		'events',
		[],
		[
			'singular' => 'Category',
			'plural'   => 'Categories',
			'slug'     => 'event-type',
		]
	);

	register_extended_taxonomy(
		'rep_categories',
		'reps',
		[],
		[
			'singular' => 'Category',
			'plural'   => 'Categories',
		]
	);
}
add_action( 'init', 'v_register_taxonomies' );

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
