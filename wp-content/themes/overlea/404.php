<?php
/**
 * 404
 *
 * Renders when no page is found.
 *
 * @package BoogieDown\Overlea\Templates
 * @author  Vitamin
 * @version 1.0.0
 */

use Timber\Timber;
use Timber\Post;

get_header();

$context         = Timber::get_context();
$context['post'] = new Post();

Timber::render( '404/404.twig', $context );

get_footer();
