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
		->setInstructions('Recommended size: 1920px by 1280px')
		->addTrueFalse(
			'hero_img_blur',
			[
				'label' => 'Contain image?',
				'ui' => true,
				'default_value' => 0,
			]
		)
		->setInstructions('This will not crop the image and will show a duplicated blurred image in the background on desktop devices');

return $c_hero;
