<?php
/**
 * Clean Search
 *
 * Replaces search query parameter with prettier url structure
 *
 * @package Vitamin\Vanilla_Theme\Functions
 * @author  Vitamin
 * @version 1.0.0
 */

/**
 * Cleans up search query parameter in url
 *
 * @return void
 */
function v_change_search_url() {
	if ( is_search() && ! empty( $_GET['s'] ) ) {
		wp_safe_redirect( home_url( '/search/' ) . rawurlencode( get_query_var( 's' ) ) );
		exit();
	}
}
add_action( 'template_redirect', 'v_change_search_url', 20 );

/**
 * Single Search Result
 *
 * If there's only one search result, redirect
 * to the result page instead of the search page
 *
 * @return void
 */
function v_single_search_result() {
	if ( is_search() ) {
		global $wp_query;

		if ( 1 === (int) $wp_query->post_count && 1 === (int) $wp_query->max_num_pages ) {
			$permalink = get_permalink( $wp_query->posts[0]->ID );

			if ( $permalink ) {
				wp_safe_redirect( $permalink );
				exit;
			}
		}
	}
}
// add_action( 'template_redirect', 'v_single_search_result', 10 );
