<?php
/**
 * Leadership
 *
 * Leadership template
 * Template Name: Leadership
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
				'meta_key'			 => 'leader_board_member',
				'order'          => 'ASC',
				'meta_query'     => [
					[
						'key' => 'leader_board_member',
						'value' => 1,
						'compare' => '==',
					],
					[
						'key' => 'leader_retired',
						'value' => 0,
						'compare' => '==',
					],
				],
			]
		);

		Timber::render( 'overview/overview.twig', $context );

	endwhile;
endif;
get_footer();
