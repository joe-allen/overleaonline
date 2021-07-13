<?php
/**
 * Card ACF
 *
 * @package Vitamin\Overlea\ACF
 */

use StoutLogic\AcfBuilder\FieldsBuilder;

$c_card = new FieldsBuilder( 'card' );

$c_card
	->addText( 'card_example', [ 'label' => 'Delete me!' ] );

return $c_card;
