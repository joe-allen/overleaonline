<?php
/**
 * Slider ACF
 *
 * @package Vitamin\Vanilla_Theme\ACF
 */

use StoutLogic\AcfBuilder\FieldsBuilder;

$c_slider = new FieldsBuilder( 'slider' );

$c_slider
	->addTab( 'slider' )
	->addRepeater(
		'slider',
		[
			'label'        => 'Slides',
			'button_label' => 'Add Slide',
			'min'          => '1',
			'max'          => '6',
			'layout'       => 'block',
		]
	)
		->addImage(
			'slider_image',
			[
				'label'         => 'Slide Image',
				'return_format' => 'id',
				'preview_size'  => 'medium',
			]
		)
		->addTrueFalse(
			'slider_img_blur',
			[
				'label' => 'Contain image?',
				'ui' => true,
				'default_value' => 0,
			]
		)
		->setInstructions('Do not crop image. This is useful for images that are not near the suggested dimensions.')
		->addFields( v_create_link_field( 'slider_link', 'Slide Link' ) )
		->addText( 'slider_subtitle', [ 'label' => 'Slide Subtitle' ] )
	->endRepeater();

return $c_slider;
