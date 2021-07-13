<?php
/**
 * Head Cleanup
 *
 * Clean up output in <head>
 *
 * @package BoogieDown\Overlea\Functions
 * @author  Vitamin
 * @version 1.0.0
 */

if ( ! defined( 'DISABLE_NAG_NOTICES' ) && 'local' !== $_ENV['location'] ) {
	define( 'DISABLE_NAG_NOTICES', true );
}

// Remove WP generator version
remove_action( 'wp_head', 'wp_generator' );

// Remove REST link
remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
remove_action( 'template_redirect', 'rest_output_link_header', 11, 0 );

// Remove oEmbed discovery link
remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );

// Remove really simple discovery
remove_action( 'wp_head', 'rsd_link' );

// Remove Windows Live Writer support
remove_action( 'wp_head', 'wlwmanifest_link' );

// Remove shortlink
remove_action( 'wp_head', 'wp_shortlink_wp_head', 10 );
remove_action( 'template_redirect', 'wp_shortlink_header', 11 );

// Remove previous/next post links
remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 );
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );

// Remove generator tag from feeds
remove_action( 'atom_head', 'the_generator' );
remove_action( 'comments_atom_head', 'the_generator' );
remove_action( 'rss_head', 'the_generator' );
remove_action( 'rss2_head', 'the_generator' );
remove_action( 'commentsrss2_head', 'the_generator' );
remove_action( 'rdf_header', 'the_generator' );
remove_action( 'opml_head', 'the_generator' );
remove_action( 'app_head', 'the_generator' );
add_filter( 'the_generator', '__return_false' );

// Remove feeds from categories, tags, search
remove_action( 'wp_head', 'feed_links_extra', 3 );

// Remove emoji
if ( is_admin() ) {
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );

	add_filter(
		'tiny_mce_plugins',
		function( $plugins ) {
			if ( is_array( $plugins ) ) {
				return array_diff( $plugins, array( 'wpemoji' ) );
			}
			return array();
		}
	);
} else {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	add_filter( 'emoji_svg_url', '__return_false' );

	add_filter(
		'xmlrpc_methods',
		function( $methods ) {
			unset( $methods['pingback.ping'] );
			return $methods;
		}
	);
}
