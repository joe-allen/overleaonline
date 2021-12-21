<?php
/**
 * Single Sponsor
 *
 * Single Sponsor template
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

		Timber::render( 'single-sponsor/single-sponsor.twig', $context );

	endwhile;
endif;
get_footer();
