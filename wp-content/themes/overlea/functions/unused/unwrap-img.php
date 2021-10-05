<?php
/**
 * Unwrap <img>
 *
 * Removes <p>s surrounding images.
 * Only use if the default behavior is causing significant issues
 *
 * @package Vitamin\Vanilla_Theme\Functions
 * @author  Vitamin
 * @version 1.0.0
 */

/**
 * Removes p tags surrounding images whenever the_content filter is called
 *
 * @param mixed $content WYSIWYG html
 *
 * @return mixed
 */
function filter_ptags_on_images( $content ) {
	return preg_replace( '/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content );
}
add_filter( 'the_content', 'filter_ptags_on_images' );
