<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


// returns the form id of the forms that have paypal enabled - used for redirect method 1 and method 2
function cf7pp_forms_enabled() {

	// array that will contain which forms paypal is enabled on
	$enabled = array();
	
	$args = array(
		'posts_per_page'   => 999,
		'post_type'        => 'wpcf7_contact_form',
		'post_status'      => 'publish',
	);
	$posts_array = get_posts($args);
	
	
	// loop through them and find out which ones have paypal enabled
	foreach($posts_array as $post) {
		
		$post_id = $post->ID;
		
		// paypal
		$enable = get_post_meta( $post_id, "_cf7pp_enable", true);
		
		if ($enable == "1") {
			$enabled[] = $post_id.'|paypal';
		}
		
		// stripe
		$enable_stripe = get_post_meta( $post_id, "_cf7pp_enable_stripe", true);
		
		if ($enable_stripe == "1") {
			$enabled[] = $post_id.'|stripe';
		}
		
	}

	return json_encode($enabled);

}



// hook into contact form 7 - after send - for redirect method 1 and 2 - for paypal and stripe
add_action('template_redirect','cf7pp_redirect_method');
function cf7pp_redirect_method() {

	global $options;

	if (isset($_GET['cf7pp_paypal_redirect'])) {
		
		// get the id from the cf7pp_before_send_mail function theme redirect
		$post_id 	= sanitize_text_field($_GET['cf7pp_paypal_redirect']);
		
		
		if (isset($_GET['cf7pp_t'])) {
			$tags_id 	= sanitize_text_field($_GET['cf7pp_t']);
		} else {
			$tags_id = '';
		}
		
		
		if (isset($_GET['cf7pp_i'])) {
			$input_id 	= sanitize_text_field($_GET['cf7pp_i']);
		} else {
			$input_id = '';
		}
		
		if (isset($_GET['cf7pp_p'])) {
			$payment_id 	= sanitize_text_field($_GET['cf7pp_p']);
		} else {
			$payment_id = '';
		}
		
		if ($tags_id == '' || $tags_id == 'null' || $tags_id == null) {
			echo "Problem using PHP Sessions. Admin - Go to Contact -> PayPal & Stripe Settings -> Other -> Temporary Storage Method - > Select Cookies";
			exit;
		}
		
		// redirect
		cf7pp_paypal_redirect($post_id, $tags_id, $input_id, $payment_id);
		exit;
		
	}
	
	if (isset($_GET['cf7pp_stripe_redirect'])) {
		
		// get the id from the cf7pp_before_send_mail function theme redirect
		$post_id 	= sanitize_text_field($_GET['cf7pp_stripe_redirect']);
		
		
		if (isset($_GET['cf7pp_t'])) {
			$tags_id 	= sanitize_text_field($_GET['cf7pp_t']);
		} else {
			$tags_id = '';
		}
		
		
		if (isset($_GET['cf7pp_i'])) {
			$input_id 	= sanitize_text_field($_GET['cf7pp_i']);
		} else {
			$input_id = '';
		}
		
		if (isset($_GET['cf7pp_return'])) {
			$return_url 	= sanitize_text_field($_GET['cf7pp_return']);
		} else {
			$return_url = '';
		}
		
		// long contact form 7 form id
		if (isset($_GET['cf7pp_fid'])) {
			$fid 	= sanitize_text_field($_GET['cf7pp_fid']);
		} else {
			$fid = '';
		}
		
		if (isset($_GET['cf7pp_p'])) {
			$payment_id 	= sanitize_text_field($_GET['cf7pp_p']);
		} else {
			$payment_id = '';
		}

		
		if ($tags_id == '' || $tags_id == 'null' || $tags_id == null) {
			echo "Problem using PHP Sessions. Admin - Go to Contact -> PayPal & Stripe Settings -> Other -> Temporary Storage Method - > Select Cookies";
			exit;
		}
		
		// redirect
		cf7pp_stripe_redirect($post_id, $tags_id, $input_id, $return_url, $fid, $payment_id);
		exit;
		
	}
}



// stripe success text
add_action('wp_ajax_cf7pp_get_form_stripe_success', 'cf7pp_get_form_stripe_success_callback');
add_action('wp_ajax_nopriv_cf7pp_get_form_stripe_success', 'cf7pp_get_form_stripe_success_callback');
function cf7pp_get_form_stripe_success_callback() {

	global $options;
	
	$tags_id = 			sanitize_text_field($_POST['cf7pp_tags_id']);
	
	$content = get_post($tags_id);
	
	// exit if already run
	if (empty($content)) {
		echo "Empty";
		exit;
	}
	
	$array = $content->post_content;
	$tags_back = unserialize(base64_decode($array));
	foreach ($tags_back as $k => $v ) { $tags[$k] = $v; }
	
	// exit if not tags found
	if (!isset($tags) || empty($tags)) {
		exit;
	}

	$html_success = "
		".$options['success']."
		<br /><br />
		".$tags['stripe_text']."
	";
	
	$response = array(
		'html' => $html_success,
	);

	echo json_encode($response);
	
	// Form did not redirect, so delete tags id here
	wp_delete_post($tags_id,true);

	wp_die();
}



// hook into contact form 7 - before send for redirect method 1
add_action('wpcf7_before_send_mail', 'cf7pp_before_send_mail');
function cf7pp_before_send_mail() {

	global $current_user;
	global $cf7;
	global $options;

	$wpcf7 = WPCF7_ContactForm::get_current();

	// need to save submission for later and the variables get lost in the cf7 javascript redirect
	$submission_orig = WPCF7_Submission::get_instance();

	if ($submission_orig) {
		// get form post id
		$posted_data 	= $submission_orig->get_posted_data();
		$post_id 		= $wpcf7->id;
		$gateway 		= strtolower(get_post_meta($post_id, "_cf7pp_gateway", true));
		
		
		$enable 		= get_post_meta( $post_id, "_cf7pp_enable", true);
		$enable_stripe 	= get_post_meta( $post_id, "_cf7pp_enable_stripe", true);
		
		
		
		
		
		// stripe return
		
		// global setting
		if (isset($options['stripe_return'])) {
			$stripe_return = 		$options['stripe_return'];
		}

		// form setting
		$stripe_return_form = 			get_post_meta( $post_id, "_cf7pp_stripe_return", true);
		
		if (!empty($stripe_return_form)) {
			$stripe_return = $stripe_return_form;
		}
		
		if (!isset($stripe_return)) { $stripe_return = ""; }
		
		
		
		if ($enable == '1' || $enable_stripe == '1') {
			
			
			
			// begin new code
			
			
			
			
			
			
			
			
			$email = get_post_meta($post_id, "_cf7pp_email", true);
			
			// file upload handling
			
			// get files
			$find = 		"wpcf7_uploads";
			$uploaddir = 	"/cf7pp_uploads";
			$upload_dir = 	wp_upload_dir();
			$basedir = 		$upload_dir['basedir'];
			$array = 		$submission_orig;
			$test = 		serialize($array);
			$length = 		strlen($find);
			$count = 		substr_count($test,$find);
			$files_arr = 	(array) null;
			$files_order = 	(array) null;
			
			function get_string_between($string, $start, $end) {
				$string = " ".$string;
				$ini = strpos($string,$start);
				if ($ini == 0) return "";
				$ini += strlen($start);
				$len = strpos($string,$end,$ini) - $ini;
				return substr($string,$ini,$len);
			}
			
			// finding file item names and order
			for ($i=0; $i<$count; $i++) {
				$result = get_string_between($test,'uploaded_files', ';}');
				$files_order = explode('"',$result);
			}
			
			$files_order = array_filter($files_order);
			function myFilter($string) { return strpos($string, ':') === false;	}
			$files_order = array_filter($files_order, 'myFilter');
			function myFiltera($string) { return strpos($string, '/') === false; }
			$files_order = array_filter($files_order, 'myFiltera');
			$files_order = array_values($files_order);
			
			// finding file paths
			for ($i=0; $i<$count; $i++) {
				$result = $basedir."/".$find.$parsed = get_string_between($test,$find, '"');
				$test = substr($test, strpos($test,$find) + $length);
				$parsed_folder = explode("/",$parsed);
				mkdir($basedir.$uploaddir."/".$parsed_folder['1'], 0777, true);
				copy($result,$basedir.$uploaddir.$parsed);
				array_push($files_arr,$parsed);
			}
			
			
			include_once ('mail_tags.php');
			
			// skip if price is 0, if setting is enabled
			$skip = get_post_meta( $post_id, "_cf7pp_skip", true);
			
			$skip_code = get_post_meta( $post_id, "_cf7pp_skip_code", true);
			
			
			
			// check if skip code contains mutiple form elements
			$skip_code = explode(',',$skip_code);
			$array_skip_result = is_array($skip_code);
			
			$skip_value = '';
			
			if ($array_skip_result) {
				
				foreach ($skip_code as $code) {
					
					// only contains one form element
					if (isset($posted_data[$code])) {
						
						$a_result = is_array($posted_data[$code]);
						
						if ($a_result) {
							$skip_value = (int)$skip_value + (int)$posted_data[$code][0];
						} else {
							$skip_value = (int)$skip_value + (int)$posted_data[$code];
						}
						
					} else {
						$skip_value = '';
					}
					
				}
				
			} else {
				
				// only contains one form element
				if (isset($posted_data[$skip_code])) {
					$skip_value = $posted_data[$skip_code];
				} else {
					$skip_value = '';
				}
				
			}
			
			
			// check if $skip_value is an array - this can happen for radio buttons, but would not happen for dropdowns
			$array_result = is_array($skip_value);
			if ($array_result) {
				$skip_value = $skip_value[0];
			}
			
			// get settings page skip email value
			if (isset($options['skip_email'])) {
				$skip_email = $options['skip_email'];
			} else {
				$skip_email = "1";
			}			
			
			
			// determine if form should redirect or not
			if ($skip == "1" && $tags['price'] == "0" || $skip_value == "0") {
				$no_redirect = "1";
				wp_delete_post($tags_id,true);
			} else {
				$no_redirect = "0";
			}
			
			// if $no_redirect is 1, then skip redirect
			
			
			
			//if ($enable == "1" && $no_redirect != "1") {
			//	if ($options['redirect'] == "1") {
					//$site_url = get_site_url();
					//$path = $site_url.'/?cf7pp_redirect='.$new_post_id.'&orig='.$post_id.'&tags='.$tags_id;
					//$wpcf7->set_properties(array('additional_settings' => "on_sent_ok: \"location.replace('".$path."');\"",));
			//	}
			//}
			
			
			
			
			// do not send the email depending on settings
			if ($email == "1" && $skip_email == "2" && $no_redirect == "1") {
			
			} else if ($email == "1" || $email == "3") {
				// old method used to skip sending mail - this worked in cf7 < 4.9
				$wpcf7->skip_mail = true;
				
				
				// method used to skip redirect in cf7 4.9+
				
				
				// define the wpcf7_skip_mail callback 
				function cf7pp_filter_wpcf7_skip_mail($skip_mail,$contact_form) {
					
					$skip_mail = true;
					
					return $skip_mail;
				}; 
				
				// add the skip mail filter 
				add_filter('wpcf7_skip_mail','cf7pp_filter_wpcf7_skip_mail',10,2);
				
			}
			
			
			// if $no_redirect is 1, then skip redirect
			
			// end new code
			
			
			// set defaults in case uplugin has been updated without savings the settings page
			if (!isset($tags['pub_key'])) {
				$tags['pub_key'] 			= '';
				$tags['stripe_state'] 		= 'live';
			}
			
			
			$gateway_orig = $gateway;
			
			if ($enable == '1') {
				$gateway = 'paypal';
			}
			
			if ($enable_stripe == '1') {
				$gateway = 'stripe';			
			}
			
			if ($enable == '1' && $enable_stripe == '1') {
				$gateway = $posted_data[$gateway_orig][0];
			}
			
			
			if (empty($options['session'])) {
				$session = '1';
			} else {
				$session = $options['session'];
			}
			
			
			$amount_total = $tags['amount_total'];
			
			
			
			
			// save payment
			$mode = ((strtolower($gateway) == 'paypal' && $options['mode'] == 1) || (strtolower($gateway) == 'stripe' && $options['mode_stripe'] == 1)) ? 'sandbox' : 'live';
			$payment_id = cf7pp_insert_payment($gateway, $mode, $amount_total);
			
			
			
			
			// if recurring plugin is enabled
			
			
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			if (is_plugin_active( 'contact-form-7-recurring-payments-pro/subscriptions.php')) {
				
				$recurring_static = 					get_post_meta($post_id, "_cf7pp_recurring_static", true);
				$recurring_dynamic = 					get_post_meta($post_id, "_cf7pp_recurring_dynamic", true);
				
				
				if ($recurring_static == 1 || $recurring_dynamic == 1) {
					
					if (empty($options['every'])) {
						$every = 'every';
					} else {
						$every = $options['every'];
					}
					
					// static
					if ($recurring_static == 1) {
						
						$recurring_static_cycle_p3 		= get_post_meta($post_id, "_cf7pp_recurring_static_cycle_p3", true);
						$recurring_static_cycle_t3 		= get_post_meta($post_id, "_cf7pp_recurring_static_cycle_t3", true);
						
						$recurring_cycle = $recurring_static_cycle_p3;
						
						// singular
						if ($recurring_static_cycle_p3 == '1') {
							
							if ($recurring_static_cycle_t3 == 'D') {
								if (empty($options['day'])) {
									$period = 'day';
								} else {
									$period = $options['day'];
								}
							}
							if ($recurring_static_cycle_t3 == 'W') {
								if (empty($options['week'])) {
									$period = 'week';
								} else {
									$period = $options['week'];
								}
							}
							if ($recurring_static_cycle_t3 == 'M') {
								if (empty($options['month'])) {
									$period = 'month';
								} else {
									$period = $options['month'];
								}
							}
							if ($recurring_static_cycle_t3 == 'Y') {
								if (empty($options['year'])) {
									$period = 'year';
								} else {
									$period = $options['year'];
								}
							}
							
						}
						
						// plural
						if ($recurring_static_cycle_p3 > '1') {
							
							if ($recurring_static_cycle_t3 == 'D') {
								if (empty($options['days'])) {
									$period = 'days';
								} else {
									$period = $options['days'];
								}
							}
							if ($recurring_static_cycle_t3 == 'W') {
								if (empty($options['weeks'])) {
									$period = 'weeks';
								} else {
									$period = $options['weeks'];
								}
							}
							if ($recurring_static_cycle_t3 == 'M') {
								if (empty($options['months'])) {
									$period = 'months';
								} else {
									$period = $options['months'];
								}
							}
							if ($recurring_static_cycle_t3 == 'Y') {
								if (empty($options['years'])) {
									$period = 'years';
								} else {
									$period = $options['years'];
								}
							}
							
						}
					}
					
					
					// dynamic
					if ($recurring_dynamic == 1) {
						
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
						
						
						$recurring_cycle = $recurring_dynamic_cycle_p3;
						
						// singular
						if ($recurring_dynamic_cycle_p3 == '1') {
							
							if ($recurring_dynamic_cycle_t3 == 'day') {
								if (empty($options['day'])) {
									$period = 'day';
								} else {
									$period = $options['day'];
								}
							}
							if ($recurring_dynamic_cycle_t3 == 'week') {
								if (empty($options['week'])) {
									$period = 'week';
								} else {
									$period = $options['week'];
								}
							}
							if ($recurring_dynamic_cycle_t3 == 'month') {
								if (empty($options['month'])) {
									$period = 'month';
								} else {
									$period = $options['month'];
								}
							}
							if ($recurring_dynamic_cycle_t3 == 'year') {
								if (empty($options['year'])) {
									$period = 'year';
								} else {
									$period = $options['year'];
								}
							}
							
						}
						
						// plural
						if ($recurring_dynamic_cycle_p3 > '1') {
							
							if ($recurring_dynamic_cycle_t3 == 'day') {
								if (empty($options['days'])) {
									$period = 'days';
								} else {
									$period = $options['days'];
								}
							}
							if ($recurring_dynamic_cycle_t3 == 'week') {
								if (empty($options['weeks'])) {
									$period = 'weeks';
								} else {
									$period = $options['weeks'];
								}
							}
							if ($recurring_dynamic_cycle_t3 == 'month') {
								if (empty($options['months'])) {
									$period = 'months';
								} else {
									$period = $options['months'];
								}
							}
							if ($recurring_dynamic_cycle_t3 == 'year') {
								if (empty($options['years'])) {
									$period = 'years';
								} else {
									$period = $options['years'];
								}
							}
							
						}
					}
					
					
					if ($recurring_cycle == 1) {
						$amount_total = $amount_total. ' '.$every.' '.$period;
					} else {
						$amount_total = $amount_total. ' '.$every.' '.$recurring_cycle.' '.$period;
					}
					
				}
			}
			
			
			
			
			
			
			
			
			if ($session == '1') {
				
				setcookie('cf7pp_gateway', 					$gateway, time()+3600, COOKIEPATH, COOKIE_DOMAIN, is_ssl(), true);
				setcookie('cf7pp_amount_total', 			$amount_total, time()+3600, COOKIEPATH, COOKIE_DOMAIN, is_ssl(), true);
				setcookie('cf7pp_skip', 					$no_redirect, time()+3600, COOKIEPATH, COOKIE_DOMAIN, is_ssl(), true);
				setcookie('cf7pp_tags_id', 					$tags_id, time()+3600, COOKIEPATH, COOKIE_DOMAIN, is_ssl(), true);
				setcookie('cf7pp_input_id', 				$new_post_id, time()+3600, COOKIEPATH, COOKIE_DOMAIN, is_ssl(), true);
				setcookie('cf7pp_pub_key', 					$tags['pub_key'], time()+3600, COOKIEPATH, COOKIE_DOMAIN, is_ssl(), true);
				setcookie('cf7pp_stripe_state', 			$tags['stripe_state'], time()+3600, COOKIEPATH, COOKIE_DOMAIN, is_ssl(), true);
				setcookie('cf7pp_stripe_return', 			$stripe_return, time()+3600, COOKIEPATH, COOKIE_DOMAIN, is_ssl(), true);
				setcookie('cf7pp_payment_id',				$payment_id, time()+3600, COOKIEPATH, COOKIE_DOMAIN, is_ssl(), true);
				
			} else {
				
				session_start();
				$_SESSION['cf7pp_gateway'] = 				$gateway;
				$_SESSION['cf7pp_skip'] = 					$no_redirect;
				$_SESSION['cf7pp_tags_id'] = 				$tags_id;
				$_SESSION['cf7pp_input_id'] = 				$new_post_id;
				$_SESSION['cf7pp_pub_key'] = 				$tags['pub_key'];
				$_SESSION['cf7pp_amount_total'] = 			$amount_total;
				$_SESSION['cf7pp_stripe_state'] = 			$tags['stripe_state'];
				$_SESSION['cf7pp_stripe_return'] = 			$stripe_return;
				$_SESSION['cf7pp_payment_id'] =				$payment_id;
				session_write_close();
				
			}
			
			do_action('cf7pp_redirect_method_variables',$post_id,$tags);
			
		}
	}
}






// after submit post for js - used for method 1 and 2 for paypal and stripe
add_action('wp_ajax_cf7pp_get_form_post', 'cf7pp_get_form_post_callback');
add_action('wp_ajax_nopriv_cf7pp_get_form_post', 'cf7pp_get_form_post_callback');
function cf7pp_get_form_post_callback() {

	$options = get_option('cf7pp_options');

	do_action('cf7pp_redirect_method_stripe_text_after_pay');
	
	
	if (empty($options['session'])) {
		$session = '1';
	} else {
		$session = $options['session'];
	}

	if ($session == '1') {
		
		if(isset($_COOKIE['cf7pp_gateway'])) {
			$gateway 		= sanitize_text_field($_COOKIE['cf7pp_gateway']);
		}
		
		if(isset($_COOKIE['cf7pp_skip'])) {
			$skip 			= sanitize_text_field($_COOKIE['cf7pp_skip']);
		}
		
		if(isset($_COOKIE['cf7pp_pub_key'])) {
			$pub_key 		= sanitize_text_field($_COOKIE['cf7pp_pub_key']);
		}
		
		if(isset($_COOKIE['cf7pp_amount_total'])) {
			$amount_total 	= sanitize_text_field($_COOKIE['cf7pp_amount_total']);
		}
		
		if(isset($_COOKIE['cf7pp_stripe_return'])) {
			$stripe_return 	= sanitize_text_field($_COOKIE['cf7pp_stripe_return']);
		}
		
		if(isset($_COOKIE['cf7pp_tags_id'])) {
			$tags_id 		= sanitize_text_field($_COOKIE['cf7pp_tags_id']);
		}
		
		if(isset($_COOKIE['cf7pp_input_id'])) {
			$input_id 		= sanitize_text_field($_COOKIE['cf7pp_input_id']);
		}
		
		if(isset($_COOKIE['cf7pp_payment_id'])) {
			$payment_id 		= sanitize_text_field($_COOKIE['cf7pp_payment_id']);
		}
		
	} else {
		
		if(isset($_SESSION['cf7pp_gateway'])) {
			$gateway 		= sanitize_text_field($_SESSION['cf7pp_gateway']);
		}
		
		if(isset($_SESSION['cf7pp_skip'])) {
			$skip 			= sanitize_text_field($_SESSION['cf7pp_skip']);
		}
		
		if(isset($_SESSION['cf7pp_pub_key'])) {
			$pub_key 		= sanitize_text_field($_SESSION['cf7pp_pub_key']);
		}
		
		if(isset($_SESSION['cf7pp_amount_total'])) {
			$amount_total 	= sanitize_text_field($_SESSION['cf7pp_amount_total']);
		}
		
		if(isset($_SESSION['cf7pp_stripe_return'])) {
			$stripe_return 	= sanitize_text_field($_SESSION['cf7pp_stripe_return']);
		}
		
		if(isset($_SESSION['cf7pp_tags_id'])) {
			$tags_id 		= sanitize_text_field($_SESSION['cf7pp_tags_id']);
		}
		
		if(isset($_SESSION['cf7pp_input_id'])) {
			$input_id 		= sanitize_text_field($_SESSION['cf7pp_input_id']);
		}
		
		if(isset($_SESSION['cf7pp_payment_id'])) {
			$payment_id 		= sanitize_text_field($_SESSION['cf7pp_payment_id']);
		}
		
	}


	$response = array(
		'gateway'         		=> $gateway,
		'skip'         			=> $skip,
		'pub_key'         		=> $pub_key,
		'amount_total'         	=> $amount_total,
		'stripe_return'        	=> $stripe_return,
		'tags_id'        		=> $tags_id,
		'input_id'        		=> $input_id,
		'payment_id'        	=> $payment_id,
	);

	echo json_encode($response);

	wp_die();
}
