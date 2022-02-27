<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly


/**
 * Used for testing to make sure the IPN can listen to URL calls.
 * @since 2.8
 * @return string
 */
add_action('template_redirect','cf7pp_ipn_test');
function cf7pp_ipn_test() {

	if (isset($_REQUEST['cf7pp_test'])) {
		echo "Contact Form 7 - PayPal Add-on Pro - Test Successful";
		exit;
	}
}


/**
 * PayPal notify url.
 * @since 2.8
 * @return string or array
 */
function cf7pp_get_paypal_notify_url($return = 'str') {
	$options = get_option('cf7pp_options');
	$mode_paypal = $options['mode'] == '1' ? 'sandbox' : 'production';

	$namespace = 'paypalipn/v1';
	$route = '/cf7pp_' . $mode_paypal;

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
 * Register PayPal IPN listener.
 * @since 2.8
 */
add_action('rest_api_init', 'cf7pp_paypal_ipn_listener');
function cf7pp_paypal_ipn_listener() {
	$notify_url = cf7pp_get_paypal_notify_url('arr');
    register_rest_route($notify_url['namespace'], $notify_url['route'], array(
        'methods' 				=> 'POST',
        'callback' 				=> 'cf7pp_paypal_ipn_handler',
        'permission_callback'	=> 'cf7pp_paypal_ipn_auth'
    ));
}


/**
 * PayPal IPN permission callback.
 * @since 2.8
 * @return bool
 */
function cf7pp_paypal_ipn_auth() {
	return true; // security done in the handler
}


/**
 * PayPal IPN handler.
 * @since 2.8
 */
function cf7pp_paypal_ipn_handler() {
	$payload = file_get_contents('php://input');
	parse_str($payload, $data);

	if (strtolower($data['payment_status']) == 'completed') {
		$options = get_option('cf7pp_options');
		$paypal_post_url = 'https://www.' . ($options['mode'] == '1' ? 'sandbox' : '') . '.paypal.com/cgi-bin/webscr';
		
		$data['cmd'] = '_notify-validate';
		$args = array(
			'method'           => 'POST',
			'timeout'          => 45,
			'redirection'      => 5,
			'httpversion'      => '1.1',
			'blocking'         => true,
			'headers'          => array(
				'host'         => 'www.paypal.com',
				'connection'   => 'close',
				'content-type' => 'application/x-www-form-urlencoded',
				'post'         => '/cgi-bin/webscr HTTP/1.1',
				
			),
			'sslverify'        => false,
			'body'             => $data
		);
		
		// Get response
		$response = wp_remote_post($paypal_post_url, $args);
		
		$status = is_wp_error($response) || strtolower($response['body']) != 'verified' ? 'failed' : 'completed';
		
		
		http_response_code(200);
		
		if (isset($data['invoice'])) {
			
			cf7pp_complete_payment($data['invoice'], $status, $data['txn_id']);
			
			// Get custom variable ID back from PayPal - this is the ID of the post that we used to temporarily store the mail data
			$post_id = sanitize_text_field($data['custom']);
			
			$content = get_post($post_id);
			
			if (!empty($content)) {
				
				// content
				$array = $content->post_content;
				$string_back = unserialize(base64_decode($array));
				
				if (is_array($string_back)) {
					
					$values = array_values ($string_back);
					
					
					// get paypal transaction id
					$txn_id = $data['txn_id'];
					
					
					// hook - pre send
					do_action('cf7pp_payment_successful_pre_send_email', $post_id);
					$values = apply_filters('cf7pp_payment_successful_pre_send_email_filter', $values);
					
					
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
					$mail1 = str_replace("[txn_id]", $txn_id, $mail1);
					$mail1 = str_replace("[order_id]", $data['invoice'], $mail1);
					$result = WPCF7_Mail::send($mail1,'mail');
					
					
					
					// mail 2
					if (isset($values[1])) {
						$mail2 = $values[1];
						$mail2 = str_replace("[txn_id]", $txn_id, $mail2);
						$mail2 = str_replace("[order_id]", $data['invoice'], $mail2);
						$result = WPCF7_Mail::send($mail2,'mail');
					}
					
					
					// hook - pre delete cf7pp post
					do_action('cf7pp_payment_successful_pre_post_delete', $post_id, $txn_id);
					
					
					wp_delete_post($post_id,true);
					
					// hook - payment successful
					do_action('cf7pp_payment_successful', $post_id, $txn_id);
					
				}
				
			}
		}
		
		
	} else {
		
		$status = 'failed';
		
	}

	
}