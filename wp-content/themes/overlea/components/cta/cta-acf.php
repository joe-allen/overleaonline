<?php
/**
 * Cta ACF
 *
 * @package Vitamin\Vanilla_Theme\ACF
 */

use StoutLogic\AcfBuilder\FieldsBuilder;

$c_cta = new FieldsBuilder( 'cta' );

$c_cta
	->addTab( 'CTA' )
	  ->addSelect(
			'cta_type',
			[
				'label'   => 'CTA Type',
				'choices' => [
					'Membership' => 'Membership',
					'Newsletter' => 'Newsletter',
					'Opportunities' => 'Opportunities',
					'Random'     => 'Random',
				]
			]
		)
		->setInstructions( 'Excluding "Random", CTA settings can be found under Global Settings > CTAs' )
		->addText(
			'cta_text',
			[
				'label'             => 'Text',
				'conditional_logic' => [
					[
						[
							'field' => 'cta_type',
							'operator' => '==',
							'value' => 'Random'
						]
					]
				]
			]
		)
		->addGroup(
			'cta_link',
			[
				'label' => 'CTA',
				'conditional_logic' => [
					[
						[
							'field' => 'cta_type',
							'operator' => '==',
							'value' => 'Random'
						]
					]
				]
			]
		)
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
								'events',
								'opportunity',
								'board',
								'reps',
								'sponsors',
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
					->endGroup()
				->addText( 'query_string', [ 'prepend' => '?' ] )
			->endGroup();

return $c_cta;
