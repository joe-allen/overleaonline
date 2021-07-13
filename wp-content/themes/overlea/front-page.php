<?php
/**
 * Front Page
 *
 * Template used for homepage
 *
 * @package BoogieDown\Overlea\Templates
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

		Timber::render( 'front-page/front-page.twig', $context );

	endwhile;
endif;
get_footer();
