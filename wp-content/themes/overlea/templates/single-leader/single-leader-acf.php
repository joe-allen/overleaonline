<?php
/**
 * Leader ACF
 *
 * @package Vitamin\Vanilla_Theme\ACF
 */

use StoutLogic\AcfBuilder\FieldsBuilder;

/**
 * Define ACF for the template
 *
 * @return FieldsBuilder
 */
function leader_acf() {

	$title = require get_template_directory() . "/components/title/title-acf.php";
	$content = require get_template_directory() . "/components/content/content-acf.php";

	$g_leader = new FieldsBuilder( 'leader' );
	$g_leader
		->addFields($title)
			->modifyfield( 'title_tab', [ 'label' => 'Info' ] )
			->modifyfield( 'primary_title', [ 'label' => 'Name' ] )
			->modifyfield( 'secondary_title', [ 'label' => 'Position' ] )
			->addTrueFalse(
				'leader_retired',
				[
					'label' => 'Is Retired?',
					'ui' => true,
					'default_value' => 0,

				]
			)
			->addText( 'leader_phone', [ 'label' => 'Phone' ])
			->addEmail( 'leader_email', [ 'label' => 'Email' ])
			->addUrl( 'leader_website', [ 'label' => 'Website (e.g. LinkedIn, Facebook, etc.)' ])
		->addFields($content)
			->modifyField( 'content_tab', [ 'label' => 'Bio' ] )
			->modifyField( 'content', [ 'toolbar' => 'simple' ] )


		->setGroupConfig( 'hide_on_screen', [ 'the_content' ] )
		->setLocation( 'post_type', '==', 'board' )
			->or( 'post_type', '==', 'reps' );

		return $g_leader;
}

return leader_acf();
