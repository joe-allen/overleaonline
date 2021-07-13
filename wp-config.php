<?php
/**
 * WP Config
 *
 * WP initial Configuration
 *
 * @package Vitamin/Vanilla_Theme/Core_Components
 * @author  Vitamin
 * @version 1.0.0
 */

include dirname( __FILE__ ) . '/_env.php';

define( 'DB_NAME', $_ENV['db_name'] );
define( 'DB_USER', $_ENV['db_user'] );
define( 'DB_PASSWORD', $_ENV['db_pass'] );
define( 'DB_HOST', 'localhost' );
define( 'DB_CHARSET', 'utf8' );
define( 'DB_COLLATE', '' );
$table_prefix = $_ENV['db_prefix'];

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

if ( 'local' !== $_ENV['location'] ) {
	define( 'DISALLOW_FILE_EDIT', true );
	define( 'DISALLOW_FILE_MODS', true );
}