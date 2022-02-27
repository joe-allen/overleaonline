<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

//
///**
// * Create Stripe webhook if not created yet when any redirect happens.
// * @since 2.8
// * @return associative array Plugin settings
// */
//add_action('wpcf7_before_send_mail', 'cf7pp_insert_webhook_data_to_plugin_settings');
//function cf7pp_insert_webhook_data_to_plugin_settings() {
//
//	$options = get_option('cf7pp_options');
//
//	switch ($options['mode_stripe']) {
//		case '1':
//			if (!empty($options['stripe_access_token_test'])) {
//				
//				$webhook_data_test_orig = $options['webhook_data_test']['id'];
//				
//				$options['webhook_data_test'] = cf7pp_maybe_create_stripe_webhook($options['webhook_data_test'], $options['stripe_access_token_test']);				
//				
//				if ($webhook_data_test_orig != $options['webhook_data_test']['id']) {
//					array_merge($options, $options['webhook_data_test']);
//					update_option("cf7pp_options", $options);
//				}
//				break;
//			}
//			
//		case '2':
//			if (!empty($options['stripe_access_token_live'])) {
//				
//				$webhook_data_live_orig = $options['webhook_data_live']['id'];
//				
//				$options['webhook_data_live'] = cf7pp_maybe_create_stripe_webhook($options['webhook_data_live'], $options['stripe_access_token_live']);
//				
//				if ($webhook_data_live_orig != $options['webhook_data_live']['id']) {
//					array_merge($options, $options['webhook_data_live']);
//					update_option("cf7pp_options", $options);
//				}
//				break;
//			}
//	}
//	
//}
//
///**
// * Check $webhook_data to see if we need to create a new webhook and remove old
// * @since 2.8
// * @return string Stripe webhook id
// */
//function cf7pp_maybe_create_stripe_webhook($webhook_data, $sk) {
//	
//	try {
//	    $stripe = new \Stripe\StripeClient($sk);
//	} catch (Exception $e) {
//		error_log($e->getMessage());
//		return $webhook_data;
//	}
//
//	$result = '';
//
//	$url = cf7pp_get_stripe_webhook_url();
//	
//	$events = array(
//		'checkout.session.completed'
//	);
//	
//	// check if webhook exists
//	if (!empty($webhook_data['id']) && !empty($webhook_data['secret'])) {
//		try {
//			$webhook = $stripe->webhookEndpoints->retrieve($webhook_data['id']);
//			if (!empty($webhook->url) && $webhook->url == $url) {
//				if (is_array($webhook->enabled_events) && $webhook->enabled_events == $events) {
//					$result = $webhook_data;
//				} else {					
//					$stripe->webhookEndpoints->delete($webhook_data['id']);
//				}
//			}
//		} catch (Exception $e) {
//			error_log($e->getMessage());
//		}
//	}
//	
//	$options = get_option('cf7pp_options');
//
//	if (empty($result)) {
//		// create webhook
//		try {			
//			$webhook = $stripe->webhookEndpoints->create([
//				'url'				=> $url,
//				'enabled_events'	=> $events,
//				'connect'			=> false,
//				'stripe_account'	=> $options['acct_id_test'],
//			]);
//			
//			$result = array(
//				'id'		=> $webhook->id,
//				'secret'	=> $webhook->secret
//			);
//		} catch (Exception $e) {
//			echo $e;
//			error_log($e->getMessage());
//		}
//	}
//
//	return $result;
//}

/**
 * Stripe webhook url.
 * @since 2.8
 * @return string or array
 */
function cf7pp_get_stripe_webhook_url($return = 'str') {
	$options = get_option('cf7pp_options');
	$mode_stripe = $options['mode_stripe'] == '1' ? 'test' : 'live';

	$namespace = 'stripewebhooks/v1';
	$route = '/cf7pp_' . $mode_stripe;

	if ($return == 'str') {
		$result = add_query_arg('rest_route', '/' . $namespace . $route, get_site_url());
	} else {
		$result = array(
			'namespace'	=> $namespace,
			'route'		=> $route
		);
	}

	return $result;
}

/**
 * Register Stripe webhook listener.
 * @since 2.8
 */
add_action('rest_api_init', 'cf7pp_stripe_webhook_listener');
function cf7pp_stripe_webhook_listener() {
	$webhook_url = cf7pp_get_stripe_webhook_url('arr');
    register_rest_route($webhook_url['namespace'], $webhook_url['route'], array(
        'methods' 				=> 'POST',
        'callback' 				=> 'cf7pp_stripe_webhook_handler',
        'permission_callback'	=> 'cf7pp_stripe_webhook_auth'
    ));
}

/**
 * Stripe webhook permission callback.
 * @since 2.8
 * @return bool
 */
function cf7pp_stripe_webhook_auth() {
	return true; // security done in the handler
}

/**
 * Stripe webhook handler.
 * @since 2.8
 */
function cf7pp_stripe_webhook_handler() {
	$options = get_option('cf7pp_options');
	$mode_stripe = $options['mode_stripe'] == '1' ? 'test' : 'live';
	$endpoint_secret = $options['webhook_data_' . $mode_stripe]['secret'];

    $payload = @file_get_contents('php://input');
    $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
	$event = null;

    try {
        $event = \Stripe\Webhook::constructEvent(
        	$payload, $sig_header, $endpoint_secret
    	);
    } catch(\UnexpectedValueException $e) {
		// Invalid payload
		http_response_code(400);
		exit();
	} catch(\Stripe\Exception\SignatureVerificationException $e) {
		// Invalid signature
		http_response_code(400);
		exit();
	}

	// Handle the event
	switch ($event->type) {
		case 'checkout.session.completed':
			$payment_id = isset($event->data->object->client_reference_id) ? $event->data->object->client_reference_id : 0;
			$status = $event->data->object->payment_status == 'paid' ? 'completed' : 'failed';
			$transaction_id = $event->data->object->payment_intent;
			
			$payment_id_pieces = explode('|', $payment_id);
			
         	cf7pp_complete_payment($payment_id_pieces[0], $status, $transaction_id);
			
			// payment is successful - clean up and send cf7 email
			
			// delete tags id here because form has been set to redirect
			if ($payment_id_pieces[3] == '1') {
				wp_delete_post($payment_id_pieces[1],true);
			}
			
			$content = get_post($payment_id_pieces[2]);
			
			if (!empty($content)) {
				
				// content
				$array = $content->post_content;
				$string_back = unserialize(base64_decode($array));
				$values = array_values ($string_back);
				
				// hook - pre send
				$values = apply_filters('cf7pp_payment_successful_pre_send_email_filter_stripe', $values);
				
				
				// file attachments
				$upload_dir = wp_upload_dir();
				$basedir = $upload_dir['basedir'];
				$uploaddir = "/cf7pp_uploads";
				
				// mail 1 attachments
				if (isset($values[0]['attachments'])) {
					$mail1_attachments = $values[0]['attachments'];
					$mail1_attachments = explode("\r\n",$mail1_attachments);
					$mail1_attachments = array_filter($mail1_attachments);
				}
				
				// mail 2 attachments
				if (isset($values[0]['attachments2'])) {
					$mail2_attachments = $values[0]['attachments2'];
					$mail2_attachments = explode("\r\n",$mail2_attachments);
					$mail2_attachments = array_filter($mail2_attachments);
				}
				
				
				// files will be auto deleted after 1 day by /includes/admin/files.php
				
				
				
				// mail 1
				$mail1 = $values[0];
				$mail1 = str_replace("[txn_id]", $transaction_id, $mail1);
				$result = WPCF7_Mail::send($mail1,'mail');
				
				
				
				// mail 2
				if (isset($values[1])) {
					$mail2 = $values[1];
					$mail2 = str_replace("[txn_id]", $transaction_id, $mail2);
					$result = WPCF7_Mail::send($mail2,'mail');
				}
				
				
				// hook - pre delete cf7pp post
				do_action('cf7pp_payment_successful_pre_post_delete', $payment_id_pieces[2], $transaction_id);
				
				wp_delete_post($payment_id_pieces[2],true);
				
				// hook - payment successful
				do_action('cf7pp_payment_successful', $payment_id_pieces[2], $transaction_id);
				
			}
			
            break;

		default:
			http_response_code(400);
			exit();
	}

	http_response_code(200);
}

/**
 * Stripe Connect webhook url.
 * @since 2.8.6
 * @return string or array
 */
function cf7pp_get_stripe_connect_webhook_url($return = 'str') {
    $namespace = 'stripewebhooks/v1';
    $route = '/cf7pp_notice';

    if ($return == 'str') {
        $result = add_query_arg('rest_route', '/' . $namespace . $route, get_site_url());
    } else {
        $result = array(
            'namespace'    => $namespace,
            'route'        => $route
        );
    }

    return $result;
}

/**
 * Register Stripe Connect webhook listener.
 * @since 2.8.6
 */
add_action('rest_api_init', 'cf7pp_stripe_connect_webhook_listener');
function cf7pp_stripe_connect_webhook_listener() {
    $webhook_url = cf7pp_get_stripe_connect_webhook_url('arr');
    register_rest_route($webhook_url['namespace'], $webhook_url['route'], array(
        'methods'                 => 'POST',
        'callback'                 => 'cf7pp_stripe_connect_webhook_handler',
        'permission_callback'    => 'cf7pp_stripe_connect_webhook_auth'
    ));
}

/**
 * Stripe Connect webhook permission callback.
 * @since 2.8.6
 * @return bool
 */
function cf7pp_stripe_connect_webhook_auth() {
    if (!isset($_POST['payment_id']) || !isset($_POST['status']) || !isset($_POST['transaction_id']) || !isset($_POST['mode']) || !isset($_POST['token'])) return false;

    $form_id = intval($_POST['form_id']);

    if (empty($form_id)) {
	    $options = get_option('cf7pp_options');

	    if ($_POST['mode'] == 'live') {
	        $token = isset($options['stripe_connect_token_live']) ? $options['stripe_connect_token_live'] : '';
	    } else {
	        $token = isset($options['stripe_connect_token_test']) ? $options['stripe_connect_token_test'] : '';
	    }
	} else {
		$token = get_post_meta($form_id, '_cf7pp_stripe_token', true);
	}

    return !empty($_POST['token']) && $_POST['token'] == $token;
}

/**
 * Stripe Connect webhook handler.
 * @since 2.8.6
 */
function cf7pp_stripe_connect_webhook_handler() {
    $payment_id = isset($_POST['payment_id']) ? $_POST['payment_id'] : '';
	$status = $_POST['status'];
	$transaction_id = $_POST['transaction_id'];
	
	$payment_id_pieces = explode('|', $payment_id);
	
 	$result = cf7pp_complete_payment($payment_id_pieces[0], $status, $transaction_id);
	
	// payment is successful - clean up and send cf7 email
	
	// delete tags id here because form has been set to redirect
	if ($payment_id_pieces[3] == '1') {
		wp_delete_post($payment_id_pieces[1],true);
	}
	
	$content = get_post($payment_id_pieces[2]);
	
	if (!empty($content)) {
		
		// content
		$array = $content->post_content;
		$string_back = unserialize(base64_decode($array));
		$values = array_values ($string_back);
		
		// hook - pre send
		$values = apply_filters('cf7pp_payment_successful_pre_send_email_filter_stripe', $values);
		
		
		// file attachments
		$upload_dir = wp_upload_dir();
		$basedir = $upload_dir['basedir'];
		$uploaddir = "/cf7pp_uploads";
		
		// mail 1 attachments
		if (isset($values[0]['attachments'])) {
			$mail1_attachments = $values[0]['attachments'];
			$mail1_attachments = explode("\r\n",$mail1_attachments);
			$mail1_attachments = array_filter($mail1_attachments);
		}
		
		// mail 2 attachments
		if (isset($values[0]['attachments2'])) {
			$mail2_attachments = $values[0]['attachments2'];
			$mail2_attachments = explode("\r\n",$mail2_attachments);
			$mail2_attachments = array_filter($mail2_attachments);
		}
		
		
		// files will be auto deleted after 1 day by /includes/admin/files.php
		
		
		
		// mail 1
		$mail1 = $values[0];
		$mail1 = str_replace("[txn_id]", $transaction_id, $mail1);
		$mail1 = str_replace("[order_id]", $payment_id_pieces[0], $mail1);
		$result = WPCF7_Mail::send($mail1,'mail');
		
		
		
		// mail 2
		if (isset($values[1])) {
			$mail2 = $values[1];
			$mail2 = str_replace("[txn_id]", $transaction_id, $mail2);
			$mail2 = str_replace("[order_id]", $payment_id_pieces[0], $mail2);
			$result = WPCF7_Mail::send($mail2,'mail');
			$result = WPCF7_Mail::send($mail2,'mail');
		}
		
		
		// hook - pre delete cf7pp post
		do_action('cf7pp_payment_successful_pre_post_delete', $payment_id_pieces[2], $transaction_id);
		
		wp_delete_post($payment_id_pieces[2],true);
		
		// hook - payment successful
		do_action('cf7pp_payment_successful', $payment_id_pieces[2], $transaction_id);
	}

    wp_send_json(array(
        'result'    => $result ? 'success' : 'fail'
    ));
}
