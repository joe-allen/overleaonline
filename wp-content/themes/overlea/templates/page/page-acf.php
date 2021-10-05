<?php
/**
 * Page ACF
 *
 * @package Vitamin\Vanilla_Theme\ACF
 */

use StoutLogic\AcfBuilder\FieldsBuilder;

/**
 * Define ACF for the template
 *
 * @return FieldsBuilder
 */
function page_acf() {
	$g_page = new FieldsBuilder( 'page' );
	$g_page
		->setGroupConfig( 'hide_on_screen', [ 'the_content' ] )
		->setLocation( 'post_type', '==', 'page' )
			->and( 'page_template', '==', 'default' )
			->and( 'page_type', '!=', 'front_page' )
			->and( 'page_type', '!=', 'posts_page' );

		return $g_page;
}

return page_acf();
