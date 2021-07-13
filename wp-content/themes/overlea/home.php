<?php
/**
 * Home
 *
 * Template used for news/post listing
 *
 * @package BoogieDown\Overlea\Templates
 * @author  Vitamin
 * @version 1.0.0
 */

use Timber\Timber;
use Timber\Post;
use Timber\PostQuery;

get_header();

$context          = Timber::get_context();
$context['post']  = new Post();
$context['posts'] = new PostQuery();

Timber::render( 'home/home.twig', $context );

get_footer();
