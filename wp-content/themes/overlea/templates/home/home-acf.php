<?php
/**
 * Home ACF
 *
 * @package Vitamin\Vanilla_Theme\ACF
 */

use StoutLogic\AcfBuilder\FieldsBuilder;

/**
 * Define ACF for the template
 *
 * @return FieldsBuilder
 */
function home_acf() {
	$hero = require get_template_directory() . "/components/hero/hero-acf.php";
	$intro = require get_template_directory() . "/components/intro/intro-acf.php";

	$g_news = new FieldsBuilder( 'news_listing' );
	$g_news
		->addFields($hero)
		->addFields($intro)

		->setGroupConfig( 'hide_on_screen', [ 'the_content' ] )
		->setLocation( 'page_type', '==', 'posts_page' );

		return $g_news;
}

return home_acf();
