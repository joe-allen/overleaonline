<?php
/**
 * Functions
 *
 * Various site features defined as partials. Loads composer dependencies.
 *
 * @package Vitamin\Vanilla_Theme\Functions
 * @author  Vitamin
 * @version 1.2.0
 */

// Load composer
require __DIR__ . '/vendor/autoload.php';

// Init Timber
$timber = new Timber\Timber();

foreach ( glob( get_template_directory() . '/functions/*.php' ) as $filename ) {
	include $filename;
}
