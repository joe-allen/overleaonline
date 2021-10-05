<?php
/**
 * Resize large uploads
 *
 * @package Vitamin\Vanilla_Theme\Functions
 */

/**
 * Resize uploads larger than 1920px
 *
 * @param  int $threshold image size limit
 * @return int
 */
function v_big_image_size_threshold( $threshold ) {
	return 1920;
}
add_filter( 'big_image_size_threshold', 'v_big_image_size_threshold', 999, 1 );
