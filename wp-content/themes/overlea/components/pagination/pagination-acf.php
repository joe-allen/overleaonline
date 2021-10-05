<?php
/**
 * Pagination ACF
 *
 * @package Vitamin\Vanilla_Theme\ACF
 */

use StoutLogic\AcfBuilder\FieldsBuilder;

$c_pagination = new FieldsBuilder( 'pagination' );

$c_pagination
	->addText( 'pagination_example', [ 'label' => 'Delete me!' ] );

return $c_pagination;
