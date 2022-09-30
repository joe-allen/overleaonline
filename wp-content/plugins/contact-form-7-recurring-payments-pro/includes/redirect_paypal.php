<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


// paypal redirect
function cf7pps_cf7pp_redirect_paypal($tags, $post_id, $input_id, $payment_id) {
	

	// check if recurring setting is enabled
	$recurring_static = 					get_post_meta($post_id, "_cf7pp_recurring_static", true);
	$recurring_dynamic = 					get_post_meta($post_id, "_cf7pp_recurring_dynamic", true);
	
	
	if ($recurring_static == "1" || $recurring_dynamic == "1") {
		
		// static
		$recurring_static_cycle_p3 = 			get_post_meta($post_id, "_cf7pp_recurring_static_cycle_p3", true);
		$recurring_static_cycle_t3 = 			get_post_meta($post_id, "_cf7pp_recurring_static_cycle_t3", true);
		$recurring_static_cycle_srt = 			get_post_meta($post_id, "_cf7pp_recurring_static_cycle_srt", true);
		
		
		// recurring
		$recurring_dynamic_values = 			explode('|',$tags['price_orig'][0]);
		
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
		
		if (!isset($recurring_dynamic_values[3])) {
			$recurring_dynamic_cycle_srt = '0';
		} else {
			$recurring_dynamic_cycle_srt = 		$recurring_dynamic_values[3];
		}
		
		if ($recurring_dynamic == "1") {
			
			$recurring_cycle_p3 	= $recurring_dynamic_cycle_p3;
			$recurring_cycle_t3 	= $recurring_dynamic_cycle_t3;
			$recurring_cycle_srt 	= $recurring_dynamic_cycle_srt;
			
		} else {
			
			$recurring_cycle_p3 	= $recurring_static_cycle_p3;
			$recurring_cycle_t3 	= $recurring_static_cycle_t3;
			$recurring_cycle_srt 	= $recurring_static_cycle_srt;
			
		}
		
		
		// use normal billing instead of recurring
		if ($recurring_cycle_srt == '1') {
			goto non_recurring;
		}
		
		// convert t3 format from word to letter
		if ($recurring_cycle_t3 == 'day' || $recurring_cycle_t3 == 'D') {
			$recurring_cycle_t3 = 'D';
		} elseif ($recurring_cycle_t3 == 'week' || $recurring_cycle_t3 == 'W') {
			$recurring_cycle_t3 = 'W';
		} elseif ($recurring_cycle_t3 == 'month' || $recurring_cycle_t3 == 'M') {
			$recurring_cycle_t3 = 'M';
		} elseif ($recurring_cycle_t3 == 'year' || $recurring_cycle_t3 == 'Y') {
			$recurring_cycle_t3 = 'Y';
		} else {
			$recurring_cycle_t3 = 'M';
		}
		
		
		
		// check if description / name value contain pipes, if so, only use first part
		$name = 				explode('|',$tags['name']);
		
		if (is_array($name)) {
			$tags['name'] = $name[0];
		}	
		
		
		
		
		
		$array = array(
			'cmd'				=> '_xclick-subscriptions',
			'business'			=> $tags['account'],
			'currency_code'		=> $tags['currency'],
			'charset'			=> get_bloginfo('charset'),
			//'rm'				=> '1', 						// return method for return url, use 1 for GET
			'return'			=> $tags['returnvalue'],
			'cancel_return'		=> $tags['cancelvalue'],
			'cbt'				=> get_bloginfo('name'),		// Sets the text for the 'Return to Merchant' link on the PayPal confirmation page.
			'bn'				=> 'WPPlugin_SP',
			'lc'				=> $tags['language'],
			'country'			=> $tags['language'],
			'item_number'		=> $tags['id'],
			//'upload'			=> '1',
			//'no_shipping'		=> $tags['address'],
			//'shipping_1' 		=> $tags['shipping'],
			'no_note' 			=> '1',
			//'tax' 			=> $tags['tax'],
			//'tax_rate' 		=> $tags['tax_rate'],
			//'landing_page' 	=> $tags['landingpagevalue'],
			//'paymentaction' 	=> $tags['paymentaction'],
			'notify_url'		=> cf7pp_get_paypal_notify_url(),
			'invoice'			=> $payment_id,
		);
		
		
		// items
		if (empty($tags['name'])) 		{ $tags['name'] =  "(No item name)"; }

		if (!empty($tags['price'])) {
			if ($tags['quantity'] != "0") {
				
				$tags['price'] = 			cf7pp_format_currency($tags['price']);
				$array['a3'] = 				$tags['price'];
				$array['quantity'] = 		$tags['quantity'];
				$array['item_name'] = 		$tags['name'];
				$array['on0'] = 			$tags['text_menu_a_name'];
				$array['os0'] = 			$tags['text_menu_a'];
				$array['on1'] = 			$tags['text_menu_b_name'];
				$array['os1'] = 			$tags['text_menu_b'];
				$array['p3'] = 				$recurring_cycle_p3;
				$array['t3'] = 				$recurring_cycle_t3;
				
				if ($recurring_cycle_srt == '0') {
					$array['src'] = 			'1';
				}
				
				if ($recurring_cycle_srt > '0') {
					$array['srt'] = 			$recurring_cycle_srt;
				}
				
			}
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
	
	// use normal billing instead of recurring
	non_recurring:
	
	
	
}
add_action('cf7pp_redirect_paypal','cf7pps_cf7pp_redirect_paypal',10,4);