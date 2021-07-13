<?php
/**
 * Add Theme Support
 *
 * Adds functionality for featured image and excerpts
 *
 * @package BoogieDown\Overlea\Functions
 * @author  Vitamin
 * @version 1.0.0
 */

// add_theme_support( 'post-thumbnails' );
// add_post_type_support( 'page', 'excerpt' );
add_theme_support( 'title-tag' );
add_theme_support( 'html5', [ 'caption', 'comment-form', 'comment-list', 'gallery', 'search-form', 'style', 'script' ] );
