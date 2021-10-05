<?php
/**
 * intro ACF
 *
 * @package Vitamin\Vanilla_Theme\ACF
 */

use StoutLogic\AcfBuilder\FieldsBuilder;

$c_intro = new FieldsBuilder( 'intro' );

$c_intro
	->addTab( 'intro' )
		->addTextarea( 'intro', [ 'new_lines' => 'br' ] );

return $c_intro;
