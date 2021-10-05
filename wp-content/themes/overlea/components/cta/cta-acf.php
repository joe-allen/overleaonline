<?php
/**
 * Cta ACF
 *
 * @package Vitamin\Vanilla_Theme\ACF
 */

use StoutLogic\AcfBuilder\FieldsBuilder;

$c_cta = new FieldsBuilder( 'cta' );

$c_cta
	->addTab('CTA')
		->addText( 'cta_text', [ 'label' => 'Text' ] )
		->addFields( v_create_link_field( 'cta_link', 'Link' ) );

return $c_cta;
