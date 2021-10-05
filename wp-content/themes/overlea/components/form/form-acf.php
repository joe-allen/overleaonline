<?php
/**
 * Form ACF
 *
 * @package Vitamin\Vanilla_Theme\ACF
 */

use StoutLogic\AcfBuilder\FieldsBuilder;

$c_form = new FieldsBuilder( 'form' );

$c_form
	->addText( 'form_example', [ 'label' => 'Delete me!' ] );

return $c_form;
