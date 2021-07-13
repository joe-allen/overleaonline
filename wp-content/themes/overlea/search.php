<?php
/**
 * Search
 *
 * Template used for search results
 *
 * @package BoogieDown\Overlea\Templates
 * @author  Vitamin
 * @version 1.0.0
 */

use Timber\Timber;
use Timber\Post;
use Timber\PostQuery;

get_header();

$context                        = Timber::get_context();
$context['post']                = new Post();
$context['posts']               = new PostQuery();
$context['post']->search_string = get_search_query();

Timber::render( 'search/search.twig', $context );

get_footer();
