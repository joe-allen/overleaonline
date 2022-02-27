<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


function cf7pp_paypal_redirect($post_id, $tags_id, $input_id, $payment_id) {

	// get tags_id which is the post id that holds the converated tag values, delete this post when done
	
	$content = get_post($tags_id);
	
	// exit if already run
	if (empty($content)) {
		exit;
	}
	
	$array = $content->post_content;
	$tags_back = unserialize(base64_decode($array));
	foreach ($tags_back as $k => $v ) { $tags[$k] = $v; }
	wp_delete_post($tags_id,true);
	
	// exit if not tags found
	if (!isset($tags) || empty($tags)) {
		exit;
	}
	
	// address fix
	if (empty($tags['address'])) { $tags['address'] = "0"; }
	

	// get variables

	$name = 	get_post_meta($post_id, "_cf7pp_name", true);
	$price = 	get_post_meta($post_id, "_cf7pp_price", true);
	$id = 		get_post_meta($post_id, "_cf7pp_id", true);
	
	
	
	
	
	
	do_action('cf7pp_redirect_paypal',$tags, $post_id, $input_id, $payment_id);
	
	
	
	


	$array = array(
		'business'			=> $tags['account'],
		'currency_code'		=> $tags['currency'],
		'charset'			=> get_bloginfo('charset'),
		'rm'				=> '2', 						// return method for return url, use 2 for POST, all payment variables are included.
		'return'			=> $tags['returnvalue'],
		'cancel_return'		=> $tags['cancelvalue'],
		'cbt'				=> get_bloginfo('name'),
		'bn'				=> 'WPPlugin_SP',
		'lc'				=> $tags['language'],
		'country'			=> $tags['language'],
		'item_number'		=> $tags['id'],
		'cmd'				=> '_cart',
		'upload'			=> '1',
		'no_shipping'		=> $tags['address'],
		'shipping_1' 		=> $tags['shipping'],
		'no_note' 			=> $tags['notevalue'],
		'tax' 				=> $tags['tax'],
		'tax_rate' 			=> $tags['tax_rate'],
		'landing_page' 		=> $tags['landingpagevalue'],
		'paymentaction' 	=> $tags['paymentaction'],
		'notify_url'		=> cf7pp_get_paypal_notify_url(),
		'invoice'			=> $payment_id,
	);
	
	
	
	
	
	
	// items
	if (empty($tags['name'])) 		{ $tags['name'] =  "(No item name)"; }
	if (empty($tags['name2'])) 		{ $tags['name2'] = "(No item name)"; }
	if (empty($tags['name3'])) 		{ $tags['name3'] = "(No item name)"; }
	if (empty($tags['name4'])) 		{ $tags['name4'] = "(No item name)"; }
	if (empty($tags['name5'])) 		{ $tags['name5'] = "(No item name)"; }
	
	
	$i = "1";	
	$total_price = 0;

	if (!empty($tags['price'])) {
		if ($tags['quantity'] != "0") {
			
			$tags['price'] = 				cf7pp_format_currency($tags['price']);
			$array['amount_'.$i] = 			$tags['price'];
			$array['quantity_'.$i] = 		$tags['quantity'];
			$array['item_name_'.$i] = 		$tags['name'];
			$array['on0_'.$i] = 			$tags['text_menu_a_name'];
			$array['os0_'.$i] = 			$tags['text_menu_a'];
			$array['on1_'.$i] = 			$tags['text_menu_b_name'];
			$array['os1_'.$i] = 			$tags['text_menu_b'];
			$i++;
			$total_price += $tags['price'];
		}
	}

	if (!empty($tags['price2'])) {
		if ($tags['quantity2'] != "0") {			
			
			$tags['price2'] = 				cf7pp_format_currency($tags['price2']);
			$array['amount_'.$i] = 			$tags['price2'];
			$array['quantity_'.$i] = 		$tags['quantity2'];
			$array['item_name_'.$i] = 		$tags['name2'];
			$array['on0_'.$i] = 			$tags['text_menu_a_name2'];
			$array['os0_'.$i] = 			$tags['text_menu_a2'];
			$array['on1_'.$i] = 			$tags['text_menu_b_name2'];
			$array['os1_'.$i] = 			$tags['text_menu_b2'];
			$i++;
			$total_price += $tags['price2'];
		}
	}

	if (!empty($tags['price3'])) {
		if ($tags['quantity3'] != "0") {
			
			$tags['price3'] = 				cf7pp_format_currency($tags['price3']);
			$array['amount_'.$i] = 			$tags['price3'];
			$array['quantity_'.$i] = 		$tags['quantity3'];
			$array['item_name_'.$i] = 		$tags['name3'];
			$array['on0_'.$i] = 			$tags['text_menu_a_name3'];
			$array['os0_'.$i] = 			$tags['text_menu_a3'];
			$array['on1_'.$i] = 			$tags['text_menu_b_name3'];
			$array['os1_'.$i] = 			$tags['text_menu_b3'];
			$i++;
			$total_price += $tags['price3'];
		}
	}

	if (!empty($tags['price4'])) {
		if ($tags['quantity4'] != "0") {
			
			$tags['price4'] = 				cf7pp_format_currency($tags['price4']);
			$array['amount_'.$i] = 			$tags['price4'];
			$array['quantity_'.$i] = 		$tags['quantity4'];
			$array['item_name_'.$i] = 		$tags['name4'];
			$array['on0_'.$i] = 			$tags['text_menu_a_name4'];
			$array['os0_'.$i] = 			$tags['text_menu_a4'];
			$array['on1_'.$i] = 			$tags['text_menu_b_name4'];
			$array['os1_'.$i] = 			$tags['text_menu_b4'];
			$i++;
			$total_price += $tags['price4'];
		}
	}

	if (!empty($tags['price5'])) {
		if ($tags['quantity5'] != "0") {
			
			$tags['price5'] = 				cf7pp_format_currency($tags['price5']);
			$array['amount_'.$i] = 			$tags['price5'];
			$array['quantity_'.$i] = 		$tags['quantity5'];
			$array['item_name_'.$i] = 		$tags['name5'];
			$array['on0_'.$i] = 			$tags['text_menu_a_name5'];
			$array['os0_'.$i] = 			$tags['text_menu_a5'];
			$array['on1_'.$i] = 			$tags['text_menu_b_name5'];
			$array['os1_'.$i] = 			$tags['text_menu_b5'];
			$total_price += $tags['price5'];
		}
	}
	
	
	if ($total_price == "0") {
		echo 'Website Admin: Price cannot be set to 0.00.';
		exit;
	}
	
	
	// customer input values
	
	if (!empty($tags['address1'])) {
		$array['address1'] = $tags['address1'];
	}

	if (!empty($tags['address2'])) {
		$array['address2'] = $tags['address2'];
	}

	if (!empty($tags['city'])) {
		$array['city'] = $tags['city'];
	}

	if (!empty($tags['state'])) {
		$array['state'] = $tags['state'];
	}

	if (!empty($tags['country'])) {
		$array['country'] = $tags['country'];
	}

	if (!empty($tags['zip'])) {
		$array['zip'] = $tags['zip'];
	}

	if (!empty($tags['email_address'])) {
		$array['email'] = $tags['email_address'];
	}


	if (!empty($tags['phonea'])) {
		$array['night_phone_a'] = $tags['phonea'];
	}

	if (!empty($tags['phoneb'])) {
		$array['night_phone_b'] = $tags['phoneb'];
	}

	if (!empty($tags['phonec'])) {
		$array['night_phone_c'] = $tags['phonec'];
	}

	if (!empty($tags['first_name'])) {
		$array['first_name'] = $tags['first_name'];
	}

	if (!empty($tags['last_name'])) {
		$array['last_name'] = $tags['last_name'];
	}

	
	// notify url
	if  ($tags['email'] == "1") {
		$array['custom'] = 		$input_id;
	}
	
	// generate url with parameters
	$paypal_url = "https://www.".$tags['path'].".com/cgi-bin/webscr?";
	$paypal_url .= http_build_query($array);
	$paypal_url = str_replace( '&amp;', '&', $paypal_url);
	//$paypal_url = htmlentities($paypal_url); // fix for &curren was displayed literally

	// redirect to paypal
	wp_redirect($paypal_url);
	exit;
	
}
	
?>