<?php
/**
 * Responsive Embeds
 *
 * Make oEmbeds responsive
 *
 * @package Vitamin\Vanilla_Theme\Functions
 * @author  Vitamin
 * @version 1.0.0
 */

/**
 * Wrap iFrame in responsive div
 *
 * @param mixed  $html    cached HTML result
 * @param string $url     attempted embed URL
 * @param array  $attr    shortcode attributes
 * @param int    $post_id post ID
 *
 * @return mixed
 */
function v_wrap_oembed( $html, $url, $attr, $post_id ) {
	return '<div class="responsive-embed">' . $html . '</div>';
}
add_filter( 'embed_oembed_html', 'v_wrap_oembed', 99, 4 );
