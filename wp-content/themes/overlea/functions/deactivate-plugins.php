<?php
/**
 * Deactivate Plugins
 *
 * Make plugins available depending on the environment
 *
 * @package BoogieDown\Overlea\Functions
 * @author  Vitamin
 * @version 1.0.0
 */

/**
 * Turns of certain plugins depending on the install location
 *
 * @return void
 */
function deactivate_plugin_conditional() {
	if ( is_plugin_active( 'wordfence/wordfence.php' ) && 'production' !== $_ENV['location'] ) {
		deactivate_plugins( 'wordfence/wordfence.php' );
	}

	if ( is_plugin_active( 'akismet/akismet.php' ) && 'production' !== $_ENV['location'] ) {
		deactivate_plugins( 'akismet/akismet.php' );
	}

	if ( is_plugin_active( 'w3-total-cache/w3-total-cache.php' ) && 'production' !== $_ENV['location'] ) {
		deactivate_plugins( 'w3-total-cache/w3-total-cache.php' );
	}
}
add_action( 'admin_init', 'deactivate_plugin_conditional' );
