<?php
/**
 * Single Opportunity ACF
 *
 * @package Vitamin\Vanilla_Theme\ACF
 */

use StoutLogic\AcfBuilder\FieldsBuilder;

/**
 * Define ACF for the template
 *
 * @return FieldsBuilder
 */
function single_opportunity_acf() {

	$hero = require get_template_directory() . "/components/hero/hero-acf.php";
	$sponsors = require get_template_directory() . "/components/sponsors/sponsors-acf.php";
	$map = require get_template_directory() . "/components/map/map-acf.php";
	$content = require get_template_directory() . "/components/content/content-acf.php";
	$member_selector = require get_template_directory() . "/components/member-selector/member-selector-acf.php";
	$date_picker = require get_template_directory() . "/components/date-picker/date-picker-acf.php";
	// $excerpt = require get_template_directory() . "/components/excerpt/excerpt-acf.php";

	$g_single_opportunity = new FieldsBuilder( 'opportunity' );
	$g_single_opportunity
		->addFields( $hero )
			->modifyField( 'hero_img', [ 'instructions' => 'Recommended size: 1920px by 1080px. Less than 500kb' ] )
		->addFields( $date_picker )
		->addFields( $content )
			->modifyField( 'content', [ 'toolbar' => 'bare' ] )
		->addFields( $map )
		->addFields( $member_selector )
		->addFields( $sponsors )
			->removeField( 'sponsor_title' )
			->removeField( 'sponsor_text' )

		->setGroupConfig( 'hide_on_screen', [ 'the_content' ] )
		->setLocation( 'post_type', '==', 'opportunity' );

		return $g_single_opportunity;
}

return single_opportunity_acf();
