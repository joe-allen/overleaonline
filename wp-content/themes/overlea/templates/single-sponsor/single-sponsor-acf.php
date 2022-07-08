<?php
/**
 * Leader ACF
 *
 * @package Vitamin\Vanilla_Theme\ACF
 */

use StoutLogic\AcfBuilder\FieldsBuilder;

/**
 * Define ACF for the template
 *
 * @return FieldsBuilder
 */
function sponsor_acf() {

	$title = require get_template_directory() . "/components/title/title-acf.php";
	// $content = require get_template_directory() . "/components/content/content-acf.php";

	$g_sponsor = new FieldsBuilder( 'sponsor' );
	$g_sponsor
		->addFields($title)
			->modifyfield( 'title_tab', [ 'label' => 'Info' ] )
			->modifyfield( 'primary_title', [ 'label' => 'Name' ] )
			->modifyfield( 'secondary_title', [ 'label' => 'Slogan' ] )
			->addText( 'sponsor_phone', [ 'label' => 'Phone' ])
			->addEmail( 'sponsor_email', [ 'label' => 'Email' ])
			->addUrl( 'sponsor_website', [ 'label' => 'Website' ])
		// ->addFields($content)
			// ->modifyField( 'content_tab', [ 'label' => 'Bio' ] )
			// ->modifyField( 'content', [ 'toolbar' => 'basic' ] )


		->setGroupConfig( 'hide_on_screen', [ 'the_content' ] )
		->setLocation( 'post_type', '==', 'sponsors' );

		return $g_sponsor;
}

return sponsor_acf();
