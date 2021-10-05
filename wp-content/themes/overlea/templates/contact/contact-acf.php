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
	$g_contact = new FieldsBuilder( 'contact' );
	$g_contact
		->setGroupConfig( 'hide_on_screen', [ 'the_content' ] )
		->setLocation( 'page_template', '==', 'template-contact.php' );

		return $g_contact;
}

return contact_acf();
