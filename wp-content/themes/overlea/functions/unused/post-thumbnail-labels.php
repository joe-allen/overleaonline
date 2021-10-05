<?php
/**
 * Post Thumbnail Labels
 *
 * Customizes the post thumnail metabox
 *
 * @package Vitamin\Vanilla_Theme\Functions
 * @author  Vitamin
 * @version 1.0.0
 */

/**
 * Sets instructions in the thumbnail metabox
 *
 * @param  mixed $content the metabox html
 *
 * @return mixed
 */
function v_change_post_thumbnail_desc( $content ) {
	$post_type = 'post' === $_GET['post_type'] ? 'news' : ( $_GET['post_type'] ? $_GET['post_type'] : 'news' );
	$content   = "<p>This is a custom message.</p>$content";
	$content   = str_replace( __( 'featured image' ), __( 'post thumbnail' ), $content );

	return $content;
}
add_filter( 'admin_post_thumbnail_html', 'v_change_post_thumbnail_desc' );

/**
 * Modifies the thumbnail metabox title in the global var
 *
 * @return void
 */
function v_change_post_thumbnail_title() {
	global $wp_meta_boxes;
	$current_title = $wp_meta_boxes['post']['side']['low']['postimagediv']['title'];
	if ( 'Featured Image' === $current_title ) {
		$wp_meta_boxes['post']['side']['low']['postimagediv']['title'] = 'Custom Title';
	}
}
add_action( 'add_meta_boxes', 'v_change_post_thumbnail_title' );
