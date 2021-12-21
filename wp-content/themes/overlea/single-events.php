<?php
/**
 * Single Event
 *
 * Event template
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

		Timber::render( 'single-event/single-event.twig', $context );

	endwhile;
endif;
get_footer();
