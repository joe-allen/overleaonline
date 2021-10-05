<?php
/**
 * Image Content ACF
 *
 * @package Vitamin\Vanilla_Theme\ACF
 */

use StoutLogic\AcfBuilder\FieldsBuilder;

$c_image_content = new FieldsBuilder( 'image_content' );
$c_image_content
	->addTab( 'Image / Content' )
		->addRepeater(
			'ic',
			[
				'label'        => 'Image / Content',
				'button_label' => 'Add Block',
				'min'          => '1',
				'max'          => '6',
				'layout'       => 'block',
			]
		)
			->addImage(
				'ic_image',
				[
					'label'         => 'Image',
					'return_format' => 'id',
					'preview_size'  => 'medium',
				]
			)
			->addText('ic_title', [ 'label' => 'Title' ])
			->addTextarea(
				'ic_text',
				[
					'label' => 'Text',
					'new_lines' => 'br',
				]
			)
			->addFields( v_create_link_field( 'ic_link', 'Link' ) )
		->endRepeater();

return $c_image_content;
