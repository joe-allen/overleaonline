<?php
/**
 * Overview ACF
 *
 * @package Vitamin\Vanilla_Theme\ACF
 */

use StoutLogic\AcfBuilder\FieldsBuilder;

/**
 * Define ACF for the template
 *
 * @return FieldsBuilder
 */
function overview_acf() {
	$g_overview = new FieldsBuilder( 'overview' );
	$g_overview
		->setGroupConfig( 'hide_on_screen', [ 'the_content' ] )
		->setLocation( 'page_template', '==', 'template-overview.php' );

		return $g_overview;
}

return overview_acf();
