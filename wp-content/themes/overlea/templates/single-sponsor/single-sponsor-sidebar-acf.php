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
function sponsor_logo_acf() {

	$g_sponsor_logo = new FieldsBuilder( 'sponsor_logo' );
	$g_sponsor_logo
		->addImage(
			'sponsor_logo',
			[
				'label'         => 'Image',
				'return_format' => 'id',
				'preview_size'  => 'medium',
			]
		)
			->setInstructions( 'Recommended size: 512x512' )

		->setGroupConfig( 'position', 'side' )
		->setLocation( 'post_type', '==', 'sponsors' );

		return $g_sponsor_logo;
}

return sponsor_logo_acf();
