<?php
/**
 * <%= nameSpaced %>
 *
 * <%= nameSpaced %> template
 * Template Name: <%= nameSpaced %>
 *
 * @package Vitamin\<%= theme %>\Templates
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

		Timber::render( '<%= name %>/<%= name %>.twig', $context );

	endwhile;
endif;
get_footer();
