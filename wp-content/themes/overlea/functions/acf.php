<?php
/**
 * ACF
 *
 * All customizations related to ACF, including loading fields
 *
 * @package Vitamin\Vanilla_Theme\Functions
 * @author  Vitamin
 * @version 1.1.0
 */

use StoutLogic\AcfBuilder\FieldsBuilder;

/**
 * Create a full-featured link field group
 *
 * @param string $name  field name
 * @param string $label field label
 * @return FieldsBuilder ACF builder fields
 * @throws FieldNameCollisionException ACF Builder collision
 */
function v_create_link_field( $name, $label ) {
	$field_group = new FieldsBuilder( 'vitamin_button' );
	return (
		$field_group
			->addGroup( $name, [ 'label' => $label ] )
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
				->endGroup()
	);
}

/**
 * Load ACF fields from templates and components
 *
 * Grabs files ending in -acf.php from templates (Field Groups)
 * and builds ACF builder. Also defines any Options page fields.
 */
function v_define_acf() {
	$acf_groups = [];
	foreach ( glob( get_template_directory() . '/templates/**/*-acf.php' ) as $filename ) {
		$group        = include $filename;
		$acf_groups[] = $group->build();
	}

	$g_global = new FieldsBuilder( 'global_settings' );
	$g_global
		->addTab( 'Association' )
			->addEmail( 'association_email', [ 'label' => 'Email' ] )
			->addText( 'association_phone', [ 'label' => 'Phone' ] )
		->addTab( 'Social' )
			->addRepeater( 'company_social', [ 'label' => 'Social Links' ] )
				->addSelect( 'icon' )
					->addChoices(
						[ 'facebook'  => 'Facebook' ],
						[ 'twitter'   => 'Twitter' ],
						[ 'instagram' => 'Instagram' ],
					)
				->addUrl( 'url', [ 'label' => 'URL' ] )
			->endRepeater()
		->addTab( 'Contact Form' )
			->addText( 'contact_form_title', [ 'label' => 'Title' ] )
			->addText( 'contact_form_text', [ 'label' => 'Text' ] )
		->addTab( 'News' )
			->addText( 'news_title', [ 'label' => 'Title' ] )
			->addText( 'news_subtitle', [ 'label' => 'Text' ] )
			->addFields( v_create_link_field( 'news_link', 'CTA Link' ) )
		->addTab( 'Recent News' )
			->addText( 'news_title_recent', [ 'label' => 'Title' ] )
			->addText( 'news_subtitle_recent', [ 'label' => 'Text' ] )
			->addFields( v_create_link_field( 'news_link_recent', 'CTA Link' ) )
		->addTab( 'CTAs' )
			->addgroup( 'Newsletter' )
				->addText(
					'text',
						[
							'label' => 'Text',
							'default_value' => 'Sign up for our newsletter',
						]
					)
				->addText(
					'link',
					[
						'label' => 'Link Title',
						'default_value' => 'Sign up',
					]
				)
			->endGroup()
			->addgroup( 'Membership' )
				->addText(
					'text',
						[
							'label' => 'Text',
							'default_value' => 'Become a member today and help support the growth and beautification of our community',
						]
					)
				->addFields(
					v_create_link_field( 'membership_link', 'CTA Link' )
					->removeField( 'membership_link->link_type' )
					->removeField( 'membership_link->query_string' )
					->removeField( 'membership_link->link->external_url' )
					->modifyField( 'membership_link->link->text', [ 'default_value' => 'Join' ] )
				)
			->endGroup()
			->addgroup( 'Opportunities' )
				->addText(
					'text',
						[
							'label' => 'Text',
							'default_value' => 'Want to give back? Check out our opportunities',
						]
					)
				->addFields(
					v_create_link_field( 'opportunities_link', 'CTA Link' )
					->removeField( 'opportunities_link->link_type' )
					->removeField( 'opportunities_link->query_string' )
					->removeField( 'opportunities_link->link->external_url' )
					->modifyField( 'opportunities_link->link->text', [ 'default_value' => 'View' ] )
				)
			->endGroup()
		->setLocation( 'options_page', '==', 'acf-options-global-settings' );

	$acf_groups[] = $g_global->build();

	if ( function_exists( 'acf_add_local_field_group' ) ) {
		foreach ( $acf_groups as $group ) {
			acf_add_local_field_group( $group );
		}
	}
}
add_action( 'acf/init', 'v_define_acf' );

// Supposedly helps speed up the WP admin interface.
add_filter( 'acf/settings/remove_wp_meta_box', '__return_true' );

/**
 * (Optional) Hide the ACF admin menu item.
 *
 * @param  bool $show_admin show/hide in admin flag
 * @return bool
 */
function v_acf_settings_show_admin( $show_admin ) {
	// User 1 should always be Vitamin
	return ( 1 === get_current_user_id() );
}
add_filter( 'acf/settings/show_admin', 'v_acf_settings_show_admin' );
