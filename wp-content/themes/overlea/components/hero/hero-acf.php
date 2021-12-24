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
		->setInstructions('Do not crop image. This is useful when entire image needs to be seen and image size is not near the suggested dimensions.');

return $c_hero;
