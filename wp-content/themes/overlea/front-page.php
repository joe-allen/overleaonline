<?php
/**
 * Front Page
 *
 * Template used for homepage
 *
 * @package Vitamin\Vanilla_Theme\Templates
 * @author  Vitamin
 * @version 1.0.0
 */

use Timber\Timber;
use Timber\Post;

get_header();
if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();

		$context         = Timber::get_context();
		$context['post'] = new Post();

		$args = [
			'posts_per_page' => 3,
			'post_type' => 'post',
			'order' => 'ASC',
			'order_by' => 'published_at',
		];
		$context['posts'] = Timber::get_posts( $args );

		Timber::render( 'front-page/front-page.twig', $context );

	endwhile;
endif;
get_footer();
