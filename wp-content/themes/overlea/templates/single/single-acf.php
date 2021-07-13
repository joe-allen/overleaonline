<?php
/**
 * Single ACF
 *
 * @package BoogieDown\Overlea\ACF
 */

use StoutLogic\AcfBuilder\FieldsBuilder;

/**
 * Define ACF for the template
 *
 * @return FieldsBuilder
 */
function single_acf() {
	$g_single = new FieldsBuilder( 'news' );
	$g_single
		->setGroupConfig( 'hide_on_screen', [ 'the_content' ] )
		->setLocation( 'post_type', '==', 'post' );

		return $g_single;
}

return single_acf();
