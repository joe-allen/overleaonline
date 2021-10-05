<?php
/**
 * Sponsor
 *
 * Sponsor template
 * Template Name: Sponsor
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

		Timber::render( 'sponsor/sponsor.twig', $context );

	endwhile;
endif;
get_footer();
