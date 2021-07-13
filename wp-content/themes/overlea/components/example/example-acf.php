<?php
/**
 * Example ACF
 *
 * @package BoogieDown\Overlea\ACF
 */

use StoutLogic\AcfBuilder\FieldsBuilder;

$c_example = new FieldsBuilder( 'example' );

$c_example
	->addText( 'example' );

return $c_example;
