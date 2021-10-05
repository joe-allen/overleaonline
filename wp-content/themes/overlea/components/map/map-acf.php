<?php
/**
 * Map ACF
 *
 * @package Vitamin\Vanilla_Theme\ACF
 */

use StoutLogic\AcfBuilder\FieldsBuilder;

$c_map = new FieldsBuilder( 'map' );

$c_map
	->addTab( 'google_map' )
		->addGroup( 'Google Maps', [ 'layout' => 'table' ] )
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

return $c_map;
