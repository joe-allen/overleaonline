<?php
/**
 * Hero Homepage ACF
 *
 * @package Vitamin\Vanilla_Theme\ACF
 */

use StoutLogic\AcfBuilder\FieldsBuilder;

$c_hero = new FieldsBuilder( 'hero' );

$c_hero
	->addTab( 'Hero' )
		->addImage(
			'hero_img',
			[
				'label'         => 'Image',
				'return_format' => 'id',
				'preview_size'  => 'medium',
			]
		)
		->setInstructions('Recommended size: 1920px by 1280px');

return $c_hero;
