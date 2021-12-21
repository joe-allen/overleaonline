<?php
/**
 * Board
 *
 * Board template
 * Template Name: Board
 *
 * @package Vitamin\Vanilla_Theme\Templates
 * @author  Vitamin
 * @version 1.0.0
 */

use Timber\Timber;

get_header();
if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();

		$context         = Timber::get_context();
		$context['post'] = Timber::get_post();

		$context['board'] = Timber::get_posts(
			[
				'post_type'      => 'board',
				'posts_per_page' => -1,
				'orderby'        => 'menu_order',
				'order'          => 'DESC',
			]
		);

		Timber::render( 'overview/overview.twig', $context );

	endwhile;
endif;
get_footer();
