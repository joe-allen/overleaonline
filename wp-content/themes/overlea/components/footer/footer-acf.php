<?php
/**
 * Footer ACF
 *
 * @package Vitamin\Vanilla_Theme\ACF
 */

use StoutLogic\AcfBuilder\FieldsBuilder;

$c_footer = new FieldsBuilder( 'footer' );

$c_footer
	->addText( 'footer_example', [ 'label' => 'Delete me!' ] );

return $c_footer;
