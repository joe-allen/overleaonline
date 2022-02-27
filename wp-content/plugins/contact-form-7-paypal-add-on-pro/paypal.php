<?php

/*
Plugin Name: Contact Form 7 - PayPal & Stripe Add-on Pro
Plugin URI: https://wpplugin.org/downloads/contact-form-7-paypal-add-on/
Description: Integrates PayPal & Stripe with Contact Form 7
Author: Scott Paterson
Author URI: https://wpplugin.org
Version: 2.9.6
*/

/*
Copyright 2014-2021 WPPlugin LLC / Scott Paterson
This is not free software.
You do not have permission to distribute this software under any circumstances.
You may modify this software (excluding the license and update manager) for personal use only if you hold a valid license key.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.

*/


// plugin variable: cf7pp



// empty function used by free version to check if pro version is installed
function cf7pp_pro() {
}

// check if free version is attempting to be activated - if so, then deactive the pro version
if (function_exists('cf7pp_free')) {

	deactivate_plugins('contact-form-7-paypal-add-on/paypal.php');

} else {

	// define
	define('CF7PP_PRODUCT_NAME', 	'Contact Form 7 - PayPal & Stripe Add-on Pro');
	define('CF7PP_VERSION_NUM', 	'2.9.6');
	define('CF7PP_STORE_URL', 		'https://wpplugin.org');
	define('CF7PP_AUTHOR_NAME', 	'Scott Paterson');
	define('CF7PP_ITEM_ID', 		'26');

	//  plugin functions
	register_activation_hook( 	__FILE__, "cf7pp_activate" );
	register_deactivation_hook( __FILE__, "cf7pp_deactivate" );
	register_uninstall_hook( 	__FILE__, "cf7pp_uninstall" );

	function cf7pp_activate() {

		// default options
		$cf7pp_options = array(
			'currency'    			=> '25',
			'language'    			=> '3',
			'liveaccount'    		=> '',
			'sandboxaccount'    	=> '',
			'mode' 					=> '2',
			'cancel'    			=> '',
			'return'    			=> '',
			'redirect'				=> '1',
			'session'				=> '1',
			'tax'					=> '',
			'tax_rate'				=> '',
			'validation'			=> '',
			'skip_email'			=> '1',
			'stripe_webhook_id'		=> '',
			'acct_id_test'        	=> '',
			'acct_id_live'        	=> ''
		);
		
		add_option("cf7pp_options", $cf7pp_options);
	}

	function cf7pp_deactivate() {
		
		delete_option("cf7pp_my_plugin_notice_shown");
		
	}

	function cf7pp_uninstall() {
	}
	

	// check to make sure contact form 7 is installed and active
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	if ( is_plugin_active( 'contact-form-7/wp-contact-form-7.php' ) ) {
		
		
		// updater
		if( !class_exists( 'cf7pp_updater' ) ) {
			include( 'manager/private_updater.php' );
			
		}
		
		
		// pro version edd updater class
		function cf7pp_plugin_updater() {
			
			// To support auto-updates, this needs to run during the wp_version_check cron job for privileged users.
			$doing_cron = defined( 'DOING_CRON' ) && DOING_CRON;
			if ( ! current_user_can( 'manage_options' ) && ! $doing_cron ) {
				return;
			}
			
			$license_key = trim( get_option('cf7pp_plicsence_keycf7pp') );
			$edd_updater = new cf7pp_updater(CF7PP_STORE_URL, __FILE__, array(
					'version' 	=> CF7PP_VERSION_NUM,
					'license' 	=> $license_key,
					'item_id' 	=> CF7PP_ITEM_ID,
					'author' 	=> CF7PP_AUTHOR_NAME,
					'url'		=> home_url()
				)
			);
			
		}
		add_action( 'init', 'cf7pp_plugin_updater', 0 );
	

		// manager
		include_once ('manager/private_manager.php');
		
		// public includes
		include_once('includes/functions.php');
		include_once('includes/redirect_methods.php');
		include_once('includes/redirect_paypal.php');
		include_once('includes/redirect_stripe.php');
		include_once('includes/enqueue.php');
		
		if (!class_exists('Stripe\Stripe')) {
			include_once('includes/stripe_library/init.php');
		}
		
		// admin includes
		if (is_admin()) {
			include_once('includes/admin/tabs_page.php');
			include_once('includes/admin/settings_page.php');
			include_once('includes/admin/menu_links.php');
			include_once('includes/admin/files.php');
			include_once('includes/admin/notices.php');
		}
		
		// include payments functionality
		include_once('includes/payments/payments.inc.php');

		// include stripe-connect
		include_once('includes/stripe-connect.php');
		
		// start session if not already started and session support is enabled
		$options = get_option('cf7pp_options');
		
		if (empty($options['session'])) {
			$session = '1';
		} else {
			$session = $options['session'];
		}
		
		if ($session == '2') {
			function cf7pp_session() {
				if(!session_id()) {
					session_start();
					session_write_close();
				}
			}
			add_action('init', 'cf7pp_session', 1);
			
		}
		
		
		
		
	} else {
		
		// give warning if contact form 7 is not active
		function cf7pp_my_admin_notice() {
			?>
			<div class="error">
				<p><?php _e( '<b>Contact Form 7 - PayPal & Stripe Add-on Pro:</b> Contact Form 7 is not installed and / or active! Please install <a target="_blank" href="https://wordpress.org/plugins/contact-form-7/">Contact Form 7</a>.', 'cf7pp' ); ?></p>
			</div>
			<?php
		}
		add_action( 'admin_notices', 'cf7pp_my_admin_notice' );
		
	}
}


?>
