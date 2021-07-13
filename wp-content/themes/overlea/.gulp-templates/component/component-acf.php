<?php
/**
 * <%= nameSpaced %> ACF
 *
 * @package Vitamin\<%= theme %>\ACF
 */

use StoutLogic\AcfBuilder\FieldsBuilder;

$c_<%= nameUnderscore %> = new FieldsBuilder( '<%= nameUnderscore %>' );

$c_<%= nameUnderscore %>
	->addText( '<%= nameUnderscore %>_example', [ 'label' => 'Delete me!' ] );

return $c_<%= nameUnderscore %>;
