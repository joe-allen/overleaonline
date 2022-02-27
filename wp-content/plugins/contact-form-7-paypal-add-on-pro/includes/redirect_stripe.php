<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


function cf7pp_stripe_redirect($post_id, $tags_id, $input_id, $return_url, $form_id, $payment_id) {


	do_action('cf7pp_process_stripe',$post_id, $tags_id, $input_id, $return_url, $form_id, $payment_id);
	
	
	global $options;
	
	
	
	// gets tags array
	$content = get_post($tags_id);
	
	// exit if already run
	if (empty($content)) {
		exit;
	}
	
	$array = $content->post_content;
	$tags_back = unserialize(base64_decode($array));
	foreach ($tags_back as $k => $v ) { $tags[$k] = $v; }
	
	// exit if not tags found
	if (!isset($tags) || empty($tags)) {
		exit;
	}
	
	
	
	
	if (empty($options['session'])) {
		$session = '1';
	} else {
		$session = $options['session'];
	}

	if ($session == '1') {
		
		if(isset($_COOKIE['cf7pp_stripe_return'])) {
			$stripe_return 	= sanitize_text_field($_COOKIE['cf7pp_stripe_return']);
		}
		
	} else {
		
		if(isset($_SESSION['cf7pp_stripe_return'])) {
			$stripe_return 	= sanitize_text_field($_SESSION['cf7pp_stripe_return']);
		}
		
	}
	
	
	
	// billing address
	if (isset($options['address']) && $options['address'] == "2") {
		$billing_address_collection = 'required';
	} else {
		$billing_address_collection = null;
	}
	
	
	// email
	if (!empty($tags['stripe_email'])) {
		$email = $tags['stripe_email'];
	}
	
	if (empty($email)) {
		$email = null;
	}
	
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$email = null;
	}
	
	
	
	// return url
	
	$cancel_url = $return_url;
	
	// return url
	if (!empty($stripe_return)) {
		$success_url = $stripe_return;
	} else {
		$success_url = $return_url;
	}
	
	if (filter_var($success_url, FILTER_VALIDATE_URL) === FALSE) {
		echo "Website admin: Success or Return URL is not valid.";
		exit;
	}
	
	if (filter_var($cancel_url, FILTER_VALIDATE_URL) === FALSE) {
		echo "Website admin: Success or Return URL is not valid.";
		exit;
	}
	
	
	// items
	$name = 	get_post_meta($post_id, "_cf7pp_name", true);
	$price = 	get_post_meta($post_id, "_cf7pp_price", true);
	$id = 		get_post_meta($post_id, "_cf7pp_id", true);
	
	if (empty($tags['name'])) 		{ $tags['name'] =  "(No item name)"; }
	if (empty($tags['name2'])) 		{ $tags['name2'] = "(No item name)"; }
	if (empty($tags['name3'])) 		{ $tags['name3'] = "(No item name)"; }
	if (empty($tags['name4'])) 		{ $tags['name4'] = "(No item name)"; }
	if (empty($tags['name5'])) 		{ $tags['name5'] = "(No item name)"; }
	
	
	
	if ((empty($tags['account_id']) || empty($tags['token'])) && (empty($tags['sec_key']) || empty($tags['pub_key']))) {
        echo "Website Admin: Please connect your Stripe account on the settings page (Contact -> PayPal & Stripe Settings -> Stripe)";
		exit;
	}
	




	$i = "1";

	if (!empty($tags['price'])) {
		if ($tags['quantity'] != "0") {
			
			$tags['price'] = 				cf7pp_format_currency($tags['price']);
			
			if ($tags['currency'] != 'JPY') {
				// convert amount to cents
				$amount = $tags['price'] * 100;
			} else {
				$amount = $tags['price'];
				$amount = (int)$amount;
			}
			
			if (!empty($tags['text_menu_a_name'])) { $desc1 = $tags['text_menu_a_name'].': '.$tags['text_menu_a']; }
			if (!empty($tags['text_menu_b_name'])) { $desc2 = ', '. $tags['text_menu_b_name'].': '.$tags['text_menu_b']; }
			if (!empty($tags['id'])) { $id_sku = ' ID: '.$tags['id']; } else { $id_sku = null; }
			
			if (!empty($desc1) && !empty($id_sku)) {
				$description = $desc1.$desc2.', '.$id_sku;
			} elseif (!empty($desc1)) {
				$description = $desc1.$desc2.$id_sku;
			} elseif (!empty($id_sku)) {
				$description = ' '.$id_sku;
			} else {
				$description = ' ';
			}
			
			$line_items[] = [
				'price_data' => [
					'currency' 		=> $tags['currency'],
					'unit_amount' 	=> $amount,
					'product_data' 	=> [
						'name' 			=> $tags['name'],
						'description' 	=> $description,
					],
				],
				'quantity' => $tags['quantity'],
			];
			
			
			
			$i++;
			
		}
	}

	if (!empty($tags['price2'])) {
		if ($tags['quantity2'] != "0") {
			
			$tags['price2'] = 				cf7pp_format_currency($tags['price2']);
			
			if ($tags['currency'] != 'JPY') {
				// convert amount to cents
				$amount2 = $tags['price2'] * 100;
			} else {
				$amount2 = $tags['price2'];
				$amount2 = (int)$amount2;
			}
			
			if (!empty($tags['text_menu_a_name2'])) { $desc1 = $tags['text_menu_a_name2'].': '.$tags['text_menu_a2']; }
			if (!empty($tags['text_menu_b_name2'])) { $desc2 = ', '. $tags['text_menu_b_name2'].': '.$tags['text_menu_b2']; }
			
			if (!empty($desc1)) {
				$description = $desc1.$desc2;
			} else {
				$description = ' ';
			}
			
			$line_items[] = [
				'price_data' => [
					'currency' 		=> $tags['currency'],
					'unit_amount' 	=> $amount2,
					'product_data' 	=> [
						'name' 			=> $tags['name2'],
							'description' 	=> $description,
					],
				],
				'quantity' => $tags['quantity2'],
			];
				
			$i++;
			
		}
	}
	
		if (!empty($tags['price3'])) {
		if ($tags['quantity3'] != "0") {
			
			$tags['price3'] = 				cf7pp_format_currency($tags['price3']);
			
			if ($tags['currency'] != 'JPY') {
				// convert amount to cents
				$amount3 = $tags['price3'] * 100;
			} else {
				$amount3 = $tags['price3'];
				$amount3 = (int)$amount3;
			}
			
			if (!empty($tags['text_menu_a_name3'])) { $desc1 = $tags['text_menu_a_name3'].': '.$tags['text_menu_a3']; }
			if (!empty($tags['text_menu_b_name3'])) { $desc2 = ', '. $tags['text_menu_b_name3'].': '.$tags['text_menu_b3']; }
			
			if (!empty($desc1)) {
				$description = $desc1.$desc2;
			} else {
				$description = ' ';
			}
			
			$line_items[] = [
				'price_data' => [
					'currency' 		=> $tags['currency'],
					'unit_amount' 	=> $amount3,
					'product_data' 	=> [
						'name' 			=> $tags['name3'],
							'description' 	=> $description,
					],
				],
				'quantity' => $tags['quantity3'],
			];
				
			$i++;
			
		}
	}
	
		if (!empty($tags['price4'])) {
		if ($tags['quantity4'] != "0") {
			
			$tags['price4'] = 				cf7pp_format_currency($tags['price4']);
			
			if ($tags['currency'] != 'JPY') {
				// convert amount to cents
				$amount4 = $tags['price4'] * 100;
			} else {
				$amount4 = $tags['price4'];
				$amount4 = (int)$amount4;
			}
			
			if (!empty($tags['text_menu_a_name4'])) { $desc1 = $tags['text_menu_a_name4'].': '.$tags['text_menu_a4']; }
			if (!empty($tags['text_menu_b_name4'])) { $desc2 = ', '. $tags['text_menu_b_name4'].': '.$tags['text_menu_b4']; }
			
			if (!empty($desc1)) {
				$description = $desc1.$desc2;
			} else {
				$description = ' ';
			}
			
			$line_items[] = [
				'price_data' => [
					'currency' 		=> $tags['currency'],
					'unit_amount' 	=> $amount4,
					'product_data' 	=> [
						'name' 			=> $tags['name4'],
							'description' 	=> $description,
					],
				],
				'quantity' => $tags['quantity4'],
			];
				
			$i++;
			
		}
	}
	
		if (!empty($tags['price5'])) {
		if ($tags['quantity5'] != "0") {
			
			$tags['price5'] = 				cf7pp_format_currency($tags['price5']);
			
			if ($tags['currency'] != 'JPY') {
				// convert amount to cents
				$amount = $tags['price5'] * 100;
			} else {
				$amount5 = $tags['price5'];
				$amount5 = (int)$amount5;
			}
			
			if (!empty($tags['text_menu_a_name5'])) { $desc1 = $tags['text_menu_a_name5'].': '.$tags['text_menu_a5']; }
			if (!empty($tags['text_menu_b_name5'])) { $desc2 = ', '. $tags['text_menu_b_name5'].': '.$tags['text_menu_b5']; }
			
			if (!empty($desc1)) {
				$description = $desc1.$desc2;
			} else {
				$description = ' ';
			}
			
			$line_items[] = [
				'price_data' => [
					'currency' 		=> $tags['currency'],
					'unit_amount' 	=> $amount5,
					'product_data' 	=> [
						'name' 			=> $tags['name5'],
							'description' 	=> $description,
					],
				],
				'quantity' => $tags['quantity5'],
			];
				
			$i++;
			
		}
	}
	
	if (empty($amount2)) { $amount2 = null; }
	if (empty($amount3)) { $amount3 = null; }
	if (empty($amount4)) { $amount4 = null; }
	if (empty($amount5)) { $amount5 = null; }
	
	// Stripe does not allow totals of 0.00, so show error if this happens
	if ($amount + $amount2 + $amount3 + $amount4 + $amount5 == 0) {
		echo 'Website Admin: Price cannot be set to 0.00.';
		exit;
	}
	
	
	
	// if shipping fee exists, then add a new line item
	
	if (!empty($tags['shipping'])) {
		
		if (is_array($tags['shipping'])) {
			$tags['shipping'] = $tags['shipping'][0];
		}
		
		if ($tags['currency'] != 'JPY') {
			// convert amount to cents
			$amount = $tags['shipping'] * 100;
		} else {
			$amount = $tags['shipping'];
			$amount = (int)$amount;
		}
		
		$line_items[] = [
			'price_data' => [
				'currency' 		=> $tags['currency'],
				'unit_amount' 	=> $amount,
				'product_data' 	=> [
					'name' 			=> 'Shipping',
				],
			],
			'quantity' => 1,
		];
	}
	
	
	if ($cancel_url != $success_url) {
		$redirect_success = '1';
	} else {
		$redirect_success = '0';
	}
	
	if (!empty($tags['sec_key'])) {
		\Stripe\Stripe::setApiKey($tags['sec_key']);
		
		
		$checkout_session = \Stripe\Checkout\Session::create([
		  'submit_type' 				=> 'pay',
		  'payment_method_types' 		=> ['card'],
		  'customer_email' 				=> $email,
		  'billing_address_collection' 	=> $billing_address_collection,
		  'line_items' 					=> $line_items,
		  'mode' 						=> 'payment',
		  'success_url' 				=> add_query_arg(array(
			'cf7pp_stripe_success'	=> true,
			'cf7pp_fid'				=> $form_id,
			'cf7pp_id'				=> '{CHECKOUT_SESSION_ID}',
			'cf7pp_tags_id'			=> $tags_id,
			'cf7pp_success'			=> $success_url,
			'cf7pp_redirect'		=> $redirect_success
		  ), $cancel_url),
		  'cancel_url' 					=> $cancel_url,
		  'client_reference_id'			=> $payment_id.'|'.$tags_id.'|'.$input_id.'|'.$redirect_success,
		]);
		
		if (empty($checkout_session->id)) {
			echo "An unexpected error occurred. Please try again.";
			exit;
		}
	} else {
		
		$success_url = add_query_arg(
			array(
				'cf7pp_stripe_success'	=> true,
				'cf7pp_fid'				=> $form_id,
				'cf7pp_id'				=> '{CHECKOUT_SESSION_ID}',
				'cf7pp_tags_id'			=> $tags_id,
				'cf7pp_success'			=> $success_url,
				'cf7pp_redirect'		=> $redirect_success
		  	),
			$cancel_url
		);
		
		$stripe_connect_url = CF7PP_STRIPE_CONNECT_ENDPOINT . '?' . http_build_query(
			array(
				'action'						=> 'checkoutSession',
				'mode'							=> $tags['stripe_state'] == 'live' ? 'live' : 'sandbox',
				'customer_email'				=> $email,
				'billing_address_collection'	=> $billing_address_collection,
				'line_items'					=> $line_items,
				'success_url'					=> $success_url,
				'cancel_url'					=> $cancel_url,
				'notice_url'					=> cf7pp_get_stripe_connect_webhook_url(),
				'client_reference_id'			=> $payment_id.'|'.$tags_id.'|'.$input_id.'|'.$redirect_success,
		  		'account_id'					=> $tags['account_id'],
		  		'token'							=> $tags['token'],
		  		'pro'							=> 1,
		  		'form_id'						=> $tags['stripe_account_overridden']
			)
		);

		$opts = array(
			'http' => array(
				'header' => "Referer: " . site_url($_SERVER['REQUEST_URI'])
			)
		);
		$context = stream_context_create($opts);
		
		// changed to wp_remote_get instead of file_get_contents since many hosting companies have this blocked
		
		$checkout_session = wp_remote_post($stripe_connect_url);
		
		$checkout_session = json_decode($checkout_session['body']);
		
		if (empty($checkout_session->session_id)) {
			echo "An unexpected error occurred. Please try again.";
			exit;
		}
	}
	
	?>
	<!DOCTYPE html>
	<html>
		<head>
			<script src="https://js.stripe.com/v3/"></script>
		</head>
		<body>
			<script type="text/javascript">
				<?php if (!empty($tags['pub_key'])) { ?>
				var stripe = Stripe('<?php echo $tags['pub_key']; ?>');			
				window.onload = function() {
					stripe.redirectToCheckout({sessionId: '<?php echo $checkout_session->id ?>'});
				};
				<?php } else { ?>
				var stripe = Stripe('<?php echo $checkout_session->stripe_key; ?>', {stripeAccount: '<?php echo $tags['account_id']; ?>'});			
				window.onload = function() {
					stripe.redirectToCheckout({sessionId: '<?php echo $checkout_session->session_id ?>'});
				};
			<?php } ?>
			</script>
		</body>
	</html>
	<?php
}
	
?>