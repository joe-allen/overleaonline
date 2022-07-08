<?php
/**
 * Single ACF
 *
 * @package Vitamin\Vanilla_Theme\ACF
 */

use StoutLogic\AcfBuilder\FieldsBuilder;

/**
 * Define ACF for the template
 *
 * @return FieldsBuilder
 */
function single_acf() {
	$slider = require get_template_directory() . "/components/slider/slider-acf.php";
	$content = require get_template_directory() . "/components/content/content-acf.php";
	$sponsors = require get_template_directory() . "/components/sponsors/sponsors-acf.php";
	$member_selector = require get_template_directory() . "/components/member-selector/member-selector-acf.php";
	$excerpt = require get_template_directory() . "/components/excerpt/excerpt-acf.php";

	$g_single = new FieldsBuilder( 'news' );
	$g_single
		->addFields( $slider )
				->removeField( 'slider->slider_link' )
		->addFields( $content )
		->addFields( $sponsors )
			->removeField( 'sponsor_title' )
			->removeField( 'sponsor_text' )
		->addFields( $member_selector )
		->addFields( $excerpt )

		->setGroupConfig( 'hide_on_screen', [ 'the_content' ] )
		->setLocation( 'post_type', '==', 'post' );

		return $g_single;
}

return single_acf();
