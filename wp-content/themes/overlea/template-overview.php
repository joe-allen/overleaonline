<?php
/**
 * Overview
 *
 * Overview template
 * Template Name: Overview
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

		if ( $context['post']->ID == 11 ) {
			$context['events'] = Timber::get_posts(
				[
					'post_type'      => 'events',
					'posts_per_page' => -1,
					'orderby'        => 'menu_order',
					'order'          => 'ASC',
				]
			);
		}

		Timber::render( 'overview/overview.twig', $context );

	endwhile;
endif;
get_footer();
