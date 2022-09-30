<?php

/*
Plugin Name: Contact Form 7 - Recurring Payments Pro
Plugin URI: https://wpplugin.org/paypal/
Description: Adds recurring payments to Contact Form 7 - PayPal & Stripe Add-on Pro.
Author: Scott Paterson
Author URI: https://wpplugin.org
Version: 1.2.2
*/

/*
Copyright 2014-2020 WPPlugin LLC / Scott Paterson
This is not free software.
You do not have permission to distribute this software under any circumstances.
You may modify this software (excluding the license and update manager) for personal use only if you hold a valid license key.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.

*/

// define
define('CF7PPS_ITEM_ID', 		'121801');
define('CF7PPS_PRODUCT_NAME', 	'Contact Form 7 - Recurring Payments Pro');
define('CF7PPS_VERSION_NUM', 	'1.2.2');
define('CF7PPS_STORE_URL', 		'https://wpplugin.org');
define('CF7PPS_AUTHOR_NAME', 	'Scott Paterson');



// plugin variable: cf7pps

//  plugin functions
register_activation_hook( 	__FILE__, "cf7pps_activate" );
register_deactivation_hook( __FILE__, "cf7pps_deactivate" );
register_uninstall_hook( 	__FILE__, "cf7pps_uninstall" );

function cf7pps_activate() {
}

function cf7pps_deactivate() {
}

function cf7pps_uninstall() {
}




// check plugin requirements
if (defined('CF7PP_VERSION_NUM')) {
	if (version_compare(CF7PP_VERSION_NUM, '2.7', '<')) {
		
		// notices
		add_action( 'admin_notices', create_function( '', "echo '<div class=\"error\"><p>". __('Contact Form 7 - Recurring Payments Pro requires Contact Form 7 - PayPal & Stripe Add-on Pro 2.7+ to function properly.', 'cf7pps'). "</p></div>';" ) );
		
		add_action( 'admin_notices', create_function( '', "echo '<div class=\"error\"><p>".__('Contact Form 7 - Recurring Payments Pro has been auto-deactivated.', 'cf7pps') ."</p></div>';" ) );
		
		// deactivate plugin
		function cf7pps_deactivate_self() {
			deactivate_plugins(plugin_basename( __FILE__ ));
		}
		add_action('admin_init','cf7pps_deactivate_self');
		
		// remove plugin activated notice
		if (isset($_GET['activate'])) {
			unset($_GET['activate']);
		}
		
		return;
	}
}




// check if cf7pp is installed and active
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if (is_plugin_active( 'contact-form-7-paypal-add-on-pro/paypal.php')) {


	// updater
	if( !class_exists( 'cf7pps_updater' ) ) {
		include( 'manager/private_updater.php' );
	}


	// pro version edd updater class
	function cf7pps_plugin_updater() {
		
		// To support auto-updates, this needs to run during the wp_version_check cron job for privileged users.
		$doing_cron = defined( 'DOING_CRON' ) && DOING_CRON;
		if ( ! current_user_can( 'manage_options' ) && ! $doing_cron ) {
			return;
		}
		
		$license_key = trim( get_option('cf7pps_plicsence_keycf7pp') );
		$edd_updater = new cf7pps_updater(CF7PPS_STORE_URL, __FILE__, array(
				'version' 	=> CF7PPS_VERSION_NUM,
				'license' 	=> $license_key,
				'item_id' 	=> CF7PPS_ITEM_ID,
				'author' 	=> CF7PPS_AUTHOR_NAME,
				'url'		=> home_url()
			)
		);
		
	}
	add_action( 'init', 'cf7pps_plugin_updater', 0 );


	// manager
	include_once ('manager/private_manager.php');

	// public includes
	include_once('includes/redirect_paypal.php');
	include_once('includes/redirect_stripe.php');

	// admin includes
	if (is_admin()) {
		include_once('includes/admin/tabs_page.php');
		include_once('includes/admin/settings_page.php');
	}

} else {

	// give warning if contact form 7 paypal addon is not active
	function cf7pps_my_admin_notice() {
		?>
		<div class="error">
			<p><?php _e( '<b>Contact Form 7 - Recurring Payments Pro:</b> Contact Form 7 - PayPal & Stripe Add-on Pro is not installed and / or active! Please install or activate: <a target="_blank" href="https://wpplugin.org/downloads/contact-form-7-paypal-add-on/">Contact Form 7 - PayPal & Stripe Add-on Pro</a>.', 'cf7pp' ); ?></p>
		</div>
		<?php
	}
	add_action( 'admin_notices', 'cf7pps_my_admin_notice' );
	
}



?>
