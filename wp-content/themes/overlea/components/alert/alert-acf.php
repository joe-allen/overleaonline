<?php
/**
 * Alert ACF
 *
 * @package Vitamin\Vanilla_Theme\ACF
 */

use StoutLogic\AcfBuilder\FieldsBuilder;

$c_alert = new FieldsBuilder( 'alert' );

$c_alert
	->addText( 'alert_example', [ 'label' => 'Delete me!' ] );

return $c_alert;
