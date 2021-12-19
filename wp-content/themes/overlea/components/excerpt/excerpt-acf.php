<?php
/**
 * Excerpt ACF
 *
 * @package Vitamin\Vanilla_Theme\ACF
 */

use StoutLogic\AcfBuilder\FieldsBuilder;

$c_excerpt = new FieldsBuilder( 'excerpt' );

$c_excerpt
	->addTab( 'excerpt' )
		->addTextarea( 'excerpt', [ 'required' => 1 ] )
			->setInstructions( '120-150 characters. Used for SEO and search results.' );

return $c_excerpt;
