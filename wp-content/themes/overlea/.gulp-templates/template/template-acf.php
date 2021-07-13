<?php
/**
 * <%= nameSpaced %> ACF
 *
 * @package Vitamin\<%= theme %>\ACF
 */

use StoutLogic\AcfBuilder\FieldsBuilder;

/**
 * Define ACF for the template
 *
 * @return FieldsBuilder
 */
function <%= nameUnderscore %>_acf() {
	$g_<%= nameUnderscore %> = new FieldsBuilder( '<%= nameUnderscore %>' );
	$g_<%= nameUnderscore %>
		->setGroupConfig( 'hide_on_screen', [ 'the_content' ] )
		->setLocation( 'page_template', '==', 'template-<%= name %>.php' );

		return $g_<%= nameUnderscore %>;
}

return <%= nameUnderscore %>_acf();
