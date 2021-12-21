<?php
/**
 * Sponsors ACF
 *
 * @package Vitamin\Vanilla_Theme\ACF
 */

use StoutLogic\AcfBuilder\FieldsBuilder;

$c_sponsors = new FieldsBuilder( 'sponsors' );

$c_sponsors
	->addTab( 'sponsors' )
		->addText( 'sponsor_title', [ 'label' => 'Title' ] )
		->addWysiwyg(
			'sponsor_text',
			[
				'label'        => 'Text',
				'toolbar'      => 'basic',
				'media_upload' => 0,
				'delay'        => 1,
			]
		)
		->addRelationship(
			'sponsor',
			[
				'label'         => 'Sponsors',
				'return_format' => 'object',
				'post_type'     => 'sponsors',
				'filters'       => [
					'search'
				],
				'min'           => 0,
				'max'           => 8,
			]
		);

return $c_sponsors;
