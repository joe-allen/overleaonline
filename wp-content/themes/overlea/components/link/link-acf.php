<?php
/**
 * Link ACF
 *
 * @package Vitamin\Vanilla_Theme\ACF
 */

use StoutLogic\AcfBuilder\FieldsBuilder;

$c_link = new FieldsBuilder( 'link' );

$c_link
	->addTab( 'link' )
		->addSelect( 'link_type' )
		->addChoices( [ 'internal' => 'Internal' ], [ 'external' => 'External' ] )
		->addGroup( 'link', [ 'layout' => 'table' ] )
			->addText( 'text' )
			->addPageLink(
				'internal_url',
				[
					'label'      => 'URL',
					'post_type'  => [
						'post',
						'page',
					],
					'allow_null' => true,
				]
			)
				->conditional( 'link_type', '==', 'internal' )
			->addUrl( 'external_url', [ 'label' => 'URL' ] )
				->conditional( 'link_type', '==', 'external' )
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

return $c_link;
