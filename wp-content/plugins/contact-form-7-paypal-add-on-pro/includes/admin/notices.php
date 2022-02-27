<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * Show admin notice.
 * @since 2.8
 * @return string or array
 */
add_action('admin_notices', 'cf7pp_admin_earnings_notice');
function cf7pp_admin_earnings_notice(){

	$cf7pp_show_earnings_notice = get_option('cf7pp_show_earnings_notice');
	if ( $cf7pp_show_earnings_notice == '-1' || (time() < $cf7pp_show_earnings_notice + DAY_IN_SECONDS * 14) ) return;

	$msg = '';

	$earnings = cf7pp_get_earnings_amount();
	$earnings = round($earnings, 0); 
	
	if ( $earnings <= 50 ) {
		if ( cf7pp_get_instalation_timestamp() < (time() - DAY_IN_SECONDS * 14) )  {
			$msg = __('You\'ve been using Contact Form 7 - PayPal & Stripe for a while now.', 'contact-form-7');
		}
	} else {
		$msg = sprintf(__('You\'ve made over $%s in earnings using Contact Form 7 - PayPal & Stripe.', 'contact-form-7'), $earnings);
	}

	if (empty($msg)) return;

	printf(
		'<div class="notice notice-success">
			<p><strong>%s</strong> %s</p>
			<p>%s</p>
			<p>%s</p>
			<p>
				<a class="button button-primary" href="https://wordpress.org/support/plugin/contact-form-7-paypal-add-on/reviews/?filter=5#new-post" target="_blank">%s</a>
				<a class="button button-secondary" href="%s">%s</a>
				<a class="button button-secondary" href="%s">%s</a>
			</p>
		</div>',
		__('Great job!', 'contact-form-7'),
		$msg,
		__('If you have a moment, please help us spread the word by leaving a 5-star review on WordPress.', 'contact-form-7'),
		__('- Thanks, Scott Paterson', 'contact-form-7'),
		__('Leave a review', 'contact-form-7'),
		add_query_arg('cf7pp_show_earnings_notice', 'later'),
		__('Maybe later', 'contact-form-7'),
		add_query_arg('cf7pp_show_earnings_notice', 'newer'),
		__('I already did', 'contact-form-7')
	);
}

/**
 * Handle "Maybe later" and "I already did" buttons.
 * @since 2.8
 */
add_action('init', 'cf7pp_show_earnings_notice');
function cf7pp_show_earnings_notice() {
	if ( !isset($_GET['cf7pp_show_earnings_notice']) ) return;

	switch ($_GET['cf7pp_show_earnings_notice']) {
		case 'later':
			update_option('cf7pp_show_earnings_notice', time());
			break;

		case 'newer':
			update_option('cf7pp_show_earnings_notice', '-1');
			break;
	}

	wp_redirect(remove_query_arg('cf7pp_show_earnings_notice'));
	die();
}


/**
 * Show admin notice for Stripe Connect.
 * @since 2.8.6
 */
add_action('admin_notices', 'cf7pp_admin_stripe_connect_notice');
function cf7pp_admin_stripe_connect_notice() {
	$options = get_option('cf7pp_options');
	$mode = $options['mode_stripe'] == "2" ? 'live' : 'sandbox';
	$acct_id_key = $mode == 'live' ? 'acct_id_live' : 'acct_id_test';

	if (!empty($options[$acct_id_key]) || !empty($options['stripe_connect_notice_dismissed'])) return;

	$dismiss_url = add_query_arg('cf7pp_admin_stripe_connect_notice_dismiss', 1, admin_url());

	printf(
		'<div class="notice notice-info is-dismissible cf7pp-stripe-connect-notice" data-dismiss-url="%s">
			<p>%s</p>
			<p><a href="%s" class="stripe-connect-btn"><span>Connect with Stripe</span></a></p>
		</div>',
		$dismiss_url,
		__('<b>Important</b> - \'Contact Form 7 - PayPal & Stripe Add-on Pro\' now uses Stripe Connect.
		Stripe Connect improves security and allows for easier setup. <br /><br />If you use Stripe, please use Stripe Connect.
		It should only take a few moments of your time to setup. Have questions: see the <a target="_blank" href="https://wpplugin.org/documentation/stripe-connect/">documentation</a>.', 'contact-form-7'),
		cf7pp_stripe_connect_url()
	);
}

/**
 * Dismiss admin notice for Stripe Connect.
 * @since 2.8.6
 */
add_action('admin_init', 'cf7pp_admin_stripe_connect_notice_dismiss');
function cf7pp_admin_stripe_connect_notice_dismiss() {
	$dismiss_option = filter_input(INPUT_GET, 'cf7pp_admin_stripe_connect_notice_dismiss', FILTER_SANITIZE_NUMBER_INT);
	if (!empty($dismiss_option)) {
		$options = get_option('cf7pp_options');
		$options['stripe_connect_notice_dismissed'] = 1;
		update_option('cf7pp_options', $options);
		exit;
	}
}

/**
 * Stripe Connect error notice.
 * @since 2.8.6
 */
add_action('admin_notices', 'cf7pp_admin_stripe_connect_error_notice');
function cf7pp_admin_stripe_connect_error_notice() {
	if (empty($_GET['cf7pp_error']) || $_GET['cf7pp_error'] != 'stripe-connect-handler') return;

	printf(
		'<div class="notice notice-error is-dismissible">
			<p>%s</p>
		</div>',
		__('An error occurred while interacting with our Stripe Connect interface. Please notify the author of the plugin.', 'contact-form-7')
	);
}