<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


function cf7pps_cf7pp_process_stripe($post_id, $tags_id, $input_id, $return_url, $form_id, $payment_id) {

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
	
	
	
	if ($tags['stripe_state'] == 'test') {
		$stripe_access_token 	= $options['stripe_access_token_test'];
		$stripe_publishable_key = $options['stripe_publishable_key_test'];
	} else {
		$stripe_access_token 	= $options['stripe_access_token_live'];
		$stripe_publishable_key = $options['stripe_publishable_key_live'];
	}
	
	
	
	
	// billing address
	if ($options['address'] == "2") {
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
	
	
	
	
	
	// get static values
	$recurring_static = 					get_post_meta($post_id, "_cf7pp_recurring_static", true);
	$recurring_static_cycle_p3 = 			get_post_meta($post_id, "_cf7pp_recurring_static_cycle_p3", true);
	$recurring_static_cycle_t3 = 			get_post_meta($post_id, "_cf7pp_recurring_static_cycle_t3", true);
	
	
	
	// get recurring values
	$recurring_dynamic = 					get_post_meta($post_id, "_cf7pp_recurring_dynamic", true);
	
	
	if ($recurring_static != "1" && $recurring_dynamic != "1") {
		
		// non recurring payment
		return;
		
	}
	
	
	
	if (isset($tags['price_orig'][0])) {
		$recurring_dynamic_values = 			explode('|',$tags['price_orig'][0]);
	} else {
		echo 'Website Admin: Price cannot be set to 0.00.';
		exit;
	}
	
	if (!isset($recurring_dynamic_values[1])) {
		$recurring_dynamic_cycle_p3 = '1';
	} else {
		$recurring_dynamic_cycle_p3 = 		$recurring_dynamic_values[1];
	}
	
	if (!isset($recurring_dynamic_values[2])) {
		$recurring_dynamic_cycle_t3 = 'month';
	} else {
		$recurring_dynamic_cycle_t3 = 		strtolower($recurring_dynamic_values[2]);
	}
	
	
	if ($recurring_dynamic == "1") {
		
		$recurring_cycle_p3 	= $recurring_dynamic_cycle_p3;
		$recurring_cycle_t3 	= $recurring_dynamic_cycle_t3;
		
	} else {
		
		$recurring_cycle_p3 	= $recurring_static_cycle_p3;
		$recurring_cycle_t3 	= $recurring_static_cycle_t3;
		
	}
	
	
	if ($recurring_cycle_t3 == 'D' || $recurring_cycle_t3 == 'day') {
		$recurring_cycle_t3 = 'day';
	} elseif ($recurring_cycle_t3 == 'W' || $recurring_cycle_t3 == 'week') {
		$recurring_cycle_t3 = 'week';
	} elseif ($recurring_cycle_t3 == 'M' || $recurring_cycle_t3 == 'month') {
		$recurring_cycle_t3 = 'month';
	} elseif ($recurring_cycle_t3 == 'Y' || $recurring_cycle_t3 == 'year') {
		$recurring_cycle_t3 = 'year';
	} else {
		$recurring_cycle_t3 = 'month';
	}
	
	
	
	
	if ($recurring_cycle_t3 == 'month' && $recurring_cycle_p3 > 12) {
		echo "Website admin: The biling cycle for monthly prices can't be greater than 12.";
		exit;
	}
	
	if ($recurring_cycle_t3 == 'year' && $recurring_cycle_p3 > 1) {
		echo "Website admin: The biling cycle for yearly prices can't be greater than 1.";
		exit;
	}
	
	
	if (empty($stripe_access_token)) {
		echo "Website Admin: Please enter your Stripe API keys on the settings page (Contact -> PayPal & Stripe Settings -> Stripe)";
		exit;
	}
	
	
	// add secret key
	\Stripe\Stripe::setApiKey($stripe_access_token);
	
	
	
	
	

	// build recurring product 1


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
			} else {
				$description = ' '.$id_sku;
			}
			
			
			$name_clean = preg_replace('/\s+/', '', $tags['name']);
			$name_clean = preg_replace('/[^A-Za-z0-9\-]/', '', $name_clean);
			$name_clean = str_replace('-', '', $name_clean);
			
			
			// construct product and price ids
			$product_id = strtolower('product_'.$name_clean.'_'.$amount.'_'.$recurring_cycle_t3.'_'.$recurring_cycle_p3.'_'.$tags['currency']);
			
			
			
			// check to see if product already exists
			try {
				
				// product exists
				$product_id = \Stripe\Product::retrieve($product_id,[]);
				
			} catch(Exception $e) {
				
				// product does not exist - make product
				
				$product = \Stripe\Product::create([
					'id'	=> $product_id,
					'name' 	=> $tags['name'],
				]);
				
				$product_id = $product->id;
				
			}
			
			
			$line_items[] = [
				'price_data' => [
					'product'		=> $product_id,
					'currency' 		=> $tags['currency'],
					'unit_amount' 	=> $amount,
					'recurring'		=> [
						'interval'		 => $recurring_cycle_t3,
						'interval_count' => $recurring_cycle_p3,
					],
				],
				'quantity' => $tags['quantity'],
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
	
	
	
	
	


	// create session
	
	$checkout_session = \Stripe\Checkout\Session::create([
	  'payment_method_types' 		=> ['card'],
	  'customer_email' 				=> $email,
	  'billing_address_collection' 	=> $billing_address_collection,
	  'line_items' 					=> $line_items,
	  'mode' 						=> 'subscription',
	  'success_url' 				=> $cancel_url.'?cf7pp_stripe_success=true&cf7pp_fid='.$form_id.'&cf7pp_id={CHECKOUT_SESSION_ID}&cf7pp_tags_id='.$tags_id.'&cf7pp_success='.$success_url.'&cf7pp_redirect='.$redirect_success,
	  'cancel_url' 					=> $cancel_url,
	  'client_reference_id'			=> $payment_id.'|'.$tags_id.'|'.$input_id.'|'.$redirect_success,
	  'subscription_data'			=> ['metadata' => [
														'Options' 	=> $description,
													],
									   ],
	]);
	
	
	
	// build html page and redirect to hosted checkout
	?>
	<!DOCTYPE html>
	<html>
		<head>
			<script src="https://js.stripe.com/v3/"></script>
		</head>
		<body>
		</body>
			
			<script type="text/javascript">
			// publishable API key
			var stripe = Stripe('<?php echo $stripe_publishable_key; ?>');
			
			var session_id = '<?php echo $checkout_session->id ?>';
			
			window.onload = function() {
				var result = stripe.redirectToCheckout({ sessionId: session_id });
			};
			
			</script>
	</html>
	<?php
	
	wp_die();
	
}
add_action('cf7pp_process_stripe','cf7pps_cf7pp_process_stripe',6,10);

?>