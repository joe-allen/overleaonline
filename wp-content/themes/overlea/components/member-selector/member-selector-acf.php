<?php
/**
 * Member Selector ACF
 *
 * @package Vitamin\Vanilla_Theme\ACF
 */

use StoutLogic\AcfBuilder\FieldsBuilder;

$c_member_selector = new FieldsBuilder( 'member_selector' );

$c_member_selector
	->addTab('Contact')
		->addRelationship(
			'Member',
			[
				'return_format' => 'id',
				'post_type'     => 'board',
				'filters'       => [],
				'min'           => 0,
				'max'           => 1,
			]
		);


return $c_member_selector;
