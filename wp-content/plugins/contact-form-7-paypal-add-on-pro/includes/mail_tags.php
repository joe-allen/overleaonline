<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


// setup for emailing, convert tags, and save to db to be retrieved after ipn is sucessful
if  ($email == "1") {
	
	$array = (array) $submission_orig;
	$valuesa = array_values ($array);
	$array = (array) $valuesa[0];
	$values = array_values ($array);
	$post_unit_tag = $values[0];
	$uploaddir = "/cf7pp_uploads";
	
	
	// Contact Form 7 version 4.7 fix
	$result = is_array($values[3]);

	if ($result == '1') {
		$result_num = '3';
	} else {
		$result_num = '4';
	}
	
	


	// mail 1
	$everything = 			$values[$result_num ]['mail'];
	$body = 				$values[$result_num ]['mail']['body'];
	$subject = 				$values[$result_num ]['mail']['subject'];
	$sender = 				$values[$result_num ]['mail']['sender'];
	$additional_headers = 	$values[$result_num ]['mail']['additional_headers'];
	$recipient = 			$values[$result_num ]['mail']['recipient'];
	$attachments = 			$values[$result_num ]['mail']['attachments'];
	

	// mail 2
	$everything2 = 			$values[$result_num ]['mail_2'];
	$active2 = 				$values[$result_num ]['mail_2']['active'];
	$body2 = 				$values[$result_num ]['mail_2']['body'];
	$subject2 = 			$values[$result_num ]['mail_2']['subject'];
	$sender2 = 				$values[$result_num ]['mail_2']['sender'];
	$additional_headers2 = 	$values[$result_num ]['mail_2']['additional_headers'];
	$recipient2 = 			$values[$result_num ]['mail_2']['recipient'];
	$attachments2 = 		$values[$result_num ]['mail_2']['attachments'];

	include_once ('mail_tags_replace.php');
	include_once ('mail_tags_replace_special.php');

	// mail 1
	$body_new = replace_tags($body);
	$body_new = replace_tags_special($body_new);
	$subject_new = replace_tags($subject);
	$subject_new = replace_tags_special($subject_new);
	$sender_new = replace_tags($sender);
	$additional_headers_new = replace_tags($additional_headers);
	$recipient_new = replace_tags($recipient);

	// mail 2
	if ($active2 == "1") {
		$body_new2 = replace_tags($body2);
		$body_new2 = replace_tags_special($body_new2);
		$subject_new2 = replace_tags($subject2);
		$subject_new2 = replace_tags_special($subject_new2);
		$sender_new2 = replace_tags($sender2);
		$additional_headers_new2 = replace_tags($additional_headers2);
		$recipient_new2 = replace_tags($recipient2);
	}


	// as of version 2.8.4
	// in cf7 you can use use full file paths for attachments - https://contactform7.com/file-uploading-and-attachment/ - so here we need to swap the shortcode for the file path
	
	if (!empty($files_arr)) {
		
		$attachments = '';
		$attachments2 = '';
		
		foreach ($files_arr as $item_counter=>$item) {
			
			$attachments .= "uploads".$uploaddir.$item;
			$attachments .= "\r\n";
			
			$attachments2 .= "uploads".$uploaddir.$item;
			$attachments2 .= "\r\n";
			
		}
		
	}


	// filter that can be used for adding dynamic file attachments
	$attachments = 		apply_filters('cf7pp_attachments', $attachments, $submission_orig);
	$attachments2 = 	apply_filters('cf7pp_attachments2', $attachments2, $submission_orig);
	
	

	// mail 1
	unset($everything['body']);
	unset($everything['subject']);
	unset($everything['sender']);
	unset($everything['additional_headers']);
	unset($everything['recipient']);
	unset($everything['attachments']);

	// mail 2
	if ($active2 == "1") {
		unset($everything2['body2']);
		unset($everything2['subject2']);
		unset($everything2['sender2']);
		unset($everything2['additional_headers2']);
		unset($everything2['recipient2']);
		unset($everything2['attachments2']);
	}

	// mail 1
	$everything['body'] = $body_new;
	$everything['subject'] = $subject_new;
	$everything['sender'] = $sender_new;
	$everything['additional_headers'] = $additional_headers_new;
	$everything['recipient'] = $recipient_new;
	$everything['attachments'] = $attachments;

	// mail 2
	if ($active2 == "1") {
		$everything2['body'] = $body_new2;
		$everything2['subject'] = $subject_new2;
		$everything2['sender'] = $sender_new2;
		$everything2['additional_headers'] = $additional_headers_new2;
		$everything2['recipient'] = $recipient_new2;
		$everything2['attachments'] = $attachments2;
	}
	
	
	$main['mail'] = $everything;
	if ($active2 == "1") {
		$main['mail_2'] = $everything2;
	}

	$string = base64_encode(serialize($main));



	// create new post
	$my_post = array(
		'post_title'    => 'cf7pp_tmp_email',
		'post_status'   => 'private',
		'post_author'   => $current_user->ID,
		'post_type'     => 'cf7pp',
		'post_content'  => $string
	);

	// insert the post into the database
	global $new_post_id;
	$new_post_id = wp_insert_post($my_post);
	
} else {

	$new_post_id = "";

}


















// process tags for public_redirect.php


// get variables

$tags = (array) null;

$post_id = $post_id;

$tags['new_post_id'] = $new_post_id;

$enable = 			get_post_meta($post_id, "_cf7pp_enable", true);
$tags['name'] = 	get_post_meta($post_id, "_cf7pp_name", true);
$tags['price'] =	get_post_meta($post_id, "_cf7pp_price", true);
$tags['price_orig'] =	get_post_meta($post_id, "_cf7pp_price", true);
$tags['id'] = 		get_post_meta($post_id, "_cf7pp_id", true);
$tags['email'] = 	get_post_meta($post_id, "_cf7pp_email", true);
$tags['quantity'] = get_post_meta($post_id, "_cf7pp_quantity", true);
$tags['shipping'] = get_post_meta($post_id, "_cf7pp_shipping", true);
$ship = 			get_post_meta($post_id, "_cf7pp_ship", true);
$sandbox = 			get_post_meta($post_id, "_cf7pp_sandbox", true);
$note = 			get_post_meta($post_id, "_cf7pp_note", true);
$landingpage = 		get_post_meta($post_id, "_cf7pp_landingpage", true);
$form_account = 	get_post_meta($post_id, "_cf7pp_form_account", true);
$cancel = 			get_post_meta($post_id, "_cf7pp_cancel", true);
$return = 			get_post_meta($post_id, "_cf7pp_return", true);

$country = 			get_post_meta($post_id, "_cf7pp_country", true);
$state = 			get_post_meta($post_id, "_cf7pp_state", true);

$price_menu = 		get_post_meta($post_id, "_cf7pp_price_menu", true);
$price_menu2 = 		get_post_meta($post_id, "_cf7pp_price_menu2", true);
$price_menu3 = 		get_post_meta($post_id, "_cf7pp_price_menu3", true);
$price_menu4 = 		get_post_meta($post_id, "_cf7pp_price_menu4", true);
$price_menu5 = 		get_post_meta($post_id, "_cf7pp_price_menu5", true);

$quantity_menu = 	get_post_meta($post_id, "_cf7pp_quantity_menu", true);
$quantity_menu2 = 	get_post_meta($post_id, "_cf7pp_quantity_menu2", true);
$quantity_menu3 = 	get_post_meta($post_id, "_cf7pp_quantity_menu3", true);
$quantity_menu4 = 	get_post_meta($post_id, "_cf7pp_quantity_menu4", true);
$quantity_menu5 = 	get_post_meta($post_id, "_cf7pp_quantity_menu5", true);

$desc = 			get_post_meta($post_id, "_cf7pp_desc", true);
$desc2 = 			get_post_meta($post_id, "_cf7pp_desc2", true);
$desc3 = 			get_post_meta($post_id, "_cf7pp_desc3", true);
$desc4 = 			get_post_meta($post_id, "_cf7pp_desc4", true);
$desc5 = 			get_post_meta($post_id, "_cf7pp_desc5", true);

$stripe_email = 	get_post_meta($post_id, "_cf7pp_stripe_email", true);
$stripe_text = 		get_post_meta($post_id, "_cf7pp_stripe_text", true);





// stripe form variables
$stripe_account_id	= 	get_post_meta($post_id, "_cf7pp_stripe_account_id", true);
$stripe_token		= 	get_post_meta($post_id, "_cf7pp_stripe_token", true);
if( empty($stripe_account_id) || empty($stripe_token) ) {
	$stripe_pub_key = 	get_post_meta($post_id, "_cf7pp_stripe_pub_key", true);
	$stripe_sec_key = 	get_post_meta($post_id, "_cf7pp_stripe_sec_key", true);
}










$text_menu_a = get_post_meta($post_id, "_cf7pp_text_menu_a", true);
$tags['text_menu_a_name'] = get_post_meta($post_id, "_cf7pp_text_menu_a_name", true);
$text_menu_b = get_post_meta($post_id, "_cf7pp_text_menu_b", true);
$tags['text_menu_b_name'] = get_post_meta($post_id, "_cf7pp_text_menu_b_name", true);

$text_menu_a2 = get_post_meta($post_id, "_cf7pp_text_menu_a2", true);
$tags['text_menu_a_name2'] = get_post_meta($post_id, "_cf7pp_text_menu_a_name2", true);
$text_menu_b2 = get_post_meta($post_id, "_cf7pp_text_menu_b2", true);
$tags['text_menu_b_name2'] = get_post_meta($post_id, "_cf7pp_text_menu_b_name2", true);

$text_menu_a3 = get_post_meta($post_id, "_cf7pp_text_menu_a3", true);
$tags['text_menu_a_name3'] = get_post_meta($post_id, "_cf7pp_text_menu_a_name3", true);
$text_menu_b3 = get_post_meta($post_id, "_cf7pp_text_menu_b3", true);
$tags['text_menu_b_name3'] = get_post_meta($post_id, "_cf7pp_text_menu_b_name3", true);

$text_menu_a4 = get_post_meta($post_id, "_cf7pp_text_menu_a4", true);
$tags['text_menu_a_name4'] = get_post_meta($post_id, "_cf7pp_text_menu_a_name4", true);
$text_menu_b4 = get_post_meta($post_id, "_cf7pp_text_menu_b4", true);
$tags['text_menu_b_name4'] = get_post_meta($post_id, "_cf7pp_text_menu_b_name4", true);

$text_menu_a5 = get_post_meta($post_id, "_cf7pp_text_menu_a5", true);
$tags['text_menu_a_name5'] = get_post_meta($post_id, "_cf7pp_text_menu_a_name5", true);
$text_menu_b5 = get_post_meta($post_id, "_cf7pp_text_menu_b5", true);
$tags['text_menu_b_name5'] = get_post_meta($post_id, "_cf7pp_text_menu_b_name5", true);


$address1 = 		get_post_meta($post_id, "_cf7pp_address1", true);
$address2 = 		get_post_meta($post_id, "_cf7pp_address2", true);
$city = 			get_post_meta($post_id, "_cf7pp_city", true);
$state = 			get_post_meta($post_id, "_cf7pp_state", true);
$country = 			get_post_meta($post_id, "_cf7pp_country", true);
$zip = 				get_post_meta($post_id, "_cf7pp_zip", true);
$first_name = 		get_post_meta($post_id, "_cf7pp_first_name", true);
$last_name = 		get_post_meta($post_id, "_cf7pp_last_name", true);
$email_address = 	get_post_meta($post_id, "_cf7pp_email_address", true);
$phonea = 			get_post_meta($post_id, "_cf7pp_phonea", true);
$phoneb = 			get_post_meta($post_id, "_cf7pp_phoneb", true);
$phonec = 			get_post_meta($post_id, "_cf7pp_phonec", true);


$options = get_option('cf7pp_options');
foreach ($options as $k => $v ) { $value[$k] = $v; }

// live or test mode
if ($value['mode'] == "1") {
	$tags['account'] = $value['sandboxaccount'];
	$tags['path'] = "sandbox.paypal";
} elseif ($value['mode'] == "2")  {
	$tags['account'] = $value['liveaccount'];
	$tags['path'] = "paypal";
}

if ($sandbox == "1") {
	$tags['account'] = $value['sandboxaccount'];
	$tags['path'] = "sandbox.paypal";
}


// form page account override settings page
if (!empty($form_account)) {
    $tags['account'] = $form_account;
}








// set defaults in case uplugin has been updated without savings the settings page
if (!isset($value['mode_stripe'])) {
	$value['mode_stripe'] = '1';
}


// stripe - live or test mode - settings page
if ($value['mode_stripe'] == "1") {
	if ( !empty($value['acct_id_test']) && !empty($value['stripe_connect_token_test']) ) {
		$tags['account_id'] = $value['acct_id_test'];
		$tags['token'] = $value['stripe_connect_token_test'];
	} else {
		$tags['pub_key'] = $value['pub_key_test'];
		$tags['sec_key'] = $value['sec_key_test'];
	}

	$tags['stripe_state'] = "test";
} elseif ($value['mode_stripe'] == "2")  {
	if ( !empty($value['acct_id_live']) && !empty($value['stripe_connect_token_live']) ) {
		$tags['account_id'] = $value['acct_id_live'];
		$tags['token'] = $value['stripe_connect_token_live'];
	} else {
		$tags['pub_key'] = $value['pub_key_live'];
		$tags['sec_key'] = $value['sec_key_live'];
	}

	$tags['stripe_state'] = "live";
}


// form page account override settings page
if ($sandbox == "1") {
	if ( !empty($value['acct_id_test']) && !empty($value['stripe_connect_token_test']) ) {
		$tags['account_id'] = $value['acct_id_test'];
		$tags['token'] = $value['stripe_connect_token_test'];
	} else {
		$tags['pub_key'] = $value['pub_key_test'];
		$tags['sec_key'] = $value['sec_key_test'];
	}

	$tags['stripe_state'] = "test";
}


// form page account override settings page
if ( !empty($stripe_account_id) && !empty($stripe_token) ) {
	$tags['account_id'] = $stripe_account_id;
	$tags['token'] = $stripe_token;
	$tags['stripe_account_overridden'] = $post_id;
} else {
	$tags['stripe_account_overridden'] = 0;
}

if ( empty($tags['account_id']) && empty($tags['token']) && !empty($stripe_pub_key) ) {
	$tags['pub_key'] = $stripe_pub_key;
	$tags['sec_key'] = $stripe_sec_key;
}









// tax
if (!empty($value['tax'])) { $tags['tax'] = $value['tax']; } else { $tags['tax'] = ""; }
if (!empty($value['tax_rate'])) { $tags['tax_rate'] = $value['tax_rate']; } else { $tags['tax_rate'] = ""; }


// address
if (!empty($value['address'])) { $tags['address'] = $value['address']; } else { $tags['address'] = "0"; }


// currency

$currency_form = get_post_meta($post_id, "_cf7pp_currency", true);

if (!empty($currency_form)) {
	$value['currency'] = $currency_form;
}


// payment action

$tags['paymentaction'] = "sale";

if (isset($value['paymentaction'])) {
	if ($value['paymentaction'] == "1") {
		$tags['paymentaction'] = "sale";
	} elseif ($value['paymentaction'] == "2")  {
		$tags['paymentaction'] = "authorization";
	} else {
		$tags['paymentaction'] = "sale";
	}
}


if ($value['currency'] == "1") { $tags['currency'] = "AUD"; }
if ($value['currency'] == "2") { $tags['currency'] = "BRL"; }
if ($value['currency'] == "3") { $tags['currency'] = "CAD"; }
if ($value['currency'] == "4") { $tags['currency'] = "CZK"; }
if ($value['currency'] == "5") { $tags['currency'] = "DKK"; }
if ($value['currency'] == "6") { $tags['currency'] = "EUR"; }
if ($value['currency'] == "7") { $tags['currency'] = "HKD"; }
if ($value['currency'] == "8") { $tags['currency'] = "HUF"; }
if ($value['currency'] == "9") { $tags['currency'] = "ILS"; }
if ($value['currency'] == "10") { $tags['currency'] = "JPY"; }
if ($value['currency'] == "11") { $tags['currency'] = "MYR"; }
if ($value['currency'] == "12") { $tags['currency'] = "MXN"; }
if ($value['currency'] == "13") { $tags['currency'] = "NOK"; }
if ($value['currency'] == "14") { $tags['currency'] = "NZD"; }
if ($value['currency'] == "15") { $tags['currency'] = "PHP"; }
if ($value['currency'] == "16") { $tags['currency'] = "PLN"; }
if ($value['currency'] == "17") { $tags['currency'] = "GBP"; }
if ($value['currency'] == "18") { $tags['currency'] = "RUB"; }
if ($value['currency'] == "19") { $tags['currency'] = "SGD"; }
if ($value['currency'] == "20") { $tags['currency'] = "SEK"; }
if ($value['currency'] == "21") { $tags['currency'] = "CHF"; }
if ($value['currency'] == "22") { $tags['currency'] = "TWD"; }
if ($value['currency'] == "23") { $tags['currency'] = "THB"; }
if ($value['currency'] == "24") { $tags['currency'] = "TRY"; }
if ($value['currency'] == "25") { $tags['currency'] = "USD"; }

// language
if ($value['language'] == "1") {
	$tags['language'] = "da_DK";
} //Danish

if ($value['language'] == "2") {
	$tags['language'] = "nl_BE";
} //Dutch

if ($value['language'] == "3") {
	$tags['language'] = "EN_US";
} //English

if ($value['language'] == "20") {
	$tags['language'] = "en_GB";
} //English - UK

if ($value['language'] == "4") {
	$tags['language'] = "fr_CA";
} //French

if ($value['language'] == "5") {
	$tags['language'] = "de_DE";
} //German

if ($value['language'] == "6") {
	$tags['language'] = "he_IL";
} //Hebrew

if ($value['language'] == "7") {
	$tags['language'] = "it_IT";
} //Italian

if ($value['language'] == "8") {
	$tags['language'] = "ja_JP";
} //Japanese

if ($value['language'] == "9") {
	$tags['language'] = "no_NO";
} //Norwgian

if ($value['language'] == "10") {
	$tags['language'] = "pl_PL";
} //Polish

if ($value['language'] == "11") {
	$tags['language'] = "pt_BR";
} //Portuguese

if ($value['language'] == "12") {
	$tags['language'] = "ru_RU";
} //Russian

if ($value['language'] == "13") {
	$tags['language'] = "es_ES";
} //Spanish

if ($value['language'] == "14") {
	$tags['language'] = "sv_SE";
} //Swedish

if ($value['language'] == "15") {
	$tags['language'] = "zh_CN";
} //Simplified Chinese - China

if ($value['language'] == "16") {
	$tags['language'] = "zh_HK";
} //Traditional Chinese - Hong Kong

if ($value['language'] == "17") {
	$tags['language'] = "zh_TW";
} //Traditional Chinese - Taiwan

if ($value['language'] == "18") {
	$tags['language'] = "tr_TR";
} //Turkish

if ($value['language'] == "19") {
	$tags['language'] = "th_TH";
} //Thai

// note action
if ($note == "1") { $tags['notevalue'] = "1"; } else { $tags['notevalue'] = ""; }
if (!isset($note)) { $tags['notevalue'] = ""; }

// landing page action
if ($landingpage == "1") { $tags['landingpagevalue'] = "billing"; } else { $tags['landingpagevalue'] = ""; }
if (!isset($landingpage)) { $tags['landingpagevalue'] = ""; }

// return url
if (!empty($return)) { $tags['returnvalue'] = $return; } else { $tags['returnvalue'] = $value['return']; }
if (!isset($return)) { $tags['returnvalue'] = ""; }

// cancel url
if (!empty($cancel)) { $tags['cancelvalue'] = $cancel; } else { $tags['cancelvalue'] = $value['cancel']; }
if (!isset($cancel)) { $tags['cancelvalue'] = ""; }

// quantity menu
if (isset($_POST[$quantity_menu])) { $tags['quantity'] = 		$posted_data[$quantity_menu]; }
if (isset($_POST[$quantity_menu2])) { $tags['quantity2'] = 		$posted_data[$quantity_menu2]; }
if (isset($_POST[$quantity_menu3])) { $tags['quantity3'] = 		$posted_data[$quantity_menu3]; }
if (isset($_POST[$quantity_menu4])) { $tags['quantity4'] = 		$posted_data[$quantity_menu4]; }
if (isset($_POST[$quantity_menu5])) { $tags['quantity5'] = 		$posted_data[$quantity_menu5]; }


if (isset($tags['quantity'])) {
	$desc_a_array = is_array($tags['quantity']) ? '1' : '2';
	if ($desc_a_array == "1") {
		$counter_a = "0";
		$text_menu_a_c = "";
		foreach($tags['quantity'] as $val) {
			if ($counter_a >= "1") {
				$text_menu_a_c .= ", ";
			}
			$text_menu_a_c .= $val;
		$counter_a++;
		}
		$tags['quantity'] = $text_menu_a_c;
	}
}

if (isset($tags['quantity2'])) {
	$desc_a_array = is_array($tags['quantity2']) ? '1' : '2';
	if ($desc_a_array == "1") {
		$counter_a = "0";
		$text_menu_a_c = "";
		foreach($tags['quantity2'] as $val) {
			if ($counter_a >= "1") {
				$text_menu_a_c .= ", ";
			}
			$text_menu_a_c .= $val;
		$counter_a++;
		}
		$tags['quantity2'] = $text_menu_a_c;
	}
}

if (isset($tags['quantity3'])) {
	$desc_a_array = is_array($tags['quantity3']) ? '1' : '2';
	if ($desc_a_array == "1") {
		$counter_a = "0";
		$text_menu_a_c = "";
		foreach($tags['quantity3'] as $val) {
			if ($counter_a >= "1") {
				$text_menu_a_c .= ", ";
			}
			$text_menu_a_c .= $val;
		$counter_a++;
		}
		$tags['quantity3'] = $text_menu_a_c;
	}
}

if (isset($tags['quantity4'])) {
	$desc_a_array = is_array($tags['quantity4']) ? '1' : '2';
	if ($desc_a_array == "1") {
		$counter_a = "0";
		$text_menu_a_c = "";
		foreach($tags['quantity4'] as $val) {
			if ($counter_a >= "1") {
				$text_menu_a_c .= ", ";
			}
			$text_menu_a_c .= $val;
		$counter_a++;
		}
		$tags['quantity4'] = $text_menu_a_c;
	}
}

if (isset($tags['quantity5'])) {
	$desc_a_array = is_array($tags['quantity5']) ? '1' : '2';
	if ($desc_a_array == "1") {
		$counter_a = "0";
		$text_menu_a_c = "";
		foreach($tags['quantity5'] as $val) {
			if ($counter_a >= "1") {
				$text_menu_a_c .= ", ";
			}
			$text_menu_a_c .= $val;
		$counter_a++;
		}
		$tags['quantity5'] = $text_menu_a_c;
	}
}


// price menu
if (isset($_POST[$price_menu])) { 						$tags['price'] = $posted_data[$price_menu]; }
if (isset($_POST[$price_menu2])) { 						$tags['price2'] = $posted_data[$price_menu2]; }
if (isset($_POST[$price_menu3])) { 						$tags['price3'] = $posted_data[$price_menu3]; }
if (isset($_POST[$price_menu4])) { 						$tags['price4'] = $posted_data[$price_menu4]; }
if (isset($_POST[$price_menu5])) { 						$tags['price5'] = $posted_data[$price_menu5]; }


// item 1 - text menu
if (isset($_POST[$text_menu_a])) { 						$tags['text_menu_a'] = $_POST[$text_menu_a]; } else { $tags['text_menu_a'] = ""; }
if (isset($_POST[$text_menu_b])) { 						$tags['text_menu_b'] = $_POST[$text_menu_b]; } else { $tags['text_menu_b'] = ""; }

// item 2 - text menu
if (isset($_POST[$text_menu_a2])) { 					$tags['text_menu_a2'] = $_POST[$text_menu_a2]; } else { $tags['text_menu_a2'] = ""; }
if (isset($_POST[$text_menu_b2])) { 					$tags['text_menu_b2'] = $_POST[$text_menu_b2]; } else { $tags['text_menu_b2'] = ""; }

// item 3 - text menu
if (isset($_POST[$text_menu_a3])) { 					$tags['text_menu_a3'] = $_POST[$text_menu_a3]; } else { $tags['text_menu_a3'] = ""; }
if (isset($_POST[$text_menu_b3])) { 					$tags['text_menu_b3'] = $_POST[$text_menu_b3]; } else { $tags['text_menu_b3'] = ""; }

// item 4 - text menu
if (isset($_POST[$text_menu_a4])) { 					$tags['text_menu_a4'] = $_POST[$text_menu_a4]; } else { $tags['text_menu_a4'] = ""; }
if (isset($_POST[$text_menu_b4])) { 					$tags['text_menu_b4'] = $_POST[$text_menu_b4]; } else { $tags['text_menu_b4'] = ""; }

// item 5 - text menu
if (isset($_POST[$text_menu_a5])) { 					$tags['text_menu_a5'] = $_POST[$text_menu_a5]; } else { $tags['text_menu_a5'] = ""; }
if (isset($_POST[$text_menu_b5])) { 					$tags['text_menu_b5'] = $_POST[$text_menu_b5]; } else { $tags['text_menu_b5'] = ""; }

// description
if (isset($_POST[$desc])) { 							$tags['name'] = $_POST[$desc];  } elseif (empty($tags['name'])) { $tags['name'] = ""; }
if (isset($_POST[$desc2])) { 							$tags['name2'] = $_POST[$desc2]; } else { $tags['name2'] = ""; }
if (isset($_POST[$desc3])) { 							$tags['name3'] = $_POST[$desc3]; } else { $tags['name3'] = ""; }
if (isset($_POST[$desc4])) { 							$tags['name4'] = $_POST[$desc4]; } else { $tags['name4'] = ""; }
if (isset($_POST[$desc5])) { 							$tags['name5'] = $_POST[$desc5]; } else { $tags['name5'] = ""; }

// customer values
if (isset($_POST[$country])) { 							$tags['country'] = $posted_data[$country]; }
if (isset($_POST[$state])) { 							$tags['state'] = $posted_data[$state]; }


if (isset($_POST[$address1])) { $tags['address1'] = 	$_POST[$address1]; } else { $tags['address1'] = ""; }
if (isset($_POST[$address2])) { $tags['address2'] = 	$_POST[$address2]; } else { $tags['address2'] = ""; }
if (isset($_POST[$city])) { $tags['city'] = 			$_POST[$city]; } else { $tags['city'] = ""; }
if (isset($_POST[$zip])) { $tags['zip'] = 				$_POST[$zip]; } else { $tags['zip'] = ""; }
if (isset($_POST[$email_address])) { 					$tags['email_address'] = $_POST[$email_address]; } else { $tags['email_address'] = ""; }
if (isset($_POST[$phonea])) { 							$tags['phonea'] = $_POST[$phonea]; } else { $tags['phonea'] = ""; }
if (isset($_POST[$phoneb])) { 							$tags['phoneb'] = $_POST[$phoneb]; } else { $tags['phoneb'] = ""; }
if (isset($_POST[$phonec])) { 							$tags['phonec'] = $_POST[$phonec]; } else { $tags['phonec'] = ""; }
if (isset($_POST[$first_name])) { 						$tags['first_name'] = $_POST[$first_name]; } else { $tags['first_name'] = ""; }
if (isset($_POST[$last_name])) { 						$tags['last_name'] = $_POST[$last_name]; } else { $tags['last_name'] = ""; }


if (isset($_POST[$stripe_email])) { 					$tags['stripe_email'] = $posted_data[$stripe_email]; }
if (isset($_POST[$stripe_text])) { 						$tags['stripe_text'] = $posted_data[$stripe_text]; }


// for country and state, a dropdown menu is most common which may use a pipe. So we may need to get the value after the pipe
if (isset($tags['country'])) {
	$country = is_array($tags['country']) ? '1' : '2';
	if ($country == "1") {
		$counter_a = "0";
		$country_a_c = "";
		foreach($tags['country'] as $val) {
			if ($counter_a >= "1") {
				$country_a_c .= ", ";
			}
			$country_a_c .= $val;
		$counter_a++;
		}
		$tags['country'] = $country_a_c;
	}
}

if (isset($tags['state'])) {
	$state = is_array($tags['state']) ? '1' : '2';
	if ($state == "1") {
		$counter_a = "0";
		$state_a_c = "";
		foreach($tags['state'] as $val) {
			if ($counter_a >= "1") {
				$state_a_c .= ", ";
			}
			$state_a_c .= $val;
		$counter_a++;
		}
		$tags['state'] = $state_a_c;
	}
}






if (isset($tags['name'])) {
	$desc_a_array = is_array($tags['name']) ? '1' : '2';
	if ($desc_a_array == "1") {
		$counter_a = "0";
		$text_menu_a_c = "";
		foreach($tags['name'] as $val) {
			if ($counter_a >= "1") {
				$text_menu_a_c .= ", ";
			}
			$text_menu_a_c .= $val;
		$counter_a++;
		}
		$tags['name'] = $text_menu_a_c;
	}
}

if (isset($tags['name2'])) {
	$desc_a_array = is_array($tags['name2']) ? '1' : '2';
	if ($desc_a_array == "1") {
		$counter_a = "0";
		$text_menu_a_c = "";
		foreach($tags['name2'] as $val) {
			if ($counter_a >= "1") {
				$text_menu_a_c .= ", ";
			}
			$text_menu_a_c .= $val;
		$counter_a++;
		}
		$tags['name2'] = $text_menu_a_c;
	}
}

if (isset($tags['name3'])) {
	$desc_a_array = is_array($tags['name3']) ? '1' : '2';
	if ($desc_a_array == "1") {
		$counter_a = "0";
		$text_menu_a_c = "";
		foreach($tags['name3'] as $val) {
			if ($counter_a >= "1") {
				$text_menu_a_c .= ", ";
			}
			$text_menu_a_c .= $val;
		$counter_a++;
		}
		$tags['name3'] = $text_menu_a_c;
	}
}

if (isset($tags['name4'])) {
	$desc_a_array = is_array($tags['name4']) ? '1' : '2';
	if ($desc_a_array == "1") {
		$counter_a = "0";
		$text_menu_a_c = "";
		foreach($tags['name4'] as $val) {
			if ($counter_a >= "1") {
				$text_menu_a_c .= ", ";
			}
			$text_menu_a_c .= $val;
		$counter_a++;
		}
		$tags['name4'] = $text_menu_a_c;
	}
}

if (isset($tags['name5'])) {
	$desc_a_array = is_array($tags['name5']) ? '1' : '2';
	if ($desc_a_array == "1") {
		$counter_a = "0";
		$text_menu_a_c = "";
		foreach($tags['name5'] as $val) {
			if ($counter_a >= "1") {
				$text_menu_a_c .= ", ";
			}
			$text_menu_a_c .= $val;
		$counter_a++;
		}
		$tags['name5'] = $text_menu_a_c;
	}
}






// shipping code

if (isset($ship) && !empty($ship)) {

	$tags['shipping'] = $posted_data[$ship];
	
}

// for certain values that are arrays

// price


// used for recurring payments
$tags['price_orig'] = $tags['price'];

if (isset($tags['price'])) {
	$price_array = is_array($tags['price']) ? '1' : '2';

	if ($price_array == "1") {
		
		$price_total = 0;
		foreach ($tags['price'] as $val) {
			
			
			$val = preg_replace('/[^0-9.]*/','',$val);
			
			$price_total = $val + $price_total;
			
		}
		
		$tags['price'] = $price_total;
	}
}


if (isset($tags['price2'])) {
	$price_array = is_array($tags['price2']) ? '1' : '2';

	if ($price_array == "1") {

		$price_total = 0;
		foreach ($tags['price2'] as $val) {
			
			$val = preg_replace('/[^0-9.]*/','',$val);
			
			$price_total = $val + $price_total;
			
		}
		
		$tags['price2'] = $price_total;
	}
}

if (isset($tags['price3'])) {
	$price_array = is_array($tags['price3']) ? '1' : '2';

	if ($price_array == "1") {

		$price_total = 0;
		foreach ($tags['price3'] as $val) {
			
			$val = preg_replace('/[^0-9.]*/','',$val);
			
			$price_total = $val + $price_total;
			
		}
		
		$tags['price3'] = $price_total;
	}
}

if (isset($tags['price4'])) {
	$price_array = is_array($tags['price4']) ? '1' : '2';

	if ($price_array == "1") {

		$price_total = 0;
		foreach ($tags['price4'] as $val) {
			
			$val = preg_replace('/[^0-9.]*/','',$val);
			
			$price_total = $val + $price_total;
			
		}
		
		$tags['price4'] = $price_total;
	}	
}

if (isset($tags['price5'])) {
	$price_array = is_array($tags['price5']) ? '1' : '2';

	if ($price_array == "1") {

		$price_total = 0;
		foreach ($tags['price5'] as $val) {
			
			$val = preg_replace('/[^0-9.]*/','',$val);
			
			$price_total = $val + $price_total;
			
		}
		
		$tags['price5'] = $price_total;
	}
}


// desc 1 - field 1
if (isset($tags['text_menu_a'])) {
	$desc_a_array = is_array($tags['text_menu_a']) ? '1' : '2';
	if ($desc_a_array == "1") {
		$counter_a = "0";
		$text_menu_a_c = "";
		foreach($tags['text_menu_a'] as $val) {
			if ($counter_a >= "1") {
				$text_menu_a_c .= ", ";
			}
			$text_menu_a_c .= $val;
		$counter_a++;
		}
		$tags['text_menu_a'] = $text_menu_a_c;
	}
}

// field 2
if (isset($tags['text_menu_b'])) {
	$desc_b_array = is_array($tags['text_menu_b']) ? '1' : '2';
	if ($desc_b_array == "1") {
		$counter_b = "0";
		$text_menu_b_c = "";
		foreach($tags['text_menu_b'] as $val) {
			if ($counter_b >= "1") {
				$text_menu_b_c .= ", ";
			}
			$text_menu_b_c .= $val;
		$counter_b++;
		}
		$tags['text_menu_b'] = $text_menu_b_c;
	}
}

// desc 2 - field 1
if (isset($tags['text_menu_a2'])) {
	$desc_a_array = is_array($tags['text_menu_a2']) ? '1' : '2';
	if ($desc_a_array == "1") {
		$counter_a = "0";
		$text_menu_a_c = "";
		foreach($tags['text_menu_a2'] as $val) {
			if ($counter_a >= "1") {
				$text_menu_a_c .= ", ";
			}
			$text_menu_a_c .= $val;
		$counter_a++;
		}
		$tags['text_menu_a2'] = $text_menu_a_c;
	}
}

// field 2
if (isset($tags['text_menu_b2'])) {
	$desc_b_array = is_array($tags['text_menu_b2']) ? '1' : '2';
	if ($desc_b_array == "1") {
		$counter_b = "0";
		$text_menu_b_c = "";
		foreach($tags['text_menu_b2'] as $val) {
			if ($counter_b >= "1") {
				$text_menu_b_c .= ", ";
			}
			$text_menu_b_c .= $val;
		$counter_b++;
		}
		$tags['text_menu_b2'] = $text_menu_b_c;
	}
}

// desc 3 - field 1
if (isset($tags['text_menu_a3'])) {
	$desc_a_array = is_array($tags['text_menu_a3']) ? '1' : '2';
	if ($desc_a_array == "1") {
		$counter_a = "0";
		$text_menu_a_c = "";
		foreach($tags['text_menu_a3'] as $val) {
			if ($counter_a >= "1") {
				$text_menu_a_c .= ", ";
			}
			$text_menu_a_c .= $val;
		$counter_a++;
		}
		$tags['text_menu_a3'] = $text_menu_a_c;
	}
}

// field 2
if (isset($tags['text_menu_b3'])) {
	$desc_b_array = is_array($tags['text_menu_b3']) ? '1' : '2';
	if ($desc_b_array == "1") {
		$counter_b = "0";
		$text_menu_b_c = "";
		foreach($tags['text_menu_b3'] as $val) {
			if ($counter_b >= "1") {
				$text_menu_b_c .= ", ";
			}
			$text_menu_b_c .= $val;
		$counter_b++;
		}
		$tags['text_menu_b3'] = $text_menu_b_c;
	}
}

// desc 4 - field 1
if (isset($tags['text_menu_a4'])) {
	$desc_a_array = is_array($tags['text_menu_a4']) ? '1' : '2';
	if ($desc_a_array == "1") {
		$counter_a = "0";
		$text_menu_a_c = "";
		foreach($tags['text_menu_a4'] as $val) {
			if ($counter_a >= "1") {
				$text_menu_a_c .= ", ";
			}
			$text_menu_a_c .= $val;
		$counter_a++;
		}
		$tags['text_menu_a4'] = $text_menu_a_c;
	}
}

// field 2
if (isset($tags['text_menu_b4'])) {
	$desc_b_array = is_array($tags['text_menu_b4']) ? '1' : '2';
	if ($desc_b_array == "1") {
		$counter_b = "0";
		$text_menu_b_c = "";
		foreach($tags['text_menu_b4'] as $val) {
			if ($counter_b >= "1") {
				$text_menu_b_c .= ", ";
			}
			$text_menu_b_c .= $val;
		$counter_b++;
		}
		$tags['text_menu_b4'] = $text_menu_b_c;
	}
}

// desc 5 - field 1
if (isset($tags['text_menu_a5'])) {
	$desc_a_array = is_array($tags['text_menu_a5']) ? '1' : '2';
	if ($desc_a_array == "1") {
		$counter_a = "0";
		$text_menu_a_c = "";
		foreach($tags['text_menu_a5'] as $val) {
			if ($counter_a >= "1") {
				$text_menu_a_c .= ", ";
			}
			$text_menu_a_c .= $val;
		$counter_a++;
		}
		$tags['text_menu_a5'] = $text_menu_a_c;
	}
}

// field 2
if (isset($tags['text_menu_b5'])) {
	$desc_b_array = is_array($tags['text_menu_b5']) ? '1' : '2';
	if ($desc_b_array == "1") {
		$counter_b = "0";
		$text_menu_b_c = "";
		foreach($tags['text_menu_b5'] as $val) {
			if ($counter_b >= "1") {
				$text_menu_b_c .= ", ";
			}
			$text_menu_b_c .= $val;
		$counter_b++;
		}
		$tags['text_menu_b5'] = $text_menu_b_c;
	}
}

















	// total amount
	$amount = '0.00';
	
	
	
	if (!empty($tags['price'])) {
		if ($tags['quantity'] == "") { $tags['quantity']  = "1"; }
		
		$amount = $tags['price'] * $tags['quantity'];
	}
	
	if (!empty($tags['price2'])) {
		if ($tags['quantity2'] == "") { $tags['quantity2']  = "1"; }
		
		$amount = $amount + $tags['price2'] * $tags['quantity2'];
	}
	
	if (!empty($tags['price3'])) {
		if ($tags['quantity3'] == "") { $tags['quantity3']  = "1"; }
		
		$amount = $amount + $tags['price3'] * $tags['quantity3'];
	}
	
	if (!empty($tags['price4'])) {
		if ($tags['quantity4'] == "") { $tags['quantity4']  = "1"; }
		
		$amount = $amount + $tags['price4'] * $tags['quantity4'];
	}
	
	if (!empty($tags['price5'])) {
		if ($tags['quantity5'] == "") { $tags['quantity5']  = "1"; }
		
		$amount = $amount + $tags['price5'] * $tags['quantity5'];
	}
	
	
	if (!empty($tags['tax'])) {
		$amount = $amount + $tags['tax'];
	}
	
	if (!empty($tags['tax_rate'])) {		
		$tax= 		$amount * $tags['tax_rate'] / 100;
		$amount = 	$amount + $tax;
	}
	
	// shipping has to be added after tax since it is not taxed
	if (!empty($tags['shipping'])) {
		$amount = $amount + cf7pp_format_currency($tags['shipping']);
	}

	// round number to 2 decimal places
	$tags['amount_total'] = number_format((float)$amount, 2, '.', '');




	// reset values
	
	if (empty($options['session'])) {
		$session = '1';
	} else {
		$session = $options['session'];
	}

	if ($session == '1') {
		setcookie('cf7pp_stripe_state', '', ['expires' => time()+3600, 'path' => '/', 'domain' => $_SERVER['HTTP_HOST'], 'secure' => false, 'httponly' => false, 'samesite' => 'strict']);
		setcookie('cf7pp_amount_total', '', ['expires' => time()+3600, 'path' => '/', 'domain' => $_SERVER['HTTP_HOST'], 'secure' => false, 'httponly' => false, 'samesite' => 'strict']);
	} else {
		session_start();
		$_SESSION['cf7pp_stripe_state'] = '';
		$_SESSION['cf7pp_amount_total'] = '';
		session_write_close();
	}




// save tags
$tags_string = base64_encode(serialize($tags));


// create new post
$my_post_tags = array(
	'post_title'    => 'cf7pp_tmp_tags',
	'post_status'   => 'private',
	'post_author'   => $current_user->ID,
	'post_type'     => 'cf7pp',
	'post_content'  => $tags_string
);

// insert the post into the database
global $tags_id;
$tags_id = wp_insert_post($my_post_tags);