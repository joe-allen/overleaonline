<?php
/**
 * Zoom ACF
 *
 * @package Vitamin\Vanilla_Theme\ACF
 */

use StoutLogic\AcfBuilder\FieldsBuilder;

$c_zoom = new FieldsBuilder( 'zoom' );

$c_zoom
	->addTab( 'zoom' )
		->addGroup( 'Zoom', [ 'layout' => 'table' ] )
			->addText( 'text' )
			->addUrl( 'external_url', [ 'label' => 'URL' ] )
			->addTrueFalse(
				'new_tab',
				[
					'label'   => 'Open in a new tab?',
					'ui'      => true,
					'wrapper' => [
						'width' => '25',
					],
				]
			)
		->endGroup();

return $c_zoom;
