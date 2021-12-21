<?php
/**
 * Contact ACF
 *
 * @package Vitamin\Vanilla_Theme\ACF
 */

use StoutLogic\AcfBuilder\FieldsBuilder;

/**
 * Define ACF for the template
 *
 * @return FieldsBuilder
 */
function contact_acf() {
	$hero = require get_template_directory() . "/components/hero/hero-acf.php";
	$intro = require get_template_directory() . "/components/intro/intro-acf.php";

	$g_contact = new FieldsBuilder( 'contact' );
	$g_contact
		->addFields($hero)
		->addFields($intro)

		->setGroupConfig( 'hide_on_screen', [ 'the_content' ] )
		->setLocation( 'page_template', '==', 'template-contact.php' );

		return $g_contact;
}

return contact_acf();
