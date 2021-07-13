<?php
/**
 * Front Page ACF
 *
 * @package BoogieDown\Overlea\ACF
 */

use StoutLogic\AcfBuilder\FieldsBuilder;

/**
 * Define ACF for the template
 *
 * @return FieldsBuilder
 */
function front_page_acf() {

	$card = require get_theme_file_path('components/card/card-acf.php');
	// $hero          = require get_theme_file_path( 'components/hp-hero/hp-hero-acf.php' );

	$g_front_page = new FieldsBuilder( 'homepage' );
	$g_front_page
		->addFields( $card )

		->setGroupConfig( 'hide_on_screen', [ 'the_content' ] )
		->setLocation( 'page_type', '==', 'front_page' );

		return $g_front_page;
}

return front_page_acf();
