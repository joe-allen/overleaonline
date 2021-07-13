<?php
/**
 * ACF
 *
 * All customizations related to ACF, including loading fields
 *
 * @package BoogieDown\Overlea\Functions
 * @author  Vitamin
 * @version 1.1.0
 */

use StoutLogic\AcfBuilder\FieldsBuilder;

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
		->addTab( 'Company' )
		->addEmail( 'company_email', [ 'label' => 'Email' ] )
		->addText( 'company_phone', [ 'label' => 'Phone' ] )
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
