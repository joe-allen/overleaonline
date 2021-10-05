<?php
/**
 * Content ACF
 *
 * @package Vitamin\Vanilla_Theme\ACF
 */

use StoutLogic\AcfBuilder\FieldsBuilder;

$c_content = new FieldsBuilder( 'content' );

$c_content
	->addTab( 'content')
		->addWysiwyg(
			'content',
			[
				'toolbar' => 'full',
				'delay'   => 1,
			]
		);

return $c_content;
