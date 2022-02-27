<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

define('CF7PP_STRIPE_CONNECT_ENDPOINT', 'https://wpplugin.org/stripe/connect.php');

function cf7pp_stripe_connection_status($form_id) {
	global $stripeConnectionStatus;

	if ( !isset($stripeConnectionStatus) ) {
		$stripeConnectionStatus = false;

		if (empty($form_id)) {
			$options = get_option('cf7pp_options');

			if ($options['mode_stripe'] == "2") {
				$account_id_key = 'acct_id_live';
				$stripe_connect_token_key = 'stripe_connect_token_live';
				$mode = 'live';
			} else {
				$account_id_key = 'acct_id_test';
				$stripe_connect_token_key = 'stripe_connect_token_test';
				$mode = 'sandbox';
			}

			$account_id = isset($options[$account_id_key]) ? $options[$account_id_key] : '';
			$token = isset($options[$stripe_connect_token_key]) ? $options[$stripe_connect_token_key] : '';
		} else {
			$account_id = get_post_meta($form_id, '_cf7pp_stripe_account_id', true);
			$token = get_post_meta($form_id, '_cf7pp_stripe_token', true);
			$mode = get_post_meta($form_id, '_cf7pp_sandbox', true) == '1' ? 'sandbox' : 'live';
		}

		if (!empty($account_id)) {
			$url = CF7PP_STRIPE_CONNECT_ENDPOINT . '?' . http_build_query(
				array(
					'action'		=> 'checkStatus',
					'mode'			=> $mode,
					'account_id'	=> $account_id,
					'token'			=> $token
				)
			);
			
			$opts = array(
				'http' => array(
					'header' => "Referer: " . site_url($_SERVER['REQUEST_URI'])
				)
			);
			$context = stream_context_create($opts);
			
			// changed to wp_remote_get instead of file_get_contents since many hosting companies have this blocked
			
			$account = wp_remote_post($url);
			
			$account = json_decode($account['body'], true);

			if (!empty($account['payouts_enabled']) && intval($account['payouts_enabled']) === 1) {
				$stripeConnectionStatus['email'] 		= $account['email'];
				$stripeConnectionStatus['display_name'] = $account['display_name'];
				$stripeConnectionStatus['mode'] 		= $mode;
				$stripeConnectionStatus['account_id'] 	= $account_id;
				$stripeConnectionStatus['token'] 		= $token;
			}
		}
	}

	return $stripeConnectionStatus;
}

function cf7pp_stripe_connection_status_html($form_id = 0) {
	$connected = cf7pp_stripe_connection_status($form_id);

	if ($connected) {
		$reconnect_mode = $connected['mode'] == 'live' ? 'sandbox' : 'live';
		$result = sprintf(
			'<div class="notice inline notice-success cf7pp-stripe-connect">
				<p><strong>%s</strong><br>%s — Administrator (Owner)</p>
			</div>
			<div>
				Your Stripe account is connected in <strong>%s</strong> mode. <a href="%s">Connect in <strong>%s</strong> mode</a>, or <a href="%s">disconnect this account</a>.
			</div>',
			$connected['display_name'],
			$connected['email'],
			$connected['mode'],
			cf7pp_stripe_connect_url($form_id, $reconnect_mode),
			$reconnect_mode,
			cf7pp_stripe_disconnect_url($form_id, $connected['account_id'], $connected['token'])
		);
	} else {
		$result = sprintf(
			'<a href="%s"" class="stripe-connect-btn"><span>Connect with Stripe</span></a><br /><br />Setup Stripe Connect. You only pay the standard Stripe fees. Have questions about connecting with Stripe? Please see the <a target="_blank" href="https://wpplugin.org/documentation/stripe-connect/">documentation</a>. ',
			cf7pp_stripe_connect_url($form_id)
		);
	}

	return $result;
}

function cf7pp_stripe_connect_url($form_id = 0, $mode = false) {
	if ( $mode === false ) {
		$options = get_option('cf7pp_options');
		$mode = $options['mode_stripe'] == 1 ? 'sandbox' : 'live';
	}

	$stripe_connect_url = CF7PP_STRIPE_CONNECT_ENDPOINT . '?' . http_build_query(
		array(
			'action'		=> 'connect',
			'mode'			=> $mode,
			'return_url'	=> cf7pp_stripe_connect_tab_url($form_id),
			'form_id'		=> $form_id
		)
	);

	return $stripe_connect_url;
}

function cf7pp_stripe_disconnect_url($form_id, $account_id, $token) {
	$options = get_option('cf7pp_options');

	$stripe_connect_url = CF7PP_STRIPE_CONNECT_ENDPOINT . '?' . http_build_query(
		array(
			'action'		=> 'disconnect',
			'mode'			=> $options['mode_stripe'] == 1 ? 'sandbox' : 'live',
			'return_url'	=> cf7pp_stripe_connect_tab_url($form_id),
			'account_id'	=> $account_id,
			'token'			=> $token,
			'form_id'		=> $form_id
		)
	);

	return $stripe_connect_url;
}

function cf7pp_stripe_connect_tab_url($form_id) {
	if (empty($form_id)) {
		$url = add_query_arg(
			array(
				'page'	=> 'cf7pp_admin_table',
				'tab'	=> '5'
			),
			admin_url('admin.php')
		);
	} else {
		$url = add_query_arg(
			array(
				'page'			=> 'wpcf7',
				'post'			=> $form_id,
				'active-tab'	=> 4
			),
			admin_url('admin.php')
		);
	}
	
	return $url;
}

add_action('plugins_loaded', 'cf7pp_stripe_connect_completion');
function cf7pp_stripe_connect_completion() {
	if (empty($_GET['cf7pp_stripe_connect_completion']) || intval($_GET['cf7pp_stripe_connect_completion']) !== 1 || empty($_GET['mode']) || empty($_GET['account_id']) || empty($_GET['token']) || !isset($_GET['form_id'])) return;

	if (!current_user_can('manage_options')) {
		return;
	}
	
	$account_id = sanitize_text_field($_GET['account_id']);
	$token = sanitize_text_field($_GET['token']);
	$access_token = sanitize_text_field($_GET['access_token']);
	$stripe_publishable_key = sanitize_text_field($_GET['stripe_publishable_key']);

	if ($_GET['mode'] == 'live') {
		$account_id_key = 'acct_id_live';
		$stripe_connect_token_key = 'stripe_connect_token_live';
		$access_token_key = 'stripe_access_token_live';
		$stripe_publishable_key_key = 'stripe_publishable_key_live';
		$mode_stripe = 2;
	} else {
		$account_id_key = 'acct_id_test';
		$stripe_connect_token_key = 'stripe_connect_token_test';
		$access_token_key = 'stripe_access_token_test';
		$stripe_publishable_key_key = 'stripe_publishable_key_test';
		$mode_stripe = 1;
	}

	$form_id = intval($_GET['form_id']);

	if (empty($form_id)) {
		$options = get_option('cf7pp_options');
		$options[$account_id_key] 				= $account_id;
		$options[$stripe_connect_token_key] 	= $token;
		$options[$access_token_key] 			= $access_token; // access_token - You can use it as you would any Stripe secret API key. https://stripe.com/docs/connect/oauth-reference
		$options[$stripe_publishable_key_key] 	= $stripe_publishable_key;
		$options['mode_stripe'] 				= $mode_stripe;

		if (isset($options['pub_key_live'])) { unset($options['pub_key_live']); }
		if (isset($options['sec_key_live'])) { unset($options['sec_key_live']); }
		if (isset($options['pub_key_test'])) { unset($options['pub_key_test']); }
		if (isset($options['sec_key_test'])) { unset($options['sec_key_test']); }
		if (isset($options['webhook_data_live'])) { unset($options['webhook_data_live']); }
		if (isset($options['webhook_data_test'])) { unset($options['webhook_data_test']); }
		if (isset($options['stripe_connect_notice_dismissed'])) { unset($options['stripe_connect_notice_dismissed']); }

		update_option('cf7pp_options', $options);
	} else {
		$cf7pp_sandbox = $mode_stripe == 1 ? 1 : 0;
		update_post_meta($form_id, '_cf7pp_sandbox', $cf7pp_sandbox);
		update_post_meta($form_id, '_cf7pp_stripe_account_id', $account_id);
		update_post_meta($form_id, '_cf7pp_stripe_token', $token);

		delete_post_meta($form_id, '_cf7pp_stripe_pub_key');
		delete_post_meta($form_id, '_cf7pp_stripe_sec_key');
	}

	$return_url = cf7pp_stripe_connect_tab_url($form_id);

	/**
	 * Filters the URL users are returned to after Stripe connect completed
	 *
	 * @since 2.8.6
	 *
	 * @param $return_url URL to return to.
	 */
	$return_url = apply_filters('cf7pp_stripe_connect_return_url', $return_url);

	wp_redirect($return_url);
}

add_action('plugins_loaded', 'cf7pp_stripe_disconnected');
function cf7pp_stripe_disconnected() {
	if (empty($_GET['cf7pp_stripe_disconnected']) || intval($_GET['cf7pp_stripe_disconnected']) !== 1 || empty($_GET['mode']) || empty($_GET['account_id']) || !isset($_GET['form_id'])) return;

	if (!current_user_can('manage_options')) {
		return;
	}

	$form_id = intval($_GET['form_id']);

	if (empty($form_id)) {
		$options = get_option('cf7pp_options');
		$acct_id_key = $_GET['mode'] == 'live' ? 'acct_id_live' : 'acct_id_test';
		if ($options[$acct_id_key] == $_GET['account_id']) {
			$options[$acct_id_key] = '';
			update_option('cf7pp_options', $options);
		}
	} else {
		update_post_meta($form_id, '_cf7pp_stripe_account_id', '');
		update_post_meta($form_id, '_cf7pp_stripe_token', '');
	}

	$return_url = cf7pp_stripe_connect_tab_url($form_id);

	/**
	 * Filters the URL users are returned to after Stripe disconnect completed
	 *
	 * @since 2.8.6
	 *
	 * @param $return_url URL to return to.
	 */
	$return_url = apply_filters('cf7pp_stripe_disconnect_return_url', $return_url);

	wp_redirect($return_url);
}

