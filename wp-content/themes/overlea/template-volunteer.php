<?php
/**
 * Volunteer
 *
 * Volunteer template
 * Template Name: Volunteer
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

		$context['opportunities'] = Timber::get_posts(
			[
				'post_type'      => 'opportunity',
				'posts_per_page' => -1,
				'meta_key'       => 'event_start_date',
				'orderby'        => 'meta_value',
				'order'          => 'ASC',
			]
		);

		Timber::render( 'overview/overview.twig', $context );

	endwhile;
endif;
get_footer();
