<?php
/**
 * Leaders ACF
 *
 * @package Vitamin\Vanilla_Theme\ACF
 */

use StoutLogic\AcfBuilder\FieldsBuilder;

/**
 * Define ACF for the template
 *
 * @return FieldsBuilder
 */
function leaders_acf() {
	$g_leaders = new FieldsBuilder( 'leaders' );
	$g_leaders
		->setGroupConfig( 'hide_on_screen', [ 'the_content' ] )
		->setLocation( 'page_template', '==', 'template-leaders.php' );

		return $g_leaders;
}

return leaders_acf();
