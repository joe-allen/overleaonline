<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


// hook into contact form 7 form
function cf7pp_editor_panels ( $panels ) {

	$new_page = array(
		'PayPal' => array(
			'title' => __( 'PayPal & Stripe', 'contact-form-7-paypal' ),
			'callback' => 'cf7pp_admin_after_additional_settings'
		)
	);

	$panels = array_merge($panels, $new_page);

	return $panels;

}
add_filter( 'wpcf7_editor_panels', 'cf7pp_editor_panels' );


function cf7pp_admin_after_additional_settings( $cf7 ) {
	
	$post_id = sanitize_text_field($_GET['post']);
	
	$enable = 						get_post_meta($post_id, "_cf7pp_enable", true);
	$enable_stripe = 				get_post_meta($post_id, "_cf7pp_enable_stripe", true);
	$price_skip = 					get_post_meta($post_id, "_cf7pp_skip", true);
	$name = 						get_post_meta($post_id, "_cf7pp_name", true);
	$gateway = 						get_post_meta($post_id, "_cf7pp_gateway", true);
	
	$price = 						get_post_meta($post_id, "_cf7pp_price", true);
	$id = 							get_post_meta($post_id, "_cf7pp_id", true);
	$email = 						get_post_meta($post_id, "_cf7pp_email", true);
	$quantity = 					get_post_meta($post_id, "_cf7pp_quantity", true);
	$shipping = 					get_post_meta($post_id, "_cf7pp_shipping", true);
	$ship = 						get_post_meta($post_id, "_cf7pp_ship", true);
	$sandbox = 						get_post_meta($post_id, "_cf7pp_sandbox", true);
	$note = 						get_post_meta($post_id, "_cf7pp_note", true);
	
	$form_account = 				get_post_meta($post_id, "_cf7pp_form_account", true);

	$stripe_account_id = 			get_post_meta($post_id, "_cf7pp_stripe_account_id", true);
	$stripe_token = 				get_post_meta($post_id, "_cf7pp_stripe_token", true);
	if ( empty($stripe_account_id) || empty($stripe_token) ) {
		$stripe_pub_key = 				get_post_meta($post_id, "_cf7pp_stripe_pub_key", true);
		$stripe_sec_key = 				get_post_meta($post_id, "_cf7pp_stripe_sec_key", true);
	}
	
	$currency = 					get_post_meta($post_id, "_cf7pp_currency", true);
	$cancel = 						get_post_meta($post_id, "_cf7pp_cancel", true);
	$return = 						get_post_meta($post_id, "_cf7pp_return", true);
	$skip_code = 					get_post_meta($post_id, "_cf7pp_skip_code", true);
	$landingpage = 					get_post_meta($post_id, "_cf7pp_landingpage", true);
	
	$quantity_menu = 				get_post_meta($post_id, "_cf7pp_quantity_menu", true);
	$quantity_menu2 = 				get_post_meta($post_id, "_cf7pp_quantity_menu2", true);
	$quantity_menu3 = 				get_post_meta($post_id, "_cf7pp_quantity_menu3", true);
	$quantity_menu4 = 				get_post_meta($post_id, "_cf7pp_quantity_menu4", true);
	$quantity_menu5 = 				get_post_meta($post_id, "_cf7pp_quantity_menu5", true);
	
	$price_menu = 					get_post_meta($post_id, "_cf7pp_price_menu", true);
	$price_menu2 = 					get_post_meta($post_id, "_cf7pp_price_menu2", true);
	$price_menu3 = 					get_post_meta($post_id, "_cf7pp_price_menu3", true);
	$price_menu4 = 					get_post_meta($post_id, "_cf7pp_price_menu4", true);
	$price_menu5 = 					get_post_meta($post_id, "_cf7pp_price_menu5", true);
	
	$desc = 						get_post_meta($post_id, "_cf7pp_desc", true);
	$desc2 = 						get_post_meta($post_id, "_cf7pp_desc2", true);
	$desc3 = 						get_post_meta($post_id, "_cf7pp_desc3", true);
	$desc4 = 						get_post_meta($post_id, "_cf7pp_desc4", true);
	$desc5 = 						get_post_meta($post_id, "_cf7pp_desc5", true);
	
	$text_menu_a = 					get_post_meta($post_id, "_cf7pp_text_menu_a", true);
	$text_menu_a_name = 			get_post_meta($post_id, "_cf7pp_text_menu_a_name", true);
	$text_menu_b = 					get_post_meta($post_id, "_cf7pp_text_menu_b", true);
	$text_menu_b_name = 			get_post_meta($post_id, "_cf7pp_text_menu_b_name", true);
	
	$text_menu_a2 = 				get_post_meta($post_id, "_cf7pp_text_menu_a2", true);
	$text_menu_a_name2 = 			get_post_meta($post_id, "_cf7pp_text_menu_a_name2", true);
	$text_menu_b2 = 				get_post_meta($post_id, "_cf7pp_text_menu_b2", true);
	$text_menu_b_name2 = 			get_post_meta($post_id, "_cf7pp_text_menu_b_name2", true);
	
	$text_menu_a3 = 				get_post_meta($post_id, "_cf7pp_text_menu_a3", true);
	$text_menu_a_name3 = 			get_post_meta($post_id, "_cf7pp_text_menu_a_name3", true);
	$text_menu_b3 = 				get_post_meta($post_id, "_cf7pp_text_menu_b3", true);
	$text_menu_b_name3 = 			get_post_meta($post_id, "_cf7pp_text_menu_b_name3", true);
	
	$text_menu_a4 = 				get_post_meta($post_id, "_cf7pp_text_menu_a4", true);
	$text_menu_a_name4 = 			get_post_meta($post_id, "_cf7pp_text_menu_a_name4", true);
	$text_menu_b4 = 				get_post_meta($post_id, "_cf7pp_text_menu_b4", true);
	$text_menu_b_name4 = 			get_post_meta($post_id, "_cf7pp_text_menu_b_name4", true);
	
	$text_menu_a5 = 				get_post_meta($post_id, "_cf7pp_text_menu_a5", true);
	$text_menu_a_name5 = 			get_post_meta($post_id, "_cf7pp_text_menu_a_name5", true);
	$text_menu_b5 = 				get_post_meta($post_id, "_cf7pp_text_menu_b5", true);
	$text_menu_b_name5 = 			get_post_meta($post_id, "_cf7pp_text_menu_b_name5", true);
	
	$address1 = 					get_post_meta($post_id, "_cf7pp_address1", true);
	$address2 = 					get_post_meta($post_id, "_cf7pp_address2", true);
	$city = 						get_post_meta($post_id, "_cf7pp_city", true);
	$state = 						get_post_meta($post_id, "_cf7pp_state", true);
	$country = 						get_post_meta($post_id, "_cf7pp_country", true);
	$zip = 							get_post_meta($post_id, "_cf7pp_zip", true);
	
	$email_address = 				get_post_meta($post_id, "_cf7pp_email_address", true);
	$first_name = 					get_post_meta($post_id, "_cf7pp_first_name", true);
	$last_name = 					get_post_meta($post_id, "_cf7pp_last_name", true);
	$phonea = 						get_post_meta($post_id, "_cf7pp_phonea", true);
	$phoneb = 						get_post_meta($post_id, "_cf7pp_phoneb", true);
	$phonec = 						get_post_meta($post_id, "_cf7pp_phonec", true);
	
	$stripe_email = 				get_post_meta($post_id, "_cf7pp_stripe_email", true);
	$stripe_text = 					get_post_meta($post_id, "_cf7pp_stripe_text", true);
	$stripe_return = 				get_post_meta($post_id, "_cf7pp_stripe_return", true);
	
	if ($enable == "1") { 				$checked = "CHECKED"; } else { 			$checked = ""; }
	if ($sandbox == "1") { 				$checked_sandbox = "CHECKED"; } else { 	$checked_sandbox = ""; }
	if ($price_skip == "1") { 			$checked_skip = "CHECKED"; } else { 	$checked_skip = ""; }
	if ($landingpage == "1") { 			$landingpage = "CHECKED"; } else { 		$landingpage = ""; }
	if ($enable_stripe == "1") { 		$checked_stripe = "CHECKED"; } else { 	$checked_stripe = ""; }
	
	if ($email == "1" || $email == "2" || $email == "3") {
		if ($email == "2") { $before = " selected='selected' "; $after = ""; $never = ""; }
		if ($email == "1") { $after = " selected='selected' "; $before = ""; $never = ""; } 
		if ($email == "3") { $never = " selected='selected' "; $before = ""; $after = ""; }
	} else {
		$before = ""; $after = ""; $never = "";
	}
	
	if ($note == "1") { $checkednote = "CHECKED"; } else { $checkednote = ""; }
	

	$admin_table_output = "";
	$admin_table_output .= "<h2>PayPal & Stripe Settings</h2>";

	$admin_table_output .= "<div class='mail-field'></div>";
	
	$admin_table_output .= "<table class='cf7pp_tabs_table_main'><tr>";

	$admin_table_output .= "<td><b>General Settings</b></td></tr>";

	$admin_table_output .= "<td class='cf7pp_tabs_table_title_width'><label>Enable PayPal on this form: </label></td>";
	$admin_table_output .= "<td class='cf7pp_tabs_table_body_width'><input name='cf7pp_enable' value='1' type='checkbox' $checked></td></tr>";

	$admin_table_output .= "<td><label>Enable Stripe on this form</label></td>";
	$admin_table_output .= "<td><input name='cf7pp_enable_stripe' value='1' type='checkbox' $checked_stripe></td></tr>";

	$admin_table_output .= "<tr><td>Sandbox Mode: </td><td>";
	$admin_table_output .= "<input name='cf7pp_sandbox' value='1' type='checkbox' $checked_sandbox> </td><td>(Optional, will override settings page value. Check to enable sandbox mode.</td></tr><tr><td valign='top'>";

	$admin_table_output .= "Skip Redirect: </td><td>";
	$admin_table_output .= "<input name='cf7pp_price_skip' value='1' type='checkbox' $checked_skip> </td><td> (Optional - Check if you would like to skip redirecting for 0.00 amounts.)</td></tr><tr><td valign='top'>";

	$admin_table_output .= "Send Contact Form 7 Email: </td><td>";
	$admin_table_output .= "<select class='cf7pp_tabs_table_select_width' name='cf7pp_email' id='email'><option value='2' $before >Before redirecting to PayPal / Stripe</option><option value='1' $after >After payment is successful</option><option value='3' $never >Never send email</option></select></td></tr><tr><td>";



	$admin_table_output .= "Currency: </td><td>";
	$admin_table_output .= "
			<select class='cf7pp_tabs_table_select_width' name='cf7pp_currency'>
			<option "; if ($currency == '0') { $admin_table_output .= 'SELECTED'; } $admin_table_output .= " value='0'>Default Currency</option>
			<option "; if ($currency == '1') { $admin_table_output .= 'SELECTED'; } $admin_table_output .= " value='1'>Australian Dollar - AUD</option>
			<option "; if ($currency == '2') { $admin_table_output .= 'SELECTED'; } $admin_table_output .= " value='2'>Brazilian Real - BRL</option> 
			<option "; if ($currency == '3') { $admin_table_output .= 'SELECTED'; } $admin_table_output .= " value='3'>Canadian Dollar - CAD</option>
			<option "; if ($currency == '4') { $admin_table_output .= 'SELECTED'; } $admin_table_output .= " value='4'>Czech Koruna - CZK</option>
			<option "; if ($currency == '5') { $admin_table_output .= 'SELECTED'; } $admin_table_output .= " value='5'>Danish Krone - DKK</option>
			<option "; if ($currency == '6') { $admin_table_output .= 'SELECTED'; } $admin_table_output .= " value='6'>Euro - EUR</option>
			<option "; if ($currency == '7') { $admin_table_output .= 'SELECTED'; } $admin_table_output .= " value='7'>Hong Kong Dollar - HKD</option> 	 
			<option "; if ($currency == '8') { $admin_table_output .= 'SELECTED'; } $admin_table_output .= " value='8'>Hungarian Forint - HUF</option>
			<option "; if ($currency == '9') { $admin_table_output .= 'SELECTED'; } $admin_table_output .= " value='9'>Israeli New Sheqel - ILS</option>
			<option "; if ($currency == '10') { $admin_table_output .= 'SELECTED'; } $admin_table_output .= " value='10'>Japanese Yen - JPY</option>
			<option "; if ($currency == '11') { $admin_table_output .= 'SELECTED'; } $admin_table_output .= " value='11'>Malaysian Ringgit - MYR</option>
			<option "; if ($currency == '12') { $admin_table_output .= 'SELECTED'; } $admin_table_output .= " value='12'>Mexican Peso - MXN</option>
			<option "; if ($currency == '13') { $admin_table_output .= 'SELECTED'; } $admin_table_output .= " value='13'>Norwegian Krone - NOK</option>
			<option "; if ($currency == '14') { $admin_table_output .= 'SELECTED'; } $admin_table_output .= " value='14'>New Zealand Dollar - NZD</option>
			<option "; if ($currency == '15') { $admin_table_output .= 'SELECTED'; } $admin_table_output .= " value='15'>Philippine Peso - PHP</option>
			<option "; if ($currency == '16') { $admin_table_output .= 'SELECTED'; } $admin_table_output .= " value='16'>Polish Zloty - PLN</option>
			<option "; if ($currency == '17') { $admin_table_output .= 'SELECTED'; } $admin_table_output .= " value='17'>Pound Sterling - GBP</option>
			<option "; if ($currency == '18') { $admin_table_output .= 'SELECTED'; } $admin_table_output .= " value='18'>Russian Ruble - RUB</option>
			<option "; if ($currency == '19') { $admin_table_output .= 'SELECTED'; } $admin_table_output .= " value='19'>Singapore Dollar - SGD</option>
			<option "; if ($currency == '20') { $admin_table_output .= 'SELECTED'; } $admin_table_output .= " value='20'>Swedish Krona - SEK</option>
			<option "; if ($currency == '21') { $admin_table_output .= 'SELECTED'; } $admin_table_output .= " value='21'>Swiss Franc - CHF</option>
			<option "; if ($currency == '22') { $admin_table_output .= 'SELECTED'; } $admin_table_output .= " value='22'>Taiwan New Dollar - TWD</option>
			<option "; if ($currency == '23') { $admin_table_output .= 'SELECTED'; } $admin_table_output .= " value='23'>Thai Baht - THB</option>
			<option "; if ($currency == '24') { $admin_table_output .= 'SELECTED'; } $admin_table_output .= " value='24'>Turkish Lira - TRY</option>
			<option "; if ($currency == '25') { $admin_table_output .= 'SELECTED'; } $admin_table_output .= " value='25'>U.S. Dollar - USD</option>
			</select>
	</td><td>  (Optional - will override currnecy setting on settings page, but only for this form.)</td></tr>";


	$admin_table_output .= "<tr><td>Gateway Code: </td>";
	$admin_table_output .= "<td><input type='text' name='cf7pp_gateway' value='$gateway'> </td><td> (Required to use both Gateways at the same time. Documentation <a target='_blank' href='https://wpplugin.org/documentation/paypal-stripe-gateway-code/'>here</a>)</td></tr>";



	// account settings
	$admin_table_output .= "<tr><td colspan='3'><br /><hr></td></tr>";
	
	$admin_table_output .= "<tr><td><b>Account Settings</b></td><td></td><td></td></tr>";

	$admin_table_output .= "<tr><td>PayPal Account: </td>";
	$admin_table_output .= "<td><input type='text' name='cf7pp_form_account' value='$form_account'> </td><td>  (Optional - will override PayPal account on settings page, but only for this form.)</td></tr>";

	$admin_table_output .= "<tr><td class='cf7pp_width'><b>Connection status: </b></td><td>" . cf7pp_stripe_connection_status_html($post_id) . "</td><td>(Optional - will override Stripe account on settings page, but only for this form.)</td></tr>";

	if (!empty($stripe_pub_key) && !empty($stripe_sec_key)) {
		$admin_table_output .= "<tr><td>Stripe Publishable Key: </td><td><input type='text' size=40 name='cf7pp_stripe_pub_key' value='$stripe_pub_key' disabled='disabled'> </td><td></td></tr>";
		$admin_table_output .= "<tr><td>Stripe Secret Key: </td><td><input type='text' size=40 name='cf7pp_stripe_sec_key' value='$stripe_sec_key' disabled='disabled'> </td><td></td></tr>";
	}

	$admin_table_output .= "<tr><td colspan='3'><br /><hr></td></tr>";




	// static values
	$admin_table_output .= "<br /><hr><br /></td><td></td><td></td></tr><tr><td valign='top'>";

	$admin_table_output .= "<b>Static Values</b></td><td></td><td>These values will be overwritten if you set dynamic values (linking form items).</td></tr><tr><td>";

	$admin_table_output .= "Item Price: </td><td>";
	$admin_table_output .= "<input type='text' name='cf7pp_price' value='$price'> </td><td> (Optional, if left blank customer will be able to enter their own price at checkout. Format: enter 2.99 for $2.99.)</td></tr><tr><td>";

	$admin_table_output .= "Item Quantity: </td><td>";
	$admin_table_output .= "<input type='text' name='cf7pp_quantity' value='$quantity'> </td><td> (Optional - Example: enter 2 for a quantity of 2.)</td></tr><tr><td>";

	$admin_table_output .= "Item ID / SKU: </td><td>";
	$admin_table_output .= "<input type='text' name='cf7pp_id' value='$id'> </td><td> (Optional - Example: enter 123.22 for an SKU/ID of 123.22.)</td></tr><tr><td>";

	$admin_table_output .= "Fixed Shipping: </td><td>";
	$admin_table_output .= "<input type='text' name='cf7pp_shipping' value='$shipping'> </td><td> (Optional - Example: enter 2.25 for $2.25 shipping. Setup more advanced shipping profiles for PayPal <a target='_blank' href='https://www.paypal.com/cgi-bin/customerprofileweb?cmd=_profile-shipping'>here</a>.)</td></tr><tr><td>";

	$admin_table_output .= "Item Description: </td><td>";
	$admin_table_output .= "<input type='text' name='cf7pp_name' value='$name'> </td><td> (Optional, for PayPal if left blank customer will be able to enter their own description at checkout.)</td></tr>";


	$admin_table_output = apply_filters('cf7pp_tabs_page_static_value', $admin_table_output, $post_id);


	$admin_table_output .= "<tr><td colspan='4'><br /><hr><br /></td><td></td><td></td></tr><tr><td valign='top'>";


	$admin_table_output .= "<b>Dynamic Values</b></td><td></td><td>Link form items to PayPal values.</td></tr><tr><td valign='top'>";

	$admin_table_output .= "Price Code 1: </td><td valign='top'>";
	$admin_table_output .= "<input type='text' name='cf7pp_price_menu' value='$price_menu'></td><td valign='top'> (Optional - Link a form item to price by entering item code. Example: menu-244 Documentation: <a target='_blank' href='https://wpplugin.org/documentation/link-a-dropdown-menu-to-the-price-in-paypal/'>here</a>)</td></tr><tr><td valign='top'>";

	$admin_table_output .= "Quantity Code 1: </td><td valign='top'>";
	$admin_table_output .= "<input type='text' name='cf7pp_quantity_menu' value='$quantity_menu'></td><td valign='top'> (Optional - Link a form item to quantity by entering item code. Example: menu-292  Documentation: <a target='_blank' href='https://wpplugin.org/documentation/link-a-form-item-to-the-quantity-in-paypal/'>here</a>)</td></tr><tr><td valign='top'>";

	$admin_table_output .= "Description Code 1: </td><td valign='top'>";
	$admin_table_output .= "<input type='text' name='cf7pp_desc' value='$desc'></td><td valign='top'>(Optional - Link a form item to the description by entering item code. Example: text-530 Documentation: <a target='_blank' href='https://wpplugin.org/documentation/pass-a-description-to-the-paypal-item/'>here</a>)</td></tr>";

	$admin_table_output = apply_filters('cf7pp_tabs_page_dynamic_value', $admin_table_output, $post_id);

	$admin_table_output .= "<tr class='cf7pp_dynamic_options_more'><td valign='top'>";

	$admin_table_output .= "Price Code 2: </td><td>";
	$admin_table_output .= "<input type='text' name='cf7pp_price_menu2' value='$price_menu2'></td><td valign='top'></td></tr><tr class='cf7pp_dynamic_options_more'><td valign='top'>";

	$admin_table_output .= "Quantity Code 2: </td><td>";
	$admin_table_output .= "<input type='text' name='cf7pp_quantity_menu2' value='$quantity_menu2'></td><td valign='top'></td></tr><tr class='cf7pp_dynamic_options_more'><td valign='top'>";

	$admin_table_output .= "Description Code 2: </td><td>";
	$admin_table_output .= "<input type='text' name='cf7pp_desc2' value='$desc2'></td><td valign='top'></td></tr><tr class='cf7pp_dynamic_options_more'><td valign='top'>";


	$admin_table_output .= "Price Code 3: </td><td>";
	$admin_table_output .= "<input type='text' name='cf7pp_price_menu3' value='$price_menu3'></td><td valign='top'></td></tr><tr class='cf7pp_dynamic_options_more'><td valign='top'>";

	$admin_table_output .= "Quantity Code 3: </td><td>";
	$admin_table_output .= "<input type='text' name='cf7pp_quantity_menu3' value='$quantity_menu3'></td><td valign='top'></td></tr><tr class='cf7pp_dynamic_options_more'><td valign='top'>";

	$admin_table_output .= "Description Code 3: </td><td>";
	$admin_table_output .= "<input type='text' name='cf7pp_desc3' value='$desc3'></td><td valign='top'></td></tr><tr class='cf7pp_dynamic_options_more'><td valign='top'>";


	$admin_table_output .= "Price Code 4: </td><td>";
	$admin_table_output .= "<input type='text' name='cf7pp_price_menu4' value='$price_menu4'></td><td valign='top'></td></tr><tr class='cf7pp_dynamic_options_more'><td valign='top'>";

	$admin_table_output .= "Quantity Code 4: </td><td>";
	$admin_table_output .= "<input type='text' name='cf7pp_quantity_menu4' value='$quantity_menu4'></td><td valign='top'></td></tr><tr class='cf7pp_dynamic_options_more'><td valign='top'>";

	$admin_table_output .= "Description Code 4: </td><td>";
	$admin_table_output .= "<input type='text' name='cf7pp_desc4' value='$desc4'></td><td valign='top'></td></tr><tr class='cf7pp_dynamic_options_more'><td valign='top'>";


	$admin_table_output .= "Price Code 5: </td><td>";
	$admin_table_output .= "<input type='text' name='cf7pp_price_menu5' value='$price_menu5'></td><td valign='top'></td></tr><tr class='cf7pp_dynamic_options_more'><td valign='top'>";

	$admin_table_output .= "Quantity Code 5: </td><td>";
	$admin_table_output .= "<input type='text' name='cf7pp_quantity_menu5' value='$quantity_menu5'></td><td valign='top'></td></tr><tr class='cf7pp_dynamic_options_more'><td valign='top'>";

	$admin_table_output .= "Description Code 5: </td><td>";
	$admin_table_output .= "<input type='text' name='cf7pp_desc5' value='$desc5'></td><td valign='top'></td></tr><tr class='cf7pp_dynamic_options_more'><td valign='top'>";





	$admin_table_output .= "<br /><br /></td><td></td><td></td></tr><tr class='cf7pp_dynamic_options_more'><td valign='top'>";


	$admin_table_output .= "Shipping Code: </td><td valign='top'>";
	$admin_table_output .= "<input type='text' name='cf7pp_ship' value='$ship'> </td><td valign='top'> (Optional, will override Fixed Shipping above. Link a form item to the shipping amount by entering item code. Example: text-530)</td></tr><tr><td valign='top'>";


	$admin_table_output .= "<br /><br /></td><td></td><td></td></tr><tr><td valign='top'>";

	$admin_table_output .= "Skip Redirect Code: </td><td valign='top'>";
	$admin_table_output .= "<input type='text' name='cf7pp_skip_code' value='$skip_code'> </td><td valign='top'> (Optional. Link a form item to allow the form to redirect or skip redirecting. Example: menu-117 Documentation: <a target='_blank' href='https://wpplugin.org/documentation/skip-redirect-based-on-form-code-value/'>here</a>)</td></tr><tr><td valign='top'>";


	$admin_table_output .= "<br /><br /></td><td></td><td></td></tr><tr><td valign='top'>";


	$admin_table_output .= "Item 1 - Text Fields </td></tr><tr><td valign='top'>";

	$admin_table_output .= "Text 1 Name / Code </td><td valign='top'>";
	$admin_table_output .= "<input type='text' name='cf7pp_text_menu_a_name' value='$text_menu_a_name'><input type='text' name='cf7pp_text_menu_a' value='$text_menu_a'> </td><td> (Optional - Link text or number form item to text field 1 by entering item code. Example: Color / text-530 Documentation: <a target='_blank' href='https://wpplugin.org/documentation/link-a-description-to-an-option-field/'>here</a>)</td></tr><tr><td valign='top'>";

	$admin_table_output .= "Text 2 Name / Code: </td><td valign='top'>";
	$admin_table_output .= "<input type='text' name='cf7pp_text_menu_b_name' value='$text_menu_b_name'><input type='text' name='cf7pp_text_menu_b' value='$text_menu_b'> </td><td valign='top'> (Optional - Link text or number form item to text field 2 by entering item code. Example: Email / email-100 Documentation: <a target='_blank' href='https://wpplugin.org/documentation/link-a-description-to-an-option-field/'>here</a>)</td></tr><tr class='cf7pp_dynamic_options_more'><td valign='top'>";


	$admin_table_output .= "Item 2 - Text Fields </td></tr><tr class='cf7pp_dynamic_options_more'><td valign='top'>";

	$admin_table_output .= "Text 1 Name / Code </td><td valign='top'>";
	$admin_table_output .= "<input type='text' name='cf7pp_text_menu_a_name2' value='$text_menu_a_name2'><input type='text' name='cf7pp_text_menu_a2' value='$text_menu_a2'> </td><td></td></tr><tr class='cf7pp_dynamic_options_more'><td valign='top'>";

	$admin_table_output .= "Text 2 Name / Code: </td><td valign='top'>";
	$admin_table_output .= "<input type='text' name='cf7pp_text_menu_b_name2' value='$text_menu_b_name2'><input type='text' name='cf7pp_text_menu_b2' value='$text_menu_b2'> </td><td valign='top'></td></tr><tr class='cf7pp_dynamic_options_more'><td valign='top'>";


	$admin_table_output .= "Item 3 - Text Fields </td></tr><tr class='cf7pp_dynamic_options_more'><td valign='top'>";

	$admin_table_output .= "Text 1 Name / Code </td><td valign='top'>";
	$admin_table_output .= "<input type='text' name='cf7pp_text_menu_a_name3' value='$text_menu_a_name3'><input type='text' name='cf7pp_text_menu_a3' value='$text_menu_a3'> </td><td></td></tr><tr class='cf7pp_dynamic_options_more'><td valign='top'>";

	$admin_table_output .= "Text 2 Name / Code: </td><td valign='top'>";
	$admin_table_output .= "<input type='text' name='cf7pp_text_menu_b_name3' value='$text_menu_b_name3'><input type='text' name='cf7pp_text_menu_b3' value='$text_menu_b3'> </td><td valign='top'></td></tr><tr class='cf7pp_dynamic_options_more'><td valign='top'>";


	$admin_table_output .= "Item 4 - Text Fields </td></tr><tr class='cf7pp_dynamic_options_more'><td valign='top'>";

	$admin_table_output .= "Text 1 Name / Code </td><td valign='top'>";
	$admin_table_output .= "<input type='text' name='cf7pp_text_menu_a_name4' value='$text_menu_a_name4'><input type='text' name='cf7pp_text_menu_a4' value='$text_menu_a4'> </td><td></td></tr><tr class='cf7pp_dynamic_options_more'><td valign='top'>";

	$admin_table_output .= "Text 2 Name / Code: </td><td valign='top'>";
	$admin_table_output .= "<input type='text' name='cf7pp_text_menu_b_name4' value='$text_menu_b_name4'><input type='text' name='cf7pp_text_menu_b4' value='$text_menu_b4'> </td><td valign='top'></td></tr><tr class='cf7pp_dynamic_options_more'><td valign='top'>";


	$admin_table_output .= "Item 5 - Text Fields </td></tr><tr class='cf7pp_dynamic_options_more'><td valign='top'>";

	$admin_table_output .= "Text 1 Name / Code </td><td valign='top'>";
	$admin_table_output .= "<input type='text' name='cf7pp_text_menu_a_name5' value='$text_menu_a_name5'><input type='text' name='cf7pp_text_menu_a5' value='$text_menu_a5'> </td><td></td></tr><tr class='cf7pp_dynamic_options_more'><td valign='top'>";

	$admin_table_output .= "Text 2 Name / Code: </td><td valign='top'>";
	$admin_table_output .= "<input type='text' name='cf7pp_text_menu_b_name5' value='$text_menu_b_name5'><input type='text' name='cf7pp_text_menu_b5' value='$text_menu_b5'> </td><td valign='top'></td></tr>";







	$admin_table_output .= "<tr><td colspan='3'><br /><hr></td></tr>";
	
	$admin_table_output .= "<tr><td><h2>PayPal Only Settings</h2><br /></td><td></td></tr>";
	
	
	$admin_table_output .= "<td><b>PayPal Settings</b></td></tr>";
	
	$admin_table_output .= "<tr><td>Hide Note: </td><td valign='top'>";
	$admin_table_output .= "<input type='checkbox' name='cf7pp_note' value='1' $checkednote> </td><td>  (Optional - if checked, the field on PayPal where customers can enter a custom note will be hidden.)</td></tr>";

	$admin_table_output .= "<tr><td>Credit Card Landing Page: </td><td valign='top'>";
	$admin_table_output .= "<input type='checkbox' name='cf7pp_landingpage' value='1' $landingpage> </td><td>  (Optional - if checked, PayPal will redirect to the Credit Card landing page instead of the PayPal login page. Documentation <a target='_blank' href='https://wpplugin.org/documentation/credit-card-landing-page/'>here</a>)</td></tr>";


	// url settings
	$admin_table_output .= "<tr><td colspan='3'><br /><hr></td></tr>";
	
	$admin_table_output .= "<tr><td><b>URL Settings</b></td><td></td><td></td></tr><tr><td>";

	$admin_table_output .= "Cancel URL: </td><td>";
	$admin_table_output .= "<input type='text' name='cf7pp_cancel' value='$cancel'> </td><td> (Optional - Overrides settings page value. If the customer goes to PayPal and clicks the cancel button, where do they go. <br />Example: http://www.example.com/cancel)</td></tr><tr><td>";

	$admin_table_output .= "Return URL: </td><td>";
	$admin_table_output .= "<input type='text' name='cf7pp_return' value='$return'> </td><td> (Optional - Overrides settings page value. If the customer goes to PayPal and successfully pays, where are they redirected to. <br />Example: http://www.example.com/thankyou)</td></tr><tr><td valign='top' colspan='4'>";


	$admin_table_output .= "<tr><td colspan='3'><br /><hr></td></tr>";


	$admin_table_output .= "<td><b>Customer Dynamic Values</b></td><td></td><td>Documentation <a target='_blank' href='https://wpplugin.org/documentation/link-customer-input-values/'>here</a></td></tr>";

	$admin_table_output .= "<tr><td>Address 1: </td><td>";
	$admin_table_output .= "<input type='text' name='cf7pp_address1' value='$address1'></td><td valign='top'>	(Optional - Link a form item to address1 by entering item code. Example: text-244)</td></tr><tr><td valign='top'>";

	$admin_table_output .= "Address 2: </td><td>";
	$admin_table_output .= "<input type='text' name='cf7pp_address2' value='$address2'></td><td valign='top'></td></tr><tr><td valign='top'>";

	$admin_table_output .= "City: </td><td>";
	$admin_table_output .= "<input type='text' name='cf7pp_city' value='$city'></td><td valign='top'></td></tr><tr><td valign='top'>";

	$admin_table_output .= "State: </td><td>";
	$admin_table_output .= "<input type='text' name='cf7pp_state' value='$state'></td><td valign='top'>(<a target='_blank' href='https://developer.paypal.com/docs/classic/api/state_codes/'>Use valid State Codes</a>)</td></tr><tr><td valign='top'>";

	$admin_table_output .= "Country: </td><td>";
	$admin_table_output .= "<input type='text' name='cf7pp_country' value='$country'></td><td valign='top'>(<a target='_blank' href='https://developer.paypal.com/docs/classic/api/country_codes/'>Use valid Country Codes</a>)</td></tr><tr><td valign='top'>";

	$admin_table_output .= "Zip: </td><td>";
	$admin_table_output .= "<input type='text' name='cf7pp_zip' value='$zip'></td><td valign='top'></td></tr><tr><td valign='top'>";

	$admin_table_output .= "Email: </td><td>";
	$admin_table_output .= "<input type='text' name='cf7pp_email_address' value='$email_address'></td><td valign='top'></td></tr><tr><td valign='top'>";



	$admin_table_output .= "Phone A: </td><td>";
	$admin_table_output .= "<input type='text' name='cf7pp_phonea' value='$phonea'></td><td valign='top'>(The area code for U.S. phone numbers, or the country code for phone numbers outside the U.S.)</td></tr><tr><td valign='top'>";

	$admin_table_output .= "Phone B: </td><td>";
	$admin_table_output .= "<input type='text' name='cf7pp_phoneb' value='$phoneb'></td><td valign='top'>(The three-digit prefix for U.S. phone numbers, or the entire phone number for phone numbers outside the U.S., excluding country code.)</td></tr><tr><td valign='top'>";

	$admin_table_output .= "Phone C: </td><td>";
	$admin_table_output .= "<input type='text' name='cf7pp_phonec' value='$phonec'></td><td valign='top'>(The four-digit phone number for U.S. phone numbers.)</td></tr><tr><td valign='top'>";


	$admin_table_output .= "First Name: </td><td>";
	$admin_table_output .= "<input type='text' name='cf7pp_first_name' value='$first_name'></td><td valign='top'></td></tr><tr><td valign='top'>";

	$admin_table_output .= "Last Name: </td><td>";
	$admin_table_output .= "<input type='text' name='cf7pp_last_name' value='$last_name'></td><td valign='top'></td></tr><tr><td valign='top'>";
	
	
	$admin_table_output .= "<tr><td colspan='3'><br /><hr></td></tr>";
	
	$admin_table_output .= "<tr><td><h2>Stripe Only Settings</h2><br /></td><td></td></tr>";
	
	$admin_table_output .= "<tr><td>Email Code: </td>";
	$admin_table_output .= "<td><input type='text' name='cf7pp_stripe_email' value='$stripe_email'> </td><td> (Optional. Pass email to Stripe. Link a form item. Example: text-105)</td></tr><tr><td colspan='3'>";
	
	$admin_table_output .= "<tr><td>After payment message: </td>";
	$admin_table_output .= "<td><input type='text' name='cf7pp_stripe_text' value='$stripe_text'> </td><td> (Optional - After the customer successfully pays, display a message. Link a form item. Example: text-105. Documentation <a target='_blank' href='https://wpplugin.org/documentation/stripe-after-payment-message/'>here</a>.)";
	
	$admin_table_output .= "<tr><td>Return URL: </td>";
	$admin_table_output .= "<td><input type='text' name='cf7pp_stripe_return' value='$stripe_return'> </td><td> (Optional - After the customer successfully pays, where do they go. Example: http://www.example.com/thankyou)</td></tr><tr><td colspan='3'>";
	
	$admin_table_output .= "<input type='hidden' name='cf7pp_post' value='$post_id'>";

	$admin_table_output .= "</td></tr></table>";

	echo $admin_table_output;

}






// hook into contact form 7 admin form save
add_action('wpcf7_after_save', 'cf7pp_save_contact_form');

function cf7pp_save_contact_form( $cf7 ) {
		
		$post_id = sanitize_text_field($_POST['cf7pp_post']);
		
		if (!empty($_POST['cf7pp_enable'])) {
			$enable = sanitize_text_field($_POST['cf7pp_enable']);
			update_post_meta($post_id, "_cf7pp_enable", $enable);
		} else {
			update_post_meta($post_id, "_cf7pp_enable", 0);
		}
		
		if (!empty($_POST['cf7pp_enable_stripe'])) {
			$enable_stripe = sanitize_text_field($_POST['cf7pp_enable_stripe']);
			update_post_meta($post_id, "_cf7pp_enable_stripe", $enable_stripe);
		} else {
			update_post_meta($post_id, "_cf7pp_enable_stripe", 0);
		}
		
		if (!empty($_POST['cf7pp_sandbox'])) {
			$sandbox = sanitize_text_field($_POST['cf7pp_sandbox']);
			update_post_meta($post_id, "_cf7pp_sandbox", $sandbox);
		} else {
			update_post_meta($post_id, "_cf7pp_sandbox", 0);
		}
		
		if (!empty($_POST['cf7pp_price_skip'])) {
			$skip = sanitize_text_field($_POST['cf7pp_price_skip']);
			update_post_meta($post_id, "_cf7pp_skip", $skip);
		} else {
			update_post_meta($post_id, "_cf7pp_skip", 0);
		}
		
		if (!empty($_POST['cf7pp_landingpage'])) {
			$skip = sanitize_text_field($_POST['cf7pp_landingpage']);
			update_post_meta($post_id, "_cf7pp_landingpage", $skip);
		} else {
			update_post_meta($post_id, "_cf7pp_landingpage", 0);
		}
		
		$name = sanitize_text_field($_POST['cf7pp_name']);
		update_post_meta($post_id, "_cf7pp_name", $name);
		
		$price = sanitize_text_field($_POST['cf7pp_price']);
		$price = cf7pp_format_currency($price);
		update_post_meta($post_id, "_cf7pp_price", $price);
		
		$currency = sanitize_text_field($_POST['cf7pp_currency']);
		update_post_meta($post_id, "_cf7pp_currency", $currency);
		
		$id = sanitize_text_field($_POST['cf7pp_id']);
		update_post_meta($post_id, "_cf7pp_id", $id);
		
		$email = sanitize_text_field($_POST['cf7pp_email']);
		update_post_meta($post_id, "_cf7pp_email", $email);
		
		$quantity = sanitize_text_field($_POST['cf7pp_quantity']);
		update_post_meta($post_id, "_cf7pp_quantity", $quantity);
		
		$shipping = sanitize_text_field($_POST['cf7pp_shipping']);
		update_post_meta($post_id, "_cf7pp_shipping", $shipping);
		
		$gateway = sanitize_text_field($_POST['cf7pp_gateway']);
		update_post_meta($post_id, "_cf7pp_gateway", $gateway);
		
		$ship = sanitize_text_field($_POST['cf7pp_ship']);
		update_post_meta($post_id, "_cf7pp_ship", $ship);
		
		$skip_code = sanitize_text_field($_POST['cf7pp_skip_code']);
		update_post_meta($post_id, "_cf7pp_skip_code", $skip_code);
		
		if (!empty($_POST['cf7pp_note'])) {
			$note = sanitize_text_field($_POST['cf7pp_note']);
			update_post_meta($post_id, "_cf7pp_note", $note);
		} else {
			update_post_meta($post_id, "_cf7pp_note", 0);
		}
		
		$form_account = sanitize_text_field($_POST['cf7pp_form_account']);
		update_post_meta($post_id, "_cf7pp_form_account", $form_account);
		
		$cancel = sanitize_text_field($_POST['cf7pp_cancel']);
		update_post_meta($post_id, "_cf7pp_cancel", $cancel);
		
		$return = sanitize_text_field($_POST['cf7pp_return']);
		update_post_meta($post_id, "_cf7pp_return", $return);
		
		
		$quantity_menu = sanitize_text_field($_POST['cf7pp_quantity_menu']);
		update_post_meta($post_id, "_cf7pp_quantity_menu", $quantity_menu);
		
		$quantity_menu2 = sanitize_text_field($_POST['cf7pp_quantity_menu2']);
		update_post_meta($post_id, "_cf7pp_quantity_menu2", $quantity_menu2);
		
		$quantity_menu3 = sanitize_text_field($_POST['cf7pp_quantity_menu3']);
		update_post_meta($post_id, "_cf7pp_quantity_menu3", $quantity_menu3);
		
		$quantity_menu4 = sanitize_text_field($_POST['cf7pp_quantity_menu4']);
		update_post_meta($post_id, "_cf7pp_quantity_menu4", $quantity_menu4);
		
		$quantity_menu5 = sanitize_text_field($_POST['cf7pp_quantity_menu5']);
		update_post_meta($post_id, "_cf7pp_quantity_menu5", $quantity_menu5);
		
		
		$price_menu = sanitize_text_field($_POST['cf7pp_price_menu']);
		update_post_meta($post_id, "_cf7pp_price_menu", $price_menu);
		
		$price_menu2 = sanitize_text_field($_POST['cf7pp_price_menu2']);
		update_post_meta($post_id, "_cf7pp_price_menu2", $price_menu2);
		
		$price_menu3 = sanitize_text_field($_POST['cf7pp_price_menu3']);
		update_post_meta($post_id, "_cf7pp_price_menu3", $price_menu3);
		
		$price_menu4 = sanitize_text_field($_POST['cf7pp_price_menu4']);
		update_post_meta($post_id, "_cf7pp_price_menu4", $price_menu4);
		
		$price_menu5 = sanitize_text_field($_POST['cf7pp_price_menu5']);
		update_post_meta($post_id, "_cf7pp_price_menu5", $price_menu5);
		
		
		$desc = sanitize_text_field($_POST['cf7pp_desc']);
		update_post_meta($post_id, "_cf7pp_desc", $desc);
		
		$desc2 = sanitize_text_field($_POST['cf7pp_desc2']);
		update_post_meta($post_id, "_cf7pp_desc2", $desc2);
		
		$desc3 = sanitize_text_field($_POST['cf7pp_desc3']);
		update_post_meta($post_id, "_cf7pp_desc3", $desc3);
		
		$desc4 = sanitize_text_field($_POST['cf7pp_desc4']);
		update_post_meta($post_id, "_cf7pp_desc4", $desc4);
		
		$desc5 = sanitize_text_field($_POST['cf7pp_desc5']);
		update_post_meta($post_id, "_cf7pp_desc5", $desc5);
		
		
		
		
		// 1
		$text_menu_a = sanitize_text_field($_POST['cf7pp_text_menu_a']);
		update_post_meta($post_id, "_cf7pp_text_menu_a", $text_menu_a);
		
		$text_menu_a_name = sanitize_text_field($_POST['cf7pp_text_menu_a_name']);
		update_post_meta($post_id, "_cf7pp_text_menu_a_name", $text_menu_a_name);
		
		$text_menu_b = sanitize_text_field($_POST['cf7pp_text_menu_b']);
		update_post_meta($post_id, "_cf7pp_text_menu_b", $text_menu_b);
		
		$text_menu_b_name = sanitize_text_field($_POST['cf7pp_text_menu_b_name']);
		update_post_meta($post_id, "_cf7pp_text_menu_b_name", $text_menu_b_name);
		
		// 2
		$text_menu_a2 = sanitize_text_field($_POST['cf7pp_text_menu_a2']);
		update_post_meta($post_id, "_cf7pp_text_menu_a2", $text_menu_a2);
		
		$text_menu_a_name2 = sanitize_text_field($_POST['cf7pp_text_menu_a_name2']);
		update_post_meta($post_id, "_cf7pp_text_menu_a_name2", $text_menu_a_name2);
		
		$text_menu_b2 = sanitize_text_field($_POST['cf7pp_text_menu_b2']);
		update_post_meta($post_id, "_cf7pp_text_menu_b2", $text_menu_b2);
		
		$text_menu_b_name2 = sanitize_text_field($_POST['cf7pp_text_menu_b_name2']);
		update_post_meta($post_id, "_cf7pp_text_menu_b_name2", $text_menu_b_name2);
		
		// 3
		$text_menu_a3 = sanitize_text_field($_POST['cf7pp_text_menu_a3']);
		update_post_meta($post_id, "_cf7pp_text_menu_a3", $text_menu_a3);
		
		$text_menu_a_name3 = sanitize_text_field($_POST['cf7pp_text_menu_a_name3']);
		update_post_meta($post_id, "_cf7pp_text_menu_a_name3", $text_menu_a_name3);
		
		$text_menu_b3 = sanitize_text_field($_POST['cf7pp_text_menu_b3']);
		update_post_meta($post_id, "_cf7pp_text_menu_b3", $text_menu_b3);
		
		$text_menu_b_name3 = sanitize_text_field($_POST['cf7pp_text_menu_b_name3']);
		update_post_meta($post_id, "_cf7pp_text_menu_b_name3", $text_menu_b_name3);
		
		// 4
		$text_menu_a4 = sanitize_text_field($_POST['cf7pp_text_menu_a4']);
		update_post_meta($post_id, "_cf7pp_text_menu_a4", $text_menu_a4);
		
		$text_menu_a_name4 = sanitize_text_field($_POST['cf7pp_text_menu_a_name4']);
		update_post_meta($post_id, "_cf7pp_text_menu_a_name4", $text_menu_a_name4);
		
		$text_menu_b4 = sanitize_text_field($_POST['cf7pp_text_menu_b4']);
		update_post_meta($post_id, "_cf7pp_text_menu_b4", $text_menu_b4);
		
		$text_menu_b_name4 = sanitize_text_field($_POST['cf7pp_text_menu_b_name4']);
		update_post_meta($post_id, "_cf7pp_text_menu_b_name4", $text_menu_b_name4);
		
		// 5
		$text_menu_a5 = sanitize_text_field($_POST['cf7pp_text_menu_a5']);
		update_post_meta($post_id, "_cf7pp_text_menu_a5", $text_menu_a5);
		
		$text_menu_a_name5 = sanitize_text_field($_POST['cf7pp_text_menu_a_name5']);
		update_post_meta($post_id, "_cf7pp_text_menu_a_name5", $text_menu_a_name5);
		
		$text_menu_b5 = sanitize_text_field($_POST['cf7pp_text_menu_b5']);
		update_post_meta($post_id, "_cf7pp_text_menu_b5", $text_menu_b5);
		
		$text_menu_b_name5 = sanitize_text_field($_POST['cf7pp_text_menu_b_name5']);
		update_post_meta($post_id, "_cf7pp_text_menu_b_name5", $text_menu_b_name5);
		
		
		
		// customer fields
		$address1 = sanitize_text_field($_POST['cf7pp_address1']);
		update_post_meta($post_id, "_cf7pp_address1", $address1);
		
		$address2 = sanitize_text_field($_POST['cf7pp_address2']);
		update_post_meta($post_id, "_cf7pp_address2", $address2);
		
		$city = sanitize_text_field($_POST['cf7pp_city']);
		update_post_meta($post_id, "_cf7pp_city", $city);
		
		$state = sanitize_text_field($_POST['cf7pp_state']);
		update_post_meta($post_id, "_cf7pp_state", $state);
		
		$country = sanitize_text_field($_POST['cf7pp_country']);
		update_post_meta($post_id, "_cf7pp_country", $country);
		
		$zip = sanitize_text_field($_POST['cf7pp_zip']);
		update_post_meta($post_id, "_cf7pp_zip", $zip);
		
		$email_address = sanitize_text_field($_POST['cf7pp_email_address']);
		update_post_meta($post_id, "_cf7pp_email_address", $email_address);
		
		$phonea = sanitize_text_field($_POST['cf7pp_phonea']);
		update_post_meta($post_id, "_cf7pp_phonea", $phonea);
		
		$phoneb = sanitize_text_field($_POST['cf7pp_phoneb']);
		update_post_meta($post_id, "_cf7pp_phoneb", $phoneb);
		
		$phonec = sanitize_text_field($_POST['cf7pp_phonec']);
		update_post_meta($post_id, "_cf7pp_phonec", $phonec);
		
		$first_name = sanitize_text_field($_POST['cf7pp_first_name']);
		update_post_meta($post_id, "_cf7pp_first_name", $first_name);
		
		$last_name = sanitize_text_field($_POST['cf7pp_last_name']);
		update_post_meta($post_id, "_cf7pp_last_name", $last_name);
		
		// stripe only settings
		$stripe_email = sanitize_text_field($_POST['cf7pp_stripe_email']);
		update_post_meta($post_id, "_cf7pp_stripe_email", $stripe_email);
		
		$stripe_text = sanitize_text_field($_POST['cf7pp_stripe_text']);
		update_post_meta($post_id, "_cf7pp_stripe_text", $stripe_text);
		
		$stripe_return = sanitize_text_field($_POST['cf7pp_stripe_return']);
		update_post_meta($post_id, "_cf7pp_stripe_return", $stripe_return);
		
		do_action('cf7pp_tabs_page_save_values',$post_id);
		
		
}