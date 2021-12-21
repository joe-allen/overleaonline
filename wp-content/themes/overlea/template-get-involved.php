<?php
/**
 * Overview
 *
 * Overview template
 * Template Name: Get Involved
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

		if ( $context['post']->ID == 32 ) {

			$context['opportunities'] = Timber::get_posts(
				[
					'post_type'      => 'opportunity',
					'posts_per_page' => -1,
					'meta_key'       => 'event_start_date',
					'orderby'        => 'meta_value',
					'order'          => 'DESC',
				]
			);
		}

		Timber::render( 'overview/overview.twig', $context );

	endwhile;
endif;
get_footer();
