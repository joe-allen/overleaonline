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
	$g_news = new FieldsBuilder( 'news_listing' );
	$g_news
		->setGroupConfig( 'hide_on_screen', [ 'the_content' ] )
		->setLocation( 'page_type', '==', 'posts_page' );

		return $g_news;
}

return home_acf();
