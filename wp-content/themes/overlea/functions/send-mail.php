<?php
/**
 * Send Mail
 *
 * Modify mail settings based on site environment
 *
 * @package BoogieDown\Overlea\Functions
 * @author  Vitamin
 * @version 1.0.0
 */

/**
 * Redirects wp_mail to MailHog on local installs
 *
 * @param  object $phpmailer phpMailer object
 *
 * @return void
 */
function v_catch_mail( $phpmailer ) {
	if ( 'local' !== $_ENV['location'] ) {
		return;
	}

	// phpcs:disable WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
	$phpmailer->isSMTP();
	$phpmailer->Host     = 'localhost';
	$phpmailer->SMTPAuth = false;
	$phpmailer->Port     = '1025';
	$phpmailer->From     = 'site_adm@wp.local';
	$phpmailer->FromName = 'WP DEV';
	// phpcs:enable
}
add_action( 'phpmailer_init', 'v_catch_mail', 10, 1 );

/**
 * Modify sender address on staging
 *
 * @param  string $original_email_address sender address
 * @return string
 */
function v_change_sender_email( $original_email_address ) {
	return 'client-name@vitaminisgood.com';
}
add_filter( 'wp_mail_from', 'v_change_sender_email' );
