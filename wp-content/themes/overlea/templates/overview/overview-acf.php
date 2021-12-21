<?php
/**
 * Overview ACF
 *
 * @package Vitamin\Vanilla_Theme\ACF
 */

use StoutLogic\AcfBuilder\FieldsBuilder;

/**
 * Define ACF for the template
 *
 * @return FieldsBuilder
 */
function overview_acf() {
	$slider = require get_template_directory() . "/components/slider/slider-acf.php";
	$intro = require get_template_directory() . "/components/intro/intro-acf.php";
	$cta = require get_template_directory() . "/components/cta/cta-acf.php";
	$excerpt = require get_template_directory() . "/components/excerpt/excerpt-acf.php";

	$g_overview = new FieldsBuilder( 'overview' );
	$g_overview
		->addFields( $slider )
			->modifyField( 'slider_tab', [ 'label' => 'Hero' ] )
			->modifyField( 'slider->slider_image', [ 'label' => 'Image' ] )
			->modifyField( 'slider',
				[
					'label' => '',
					'max'   => 1,
				]
			)
			->removeField( 'slider->slider_link' )
			->removeField( 'slider->slider_subtitle' )
		->addFields( $intro )
		->addFields( $cta )
		->addFields( $excerpt )
		->setGroupConfig( 'hide_on_screen', [ 'the_content' ] )
		->setLocation( 'page_template', '==', 'template-overview.php' )
			->or( 'page_template', '==', 'template-get-involved.php' );

		return $g_overview;
}

return overview_acf();
