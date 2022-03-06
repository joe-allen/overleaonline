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
	$slider = require get_template_directory() . "/components/slider/slider-acf.php";
	$intro = require get_template_directory() . "/components/intro/intro-acf.php";
	$content = require get_template_directory() . "/components/content/content-acf.php";
	$ic = require get_template_directory() . "/components/image-content/image-content-acf.php";
	$cta = require get_template_directory() . "/components/cta/cta-acf.php";
	$excerpt = require get_template_directory() . "/components/excerpt/excerpt-acf.php";

	$g_page = new FieldsBuilder( 'page' );
	$g_page
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
		->addFields( $content )
		->addFields( $ic )
		->addFields( $cta )
		->addFields( $excerpt )
		->setGroupConfig( 'hide_on_screen', [ 'the_content' ] )
		->setLocation( 'post_type', '==', 'page' )
			->and( 'page_template', '==', 'default' )
			->and( 'page_type', '!=', 'front_page' )
			->and( 'page_type', '!=', 'posts_page' );

		return $g_page;
}

return page_acf();
