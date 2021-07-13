<?php
/**
 * Admin Favicon
 *
 * Apply different admin favicons depending on environment
 *
 * @package BoogieDown\Overlea\Functions
 * @author  Vitamin
 * @version 1.0.0
 */

/**
 * Change favicon
 */
function add_favicon() {
	$template_dir = get_theme_file_uri();
	$sub_dir      = $_ENV['location'];

	/* Expects favicon files from https://favicon.io/favicon-converter/ */

	// phpcs:ignore
	echo "
		<link rel='apple-touch-icon' sizes='180x180' href='$template_dir/favicon-admin/$sub_dir/apple-touch-icon.png'>
		<link rel='icon' type='image/png' sizes='32x32' href='$template_dir/favicon-admin/$sub_dir/favicon-32x32.png'>
		<link rel='icon' type='image/png' sizes='16x16' href='$template_dir/favicon-admin/$sub_dir/favicon-16x16.png'>
		<link rel='manifest' href='$template_dir/favicon-admin/$sub_dir/site.webmanifest'>
	";
};
add_action( 'login_head', 'add_favicon' );
add_action( 'admin_head', 'add_favicon' );
