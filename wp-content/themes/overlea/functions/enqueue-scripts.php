<?php
/**
 * Enqueue Scripts
 *
 * Enqueue a JS file
 *
 * @package Vitamin\Vanilla_Theme\Functions
 * @author  Vitamin
 * @version 1.0.0
 */

/**
 * Enqueues JS and adds an object of WP info to wpPostData
 *
 * @return void
 */
function v_register_scripts() {
	if ( ! is_admin() ) {
		// wp_deregister_script( 'jquery' );
		wp_deregister_script( 'wp-embed' );

		// Move jQuery to footer
		wp_scripts()->add_data( 'jquery', 'group', 1 );
		wp_scripts()->add_data( 'jquery-core', 'group', 1 );
		wp_scripts()->add_data( 'jquery-migrate', 'group', 1 );
	}

	wp_enqueue_script(
		'vendor',
		get_theme_file_uri( 'js/min/vendor.min.js' ),
		[],
		filemtime( get_theme_file_path( 'js/min/vendor.min.js' ) ),
		true
	);
	wp_enqueue_script(
		'global',
		get_theme_file_uri( 'js/min/global.min.js' ),
		[ 'vendor' ],
		filemtime( get_theme_file_path( 'js/min/global.min.js' ) ),
		true
	);
	wp_enqueue_script(
		'elbwalker',
		'https://cdn.jsdelivr.net/npm/@elbwalker/walker.js@1.4/dist/walker.js',
		[],
		null,
		true
	);

	wp_localize_script(
		'global',
		'wpPostData',
		[
			'is_home'       => is_home(),
			'is_front_page' => is_front_page(),
			'page_template' => basename( get_page_template() ),
			'post_type'     => get_post_type( get_the_ID() ),
		]
	);
}
add_action( 'wp_enqueue_scripts', 'v_register_scripts' );

// // echo scripts to copy/past to defer list
// // do this from HP while logged in to get admin js too
// function v_echo_scripts() {
// 	global $wp_scripts;

// 	foreach( $wp_scripts->queue as $handle ) {
// 		echo $handle . ' | ';
// 	}
// }
// add_action( 'wp_print_scripts', 'v_echo_scripts', 10 );

function v_defer_asyns_scripts( $tag, $handle, $src ) {

	$defer = [
		'admin-bar',
	];

	$async = [
		'elbwalker',
	];

	if ( in_array( $handle, $defer ) ) {
		return '<script src="' . $src . '" defer="defer" type="text/javascript"></script>' . "\n";
	}

	if ( in_array( $handle, $async ) ) {
		return '<script src="' . $src . '" async="async" type="text/javascript"></script>' . "\n";
	}

	return $tag;
}
add_filter('script_loader_tag', 'v_defer_asyns_scripts', 10, 3);
