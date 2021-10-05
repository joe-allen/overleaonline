<?php
/**
 * Title ACF
 *
 * @package Vitamin\Vanilla_Theme\ACF
 */

use StoutLogic\AcfBuilder\FieldsBuilder;

$c_title = new FieldsBuilder( 'title' );

$c_title
	->AddTab( 'title' )
		->addText(
			'primary_title',
			[
				'label' => 'Primary Title',
			]
		)
		->setInstructions( 'Page title used if left empty' )
		->addText(
			'secondary_title',
			[
				'label' => 'Secondary Title',
			]
		);


return $c_title;
