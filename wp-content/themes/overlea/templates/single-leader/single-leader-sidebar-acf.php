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
function leader_headshot_acf() {

	$g_leader_headshot = new FieldsBuilder( 'leader_headshot' );
	$g_leader_headshot
		->addImage(
			'leader_headshot',
			[
				'label'         => 'Image',
				'return_format' => 'id',
				'preview_size'  => 'medium',
			]
		)
			->setInstructions( 'Image size: 900x900, ratio of 1:1 (square)' )

		->setGroupConfig( 'position', 'side' )
		->setLocation( 'post_type', '==', 'board' )
			->or( 'post_type', '==', 'reps' );

		return $g_leader_headshot;
}

return leader_headshot_acf();
