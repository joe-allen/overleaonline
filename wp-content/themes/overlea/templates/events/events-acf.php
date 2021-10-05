<?php
/**
 * Events ACF
 *
 * @package Vitamin\Vanilla_Theme\ACF
 */

use StoutLogic\AcfBuilder\FieldsBuilder;

/**
 * Define ACF for the template
 *
 * @return FieldsBuilder
 */
function events_acf() {

	$title = require get_template_directory() . "/components/title/title-acf.php";
	$hero = require get_template_directory() . "/components/hero/hero-acf.php";
	$sponsors = require get_template_directory() . "/components/sponsors/sponsors-acf.php";
	$map = require get_template_directory() . "/components/map/map-acf.php";
	$content = require get_template_directory() . "/components/content/content-acf.php";
	$member_selector = require get_template_directory() . "/components/member-selector/member-selector-acf.php";
	$date_picker = require get_template_directory() . "/components/date-picker/date-picker-acf.php";
	$zoom = require get_template_directory() . "/components/zoom/zoom-acf.php";
	$excerpt = require get_template_directory() . "/components/excerpt/excerpt-acf.php";

	$g_events = new FieldsBuilder( 'event' );
	$g_events
		->addFields( $title )
		->addFields( $hero )
		->addFields( $sponsors )
		->addFields( $map )
		->addFields( $content )
		->addFields( $member_selector )
			// ->modifyField('contact_tab',
			// 	[
			// 		'label' => 'Noo'
			// 	]
			// )
			// ->modifyField('Member',
			// 	[
			// 		'post_type' => 'reps'
			// 	]
			// )
		->addFields( $date_picker )
		->addFields( $zoom )
		->addFields( $excerpt )

		->setGroupConfig( 'hide_on_screen', [ 'the_content' ] )
		->setLocation( 'post_type', '==', 'events' );

		return $g_events;
}

return events_acf();
