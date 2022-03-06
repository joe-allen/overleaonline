<?php
/**
 * Front Page ACF
 *
 * @package Vitamin\Vanilla_Theme\ACF
 */

use StoutLogic\AcfBuilder\FieldsBuilder;

/**
 * Define ACF for the template
 *
 * @return FieldsBuilder
 */
function front_page_acf() {

	$slider = require get_template_directory() . "/components/slider/slider-acf.php";
	$cta = require get_template_directory() . "/components/cta/cta-acf.php";
	$sponsors = require get_template_directory() . "/components/sponsors/sponsors-acf.php";
	$ic = require get_template_directory() . "/components/image-content/image-content-acf.php";
	$excerpt = require get_template_directory() . "/components/excerpt/excerpt-acf.php";

	$g_front_page = new FieldsBuilder( 'homepage' );
	$g_front_page
		->addFields( $slider )
		->addFields( $cta )
		->addFields( $sponsors )
		->addFields( $ic )
		->modifyField( 'ic', [ 'max' => 1 ] )
		->addFields( $excerpt )

		->setGroupConfig( 'hide_on_screen', [ 'the_content' ] )
		->setLocation( 'page_type', '==', 'front_page' );

		return $g_front_page;
}

return front_page_acf();
