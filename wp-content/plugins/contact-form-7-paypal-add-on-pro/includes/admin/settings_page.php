<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


// admin table
function cf7pp_admin_table() {

	// get options
	$options = get_option('cf7pp_options');

	if ( !current_user_can( "manage_options" ) )  {
	wp_die( __( "You do not have sufficient permissions to access this page." ) );
	}


	// save and update options
	if (isset($_POST['update'])) {

		$options['currency'] = 					sanitize_text_field($_POST['currency']);
		if (empty($options['currency'])) { 		$options['currency'] = ''; }

		$options['language'] = 					sanitize_text_field($_POST['language']);
		if (empty($options['language'])) { 		$options['language'] = ''; }

		$options['liveaccount'] = 				sanitize_text_field($_POST['liveaccount']);
		if (empty($options['liveaccount'])) { 	$options['liveaccount'] = ''; }

		$options['sandboxaccount'] = 			sanitize_text_field($_POST['sandboxaccount']);
		if (empty($options['sandboxaccount'])) { $options['sandboxaccount'] = ''; }

		$options['mode'] = 						sanitize_text_field($_POST['mode']);
		if (empty($options['mode'])) { 			$options['mode'] = '2'; }
		
		$options['paymentaction'] = 			sanitize_text_field($_POST['paymentaction']);
		if (empty($options['paymentaction'])) { $options['paymentaction'] = '1'; }

		$options['mode_stripe'] = 				sanitize_text_field($_POST['mode_stripe']);
		if (empty($options['mode_stripe'])) { 	$options['mode_stripe'] = '2'; }

		$options['cancel'] = 					sanitize_text_field($_POST['cancel']);
		if (empty($options['cancel'])) { 		$options['cancel'] = ''; }

		$options['return'] = 					sanitize_text_field($_POST['return']);
		if (empty($options['return'])) { 		$options['return'] = ''; }

		$options['redirect'] = 					sanitize_text_field($_POST['redirect']);
		if (empty($options['redirect'])) { 		$options['redirect'] = '1'; }
		
		$options['session'] = 					sanitize_text_field($_POST['session']);
		if (empty($options['session'])) { 		$options['session'] = '1'; }
		
		$options['skip_email'] = 				sanitize_text_field($_POST['skip_email']);
		if (empty($options['skip_email'])) { 	$options['skip_email'] = '1'; }

		$options['success'] = 					sanitize_text_field($_POST['success']);
		if (empty($options['success'])) { 		$options['success'] = 'Payment Successful'; }
		
		$options['failed'] = 					sanitize_text_field($_POST['failed']);
		if (empty($options['failed'])) { 		$options['failed'] = 'Payment Failed'; }
		
		$options['address'] = 					sanitize_text_field($_POST['address']);
		
		$options['ipn_url'] = 					sanitize_text_field($_POST['ipn_url']);
		if (empty($options['ipn_url'])) { 		$options['ipn_url'] = ''; }
		
		$options['stripe_return'] = 			sanitize_text_field($_POST['stripe_return']);
		if (empty($options['stripe_return'])) { $options['stripe_return'] = ''; }
		
		$options['validation'] = 				sanitize_text_field($_POST['validation']);
		
		$options_old = $options;
		
		array_merge($options, $options_old);
		
		$options = apply_filters('cf7pp_settings_page_save_values',$options);
		
		update_option("cf7pp_options", $options);
		
		echo "<br /><div class='updated'><p><strong>"; _e("Settings Updated."); echo "</strong></p></div>";
		
	}























	// get options
	$options = get_option('cf7pp_options');

	if (empty($options['currency'])) { 				$options['currency'] = ''; }
	if (empty($options['language'])) { 				$options['language'] = ''; }
	if (empty($options['liveaccount'])) { 			$options['liveaccount'] = ''; }
	if (empty($options['sandboxaccount'])) { 		$options['sandboxaccount'] = ''; }
	if (empty($options['mode'])) { 					$options['mode'] = '2'; }
	if (empty($options['mode_stripe'])) { 			$options['mode_stripe'] = '2'; }
	if (empty($options['cancel'])) { 				$options['cancel'] = ''; }
	if (empty($options['return'])) { 				$options['return'] = ''; }
	if (empty($options['redirect'])) { 				$options['redirect'] = '1'; }
	if (empty($options['session'])) { 				$options['session'] = '1'; }
	if (empty($options['skip_email'])) { 			$options['skip_email'] = '1'; }
	if (empty($options['success'])) { 				$options['success'] = 'Payment Successful'; }
	if (empty($options['failed'])) { 				$options['failed'] = 'Payment Failed'; }
	$options['tax'] = '';
	$options['tax_rate'] = '';
	if (!isset($options['address'])) { 				$options['address'] = '1'; }
	if (empty($options['ipn_url'])) { 				$options['ipn_url'] = ''; }
	if (!isset($options['validation'])) { 			$options['validation'] = ''; }
	if (!isset($options['paymentaction'])) { 		$options['paymentaction'] = '1'; }
	if (empty($options['stripe_return'])) { 		$options['stripe_return'] = ''; }

	$siteurl = get_site_url();

	if (isset($_POST['hidden_tab_value'])) {
		$active_tab =  $_POST['hidden_tab_value'];
	} else {
		$active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : '1';
	}

	



$settings_table_output = "";
$settings_table_output .= "<form method='post'>";

	$settings_table_output .= "<table width='70%'><tr><td>";
	$settings_table_output .= "<div class='wrap'><h2>Contact Form 7 - PayPal & Stripe Pro Settings</h2></div><br /></td><td><br />";
	$settings_table_output .= "<input type='submit' name='btn2' class='button-primary' style='font-size: 17px;line-height: 28px;height: 32px;float: right;' value='Save Settings'>";
	$settings_table_output .= "</td></tr></table>";



	$settings_table_output .= "<table width='100%'><tr><td width='70%' valign='top'>";

		$settings_table_output .= "<h2 class='nav-tab-wrapper'>";
			$settings_table_output .= "<a onclick=\"closetabs('1,2,3,4,5,6');newtab('1');\" href='#' id='id1' class=\"nav-tab "; if ($active_tab == '1') { $settings_table_output .= 'nav-tab-active'; } else { ''; } $settings_table_output .= " \">Getting Started</a>";
			$settings_table_output .= "<a onclick=\"closetabs('1,2,3,4,5,6');newtab('3');\" href='#' id='id3' class=\"nav-tab "; if ($active_tab == '3') { $settings_table_output .= 'nav-tab-active'; } else { ''; } $settings_table_output .= " \">Language & Currency</a>";
			$settings_table_output .= "<a onclick=\"closetabs('1,2,3,4,5,6');newtab('4');\" href='#' id='id4' class=\"nav-tab "; if ($active_tab == '4') { $settings_table_output .= 'nav-tab-active'; } else { ''; } $settings_table_output .= " \">PayPal</a>";
			$settings_table_output .= "<a onclick=\"closetabs('1,2,3,4,5,6');newtab('5');\" href='#' id='id5' class=\"nav-tab "; if ($active_tab == '5') { $settings_table_output .= 'nav-tab-active'; } else { ''; } $settings_table_output .= " \">Stripe</a>";
			$settings_table_output .= "<a onclick=\"closetabs('1,2,3,4,5,6');newtab('2');\" href='#' id='id2' class=\"nav-tab "; if ($active_tab == '2') { $settings_table_output .= 'nav-tab-active'; } else { ''; } $settings_table_output .= " \">Tax</a>";
			$settings_table_output .= "<a onclick=\"closetabs('1,2,3,4,5,6');newtab('6');\" href='#' id='id6' class=\"nav-tab "; if ($active_tab == '6') { $settings_table_output .= 'nav-tab-active'; } else { ''; } $settings_table_output .= " \">Other</a>";
		$settings_table_output .= "</h2>";
		$settings_table_output .= "<br />";
		
	
	$settings_table_output .= "</td><td colspan='3'></td></tr><tr><td valign='top'>";



	$settings_table_output .= "<div id='1' style='display:none;border: 1px solid #CCCCCC; "; if ($active_tab == '1') { $settings_table_output .= 'display:block;'; } $settings_table_output .= "'>";
		$settings_table_output .= "<div style='background-color:#E4E4E4;padding:8px;color:#000;font-size:15px;color:#464646;font-weight: 700;border-bottom: 1px solid #CCCCCC;'>";
			$settings_table_output .= "&nbsp; Getting Started";
		$settings_table_output .= "</div>";
		$settings_table_output .= "<div style='background-color:#fff;padding:8px;'>
			
			This plugin allows you to accept payments through your Contact Form 7 forms.
			
			<br /><br />
			
			On this page, you can setup your general PayPal & Stripe settings which will be used for all of your <a href='admin.php?page=wpcf7'>Contact Form 7 forms</a>.
			
			<br /><br />
			
			When you go to your list of contact forms, make a new form or edit an existing form, you will see a new tab called 'PayPal & Stripe'. Here you can
			set individual settings for that specific contact form.
			
			<br /><br />
			
			Once you have PayPal or Stripe enabled on a form, you will receive an email as soon as the customer submits the form. You can view the payment status on the <a href='edit.php?post_type=cf7pp_payments'>PayPal & Stripe Payments page</a>.
			
			<br /><br />
			
			You can view documentation for this plugin <a target='_blank' href='https://wpplugin.org/knowledgebase_category/contact-form-7/'>here</a>.
			
			<br /><br />
			
			If you need support, please post your question <a target='_blank' href='https://wpplugin.org/contact/support-question/#form'>here</a>.
			
			<br />";
			
		$settings_table_output .= "</div>";
	$settings_table_output .= "</div>";





	


	$settings_table_output .= "<div id='3' style='display:none;border: 1px solid #CCCCCC; "; if ($active_tab == '3') { $settings_table_output .= 'display:block;'; } $settings_table_output .= "'>";
		$settings_table_output .= "<div style='background-color:#E4E4E4;padding:8px;color:#000;font-size:15px;color:#464646;font-weight: 700;border-bottom: 1px solid #CCCCCC;'>";
			$settings_table_output .= "&nbsp; Language & Currency";
		$settings_table_output .= "</div>";
		$settings_table_output .= "<div style='background-color:#fff;padding:8px;'>";

			$settings_table_output .= "<table>";

				$settings_table_output .= "<tr><td class='cf7pp_width'>";
					$settings_table_output .= "<b>Language:</b>";
				$settings_table_output .= "</td><td>";
					$settings_table_output .= "<select name='language'>";
					$settings_table_output .= "<option "; if ($options['language'] == "1") {  $settings_table_output .= "SELECTED"; } $settings_table_output .= " value='1'>Danish</option>";
					$settings_table_output .= "<option "; if ($options['language'] == "2") {  $settings_table_output .= "SELECTED"; } $settings_table_output .= " value='2'>Dutch</option>";
					$settings_table_output .= "<option "; if ($options['language'] == "3") {  $settings_table_output .= "SELECTED"; } $settings_table_output .= " value='3'>English</option>";
					$settings_table_output .= "<option "; if ($options['language'] == "20") { $settings_table_output .= "SELECTED"; } $settings_table_output .= " value='20'>English - UK</option>";
					$settings_table_output .= "<option "; if ($options['language'] == "4") {  $settings_table_output .= "SELECTED"; } $settings_table_output .= " value='4'>French</option>";
					$settings_table_output .= "<option "; if ($options['language'] == "5") {  $settings_table_output .= "SELECTED"; } $settings_table_output .= " value='5'>German</option>";
					$settings_table_output .= "<option "; if ($options['language'] == "6") {  $settings_table_output .= "SELECTED"; } $settings_table_output .= " value='6'>Hebrew</option>";
					$settings_table_output .= "<option "; if ($options['language'] == "7") {  $settings_table_output .= "SELECTED"; } $settings_table_output .= " value='7'>Italian</option>";
					$settings_table_output .= "<option "; if ($options['language'] == "8") {  $settings_table_output .= "SELECTED"; } $settings_table_output .= " value='8'>Japanese</option>";
					$settings_table_output .= "<option "; if ($options['language'] == "9") {  $settings_table_output .= "SELECTED"; } $settings_table_output .= " value='9'>Norwgian</option>";
					$settings_table_output .= "<option "; if ($options['language'] == "10") { $settings_table_output .= "SELECTED"; } $settings_table_output .= " value='10'>Polish</option>";
					$settings_table_output .= "<option "; if ($options['language'] == "11") { $settings_table_output .= "SELECTED"; } $settings_table_output .= " value='11'>Portuguese</option>";
					$settings_table_output .= "<option "; if ($options['language'] == "12") { $settings_table_output .= "SELECTED"; } $settings_table_output .= " value='12'>Russian</option>";
					$settings_table_output .= "<option "; if ($options['language'] == "13") { $settings_table_output .= "SELECTED"; } $settings_table_output .= " value='13'>Spanish</option>";
					$settings_table_output .= "<option "; if ($options['language'] == "14") { $settings_table_output .= "SELECTED"; } $settings_table_output .= " value='14'>Swedish</option>";
					$settings_table_output .= "<option "; if ($options['language'] == "15") { $settings_table_output .= "SELECTED"; } $settings_table_output .= " value='15'>Simplified Chinese -China only</option>";
					$settings_table_output .= "<option "; if ($options['language'] == "16") { $settings_table_output .= "SELECTED"; } $settings_table_output .= " value='16'>Traditional Chinese - Hong Kong only</option>";
					$settings_table_output .= "<option "; if ($options['language'] == "17") { $settings_table_output .= "SELECTED"; } $settings_table_output .= " value='17'>Traditional Chinese - Taiwan only</option>";
					$settings_table_output .= "<option "; if ($options['language'] == "18") { $settings_table_output .= "SELECTED"; } $settings_table_output .= " value='18'>Turkish</option>";
					$settings_table_output .= "<option "; if ($options['language'] == "19") { $settings_table_output .= "SELECTED"; } $settings_table_output .= " value='19'>Thai</option>";
					$settings_table_output .= "</select>";
			$settings_table_output .= "</td></tr>";

				$settings_table_output .= "<tr><td>";
				$settings_table_output .= "</td></tr>";

				$settings_table_output .= "<tr><td class='cf7pp_width'>";
				$settings_table_output .= "<b>Currency:</b></td><td>";
				$settings_table_output .= "<select name='currency'>";
				$settings_table_output .= "<option "; if ($options['currency'] == "1") { $settings_table_output .= "SELECTED"; } $settings_table_output .= " value='1'>Australian Dollar - AUD</option>";
				$settings_table_output .= "<option "; if ($options['currency'] == "2") { $settings_table_output .= "SELECTED"; } $settings_table_output .= " value='2'>Brazilian Real - BRL</option>";
				$settings_table_output .= "<option "; if ($options['currency'] == "3") { $settings_table_output .= "SELECTED"; } $settings_table_output .= " value='3'>Canadian Dollar - CAD</option>";
				$settings_table_output .= "<option "; if ($options['currency'] == "4") { $settings_table_output .= "SELECTED"; } $settings_table_output .= " value='4'>Czech Koruna - CZK</option>";
				$settings_table_output .= "<option "; if ($options['currency'] == "5") { $settings_table_output .= "SELECTED"; } $settings_table_output .= " value='5'>Danish Krone - DKK</option>";
				$settings_table_output .= "<option "; if ($options['currency'] == "6") { $settings_table_output .= "SELECTED"; } $settings_table_output .= " value='6'>Euro - EUR</option>";
				$settings_table_output .= "<option "; if ($options['currency'] == "7") { $settings_table_output .= "SELECTED"; } $settings_table_output .= " value='7'>Hong Kong Dollar - HKD</option>";
				$settings_table_output .= "<option "; if ($options['currency'] == "8") { $settings_table_output .= "SELECTED"; } $settings_table_output .= " value='8'>Hungarian Forint - HUF</option>";
				$settings_table_output .= "<option "; if ($options['currency'] == "9") { $settings_table_output .= "SELECTED"; } $settings_table_output .= " value='9'>Israeli New Sheqel - ILS</option>";
				$settings_table_output .= "<option "; if ($options['currency'] == "10") { $settings_table_output .= "SELECTED"; } $settings_table_output .= " value='10'>Japanese Yen - JPY</option>";
				$settings_table_output .= "<option "; if ($options['currency'] == "11") { $settings_table_output .= "SELECTED"; } $settings_table_output .= " value='11'>Malaysian Ringgit - MYR</option>";
				$settings_table_output .= "<option "; if ($options['currency'] == "12") { $settings_table_output .= "SELECTED"; } $settings_table_output .= " value='12'>Mexican Peso - MXN</option>";
				$settings_table_output .= "<option "; if ($options['currency'] == "13") { $settings_table_output .= "SELECTED"; } $settings_table_output .= " value='13'>Norwegian Krone - NOK</option>";
				$settings_table_output .= "<option "; if ($options['currency'] == "14") { $settings_table_output .= "SELECTED"; } $settings_table_output .= " value='14'>New Zealand Dollar - NZD</option>";
				$settings_table_output .= "<option "; if ($options['currency'] == "15") { $settings_table_output .= "SELECTED"; } $settings_table_output .= " value='15'>Philippine Peso - PHP</option>";
				$settings_table_output .= "<option "; if ($options['currency'] == "16") { $settings_table_output .= "SELECTED"; } $settings_table_output .= " value='16'>Polish Zloty - PLN</option>";
				$settings_table_output .= "<option "; if ($options['currency'] == "17") { $settings_table_output .= "SELECTED"; } $settings_table_output .= " value='17'>Pound Sterling - GBP</option>";
				$settings_table_output .= "<option "; if ($options['currency'] == "18") { $settings_table_output .= "SELECTED"; } $settings_table_output .= " value='18'>Russian Ruble - RUB</option>";
				$settings_table_output .= "<option "; if ($options['currency'] == "19") { $settings_table_output .= "SELECTED"; } $settings_table_output .= " value='19'>Singapore Dollar - SGD</option>";
				$settings_table_output .= "<option "; if ($options['currency'] == "20") { $settings_table_output .= "SELECTED"; } $settings_table_output .= " value='20'>Swedish Krona - SEK</option>";
				$settings_table_output .= "<option "; if ($options['currency'] == "21") { $settings_table_output .= "SELECTED"; } $settings_table_output .= " value='21'>Swiss Franc - CHF</option>";
				$settings_table_output .= "<option "; if ($options['currency'] == "22") { $settings_table_output .= "SELECTED"; } $settings_table_output .= " value='22'>Taiwan New Dollar - TWD</option>";
				$settings_table_output .= "<option "; if ($options['currency'] == "23") { $settings_table_output .= "SELECTED"; } $settings_table_output .= " value='23'>Thai Baht - THB</option>";
				$settings_table_output .= "<option "; if ($options['currency'] == "24") { $settings_table_output .= "SELECTED"; } $settings_table_output .= " value='24'>Turkish Lira - TRY</option>";
				$settings_table_output .= "<option "; if ($options['currency'] == "25") { $settings_table_output .= "SELECTED"; } $settings_table_output .= " value='25'>U.S. Dollar - USD</option>";
				$settings_table_output .= "</select></td></tr>";

			$settings_table_output .= "</table>";

		$settings_table_output .= "</div>";
	$settings_table_output .= "</div>";




	$settings_table_output .= "<div id='4' style='display:none;border: 1px solid #CCCCCC; "; if ($active_tab == '4') { $settings_table_output .= 'display:block;'; } $settings_table_output .= "'>";
		$settings_table_output .= "<div style='background-color:#E4E4E4;padding:8px;color:#000;font-size:15px;color:#464646;font-weight: 700;border-bottom: 1px solid #CCCCCC;'>";
		$settings_table_output .= "&nbsp; PayPal Account";
		$settings_table_output .= "</div>";
		$settings_table_output .= "<div style='background-color:#fff;padding:8px;'>

			<table width='100%'>

				<tr><td class='cf7pp_width'>
				<b>Live Account: </b></td><td><input type='text' size=40 name='liveaccount' value='"; $settings_table_output .= $options['liveaccount']; $settings_table_output .= "'> Required to use PayPal
				</td></tr>

				<tr><td class='cf7pp_width'></td><td>
				<br />Enter a valid Merchant account ID (strongly recommend) or PayPal account email address. All payments will go to this account.
				<br /><br />You can find your Merchant account ID in your PayPal account under Profile -> My business info -> Merchant account ID

				<br /><br />If you don't have a PayPal account, you can sign up for free at <a target='_blank' href='https://paypal.com'>PayPal</a>. <br /><br />
				</td></tr>

				<tr><td class='cf7pp_width'>
				<b>Sandbox Account: </b></td><td><input type='text' size=40 name='sandboxaccount' value='"; $settings_table_output .= $options['sandboxaccount']; $settings_table_output .= "'> Optional
				</td></tr>

				<tr><td class='cf7pp_width'></td><td>
				Enter a valid sandbox PayPal account email address. A Sandbox account is a PayPal accont with fake money used for testing. This is useful to make sure your PayPal account and settings are working properly being going live.
				<br /><br />To create a Sandbox account, you first need a Developer Account. You can sign up for free at the <a target='_blank' href='https://www.paypal.com/webapps/merchantboarding/webflow/unifiedflow?execution=e1s2'>PayPal Developer</a> site. <br /><br />

				Once you have made an account, create a Sandbox Business and Personal Account <a target='_blank' href='https://developer.paypal.com/webapps/developer/applications/accounts'>here</a>. Enter the Business acount email on this page and use the Personal account username and password to buy something on your site as a customer.
				<br /><br />
				</td></tr>

				<tr><td class='cf7pp_width'>
				<b>Sandbox Mode:</b></td><td>";
				$settings_table_output .= "<input "; if ($options['mode'] == "1") { $settings_table_output .= "checked='checked'"; } $settings_table_output .= " type='radio' name='mode' value='1'>On (Sandbox mode) ";
				$settings_table_output .= "<input "; if ($options['mode'] == "2") { $settings_table_output .= "checked='checked'"; } $settings_table_output .= " type='radio' name='mode' value='2'>Off (Live mode) ";
				$settings_table_output .= "</td></tr>
				
				<tr><td>
				<br />
				</td></tr>
				
				<tr><td class='cf7pp_width'><b>IPN URL: </b></td><td>
				
				<input type='text' name='ipn_url' value='"; $settings_table_output .= $options['ipn_url']; $settings_table_output .= "'> Optional <br />
				This setting is useful if you have WordPress installed in a different directory and you have a contact form set to send the email 'after payment is successful'. PayPal may send the payment notification to the wrong URL. To fix this problem enter your direct URL to your WordPress install. For example, if your WordPress is installed in a folder called 'wp' then the URL would be: $siteurl/wp
				
				</td></tr>
				
				<tr><td>
				<br />
				</td></tr>
				
				<tr><td class='cf7pp_width'><b>IPN Validation: </b></td><td>";
				
				$settings_table_output .= "<select name='validation' id='validation'>";
					$settings_table_output .= "<option value='1' "; if ($options['validation'] == "1") { $settings_table_output .= "SELECTED"; } $settings_table_output .= ">Run Validation (Default)</option>";
					$settings_table_output .= "<option value='0' "; if ($options['validation'] == "0") { $settings_table_output .= "SELECTED"; } $settings_table_output .= ">Skip Validation</option>";
				$settings_table_output .= "</select> Optional <br /> If email are not getting sent after payment, then select 'Skip Validation'.";
				
				$settings_table_output .= "</td></tr>
				
				<tr><td>
				<br />
				</td></tr>
				
				<tr><td class='cf7pp_width'>
				<b>Payment Action:</b></td><td>";
				$settings_table_output .= "<input "; if ($options['paymentaction'] == "1") { $settings_table_output .= "checked='checked'"; } $settings_table_output .= " type='radio' name='paymentaction' value='1'>Sale (Default) ";
				$settings_table_output .= "<input "; if ($options['paymentaction'] == "2") { $settings_table_output .= "checked='checked'"; } $settings_table_output .= " type='radio' name='paymentaction' value='2'>Authorize (Learn more <a target='_blank' href='https://developer.paypal.com/docs/classic/paypal-payments-standard/integration-guide/authcapture/'>here</a>)";
				$settings_table_output .= "</td></tr>
				
			</table>

		</div>
	</div>";




	$settings_table_output .= "<div id='5' style='display:none;border: 1px solid #CCCCCC; "; if ($active_tab == '5') { $settings_table_output .= 'display:block;'; } $settings_table_output .= "'>";
		$settings_table_output .= "<div style='background-color:#E4E4E4;padding:8px;color:#000;font-size:15px;color:#464646;font-weight: 700;border-bottom: 1px solid #CCCCCC;'>";
		$settings_table_output .= "&nbsp; Stripe Account";
		$settings_table_output .= "</div>";
		$settings_table_output .= "<div style='background-color:#fff;padding:8px;'>

			<table width='100%'>
				<tr><td class='cf7pp_width'><b>Connection status: </b></td><td>" . cf7pp_stripe_connection_status_html() . "</td></tr>
				<tr><td colspan='2'><br /></td></tr>";
		
				if ( !empty($options['pub_key_live']) && !empty($options['sec_key_live']) ) {
				$settings_table_output .= "<tr><td class='cf7pp_width'><b>Live Publishable Key: </b></td><td><input type='text' size=40 name='pub_key_live' value='" . $options['pub_key_live'] . "' disabled='disabled'></td></tr>
                	<tr><td class='cf7pp_width'><b>Live Secret Key: </b></td><td><input type='text' size=40 name='sec_key_live' value='" . $options['sec_key_live'] . "' disabled='disabled'></td></tr>
                	<tr><td colspan='2'><br /></td></tr>";
                }

				if ( !empty($options['pub_key_test']) && !empty($options['sec_key_test']) ) {
				$settings_table_output .= "<tr><td class='cf7pp_width'><b>Test Publishable Key: </b></td><td><input type='text' size=40 name='pub_key_test' value='" . $options['pub_key_test'] . "' disabled='disabled'></td></tr>
                	<tr><td class='cf7pp_width'><b>Test Secret Key: </b></td><td><input type='text' size=40 name='sec_key_test' value='" . $options['sec_key_test'] . "' disabled='disabled'></td></tr>
                	<tr><td colspan='2'><br /></td></tr>";
				}
				
				
		$settings_table_output .= "<tr><td class='cf7pp_width'><b>Sandbox Mode:</b></td><td>";

				$settings_table_output .= "<input "; if ($options['mode_stripe'] == "1") { $settings_table_output .= "checked='checked'"; } $settings_table_output .= " type='radio' name='mode_stripe' value='1'>On (Sandbox mode) ";
				$settings_table_output .= "<input "; if ($options['mode_stripe'] == "2") { $settings_table_output .= "checked='checked'"; } $settings_table_output .= " type='radio' name='mode_stripe' value='2'>Off (Live mode) </td></tr>";


				$settings_table_output .= "<tr><td>";
				$settings_table_output .= "<br />";
				$settings_table_output .= "</td></tr>";

				$settings_table_output .= "<tr><td class='cf7pp_width'><b>Default Text: </b></td><td></td></tr>";
				$settings_table_output .= "<tr><td class='cf7pp_width'><b>Payment Successful: </b></td><td><input type='text' size='40' name='success' value='"; $settings_table_output .= $options['success']; $settings_table_output .= "'></td></tr>";
				$settings_table_output .= "<tr><td class='cf7pp_width'><b>Payment Failed: </b></td><td><input type='text' size='40' name='failed' value='"; $settings_table_output .= $options['failed']; $settings_table_output .= "'></td></tr>";
				
				
				$settings_table_output = apply_filters('cf7pp_settings_page_stripe_default_text', $settings_table_output,$options);
				
				
			$settings_table_output .= "</table>";
			
		$settings_table_output .= "</div>";
	$settings_table_output .= "</div>";
	
	
	
	
	
	$settings_table_output .= "<div id='2' style='display:none;border: 1px solid #CCCCCC; "; if ($active_tab == '2') { $settings_table_output .= 'display:block;'; } $settings_table_output .= "'>";
		$settings_table_output .= "<div style='background-color:#E4E4E4;padding:8px;color:#000;font-size:15px;color:#464646;font-weight: 700;border-bottom: 1px solid #CCCCCC;'>";
			$settings_table_output .= "&nbsp; Tax";
		$settings_table_output .= "</div>";
		$settings_table_output .= "<div style='background-color:#fff;padding:8px;'>";
			
			$settings_table_output .= "<table style='width: 100%;'>
				
				<tr><td colspan='2'>
				Use these links to create tax profile on PayPal and / or Stripe:
				</td></tr>
				
				<tr><td valign='top'><b>PayPal: </td><td><a target='_blank' href='https://www.paypal.com/cgi-bin/customerprofileweb?cmd=_profile-sales-tax'>Tax Settings</a></td></tr>
				<tr><td valign='top'><b>Stripe: </td><td><a target='_blank' href='https://dashboard.stripe.com/tax-rates'>Tax Settings</a></td></tr>
				
				
			</table>
			
		</div>
	</div>";


	$settings_table_output .= "<div id='6' style='display:none;border: 1px solid #CCCCCC; "; if ($active_tab == '6') { $settings_table_output .= 'display:block;'; } else { ''; } $settings_table_output .= "'>";
		$settings_table_output .= "<div style='background-color:#E4E4E4;padding:8px;color:#000;font-size:15px;color:#464646;font-weight: 700;border-bottom: 1px solid #CCCCCC;'>";
			$settings_table_output .= "&nbsp; Other Settings";
		$settings_table_output .= "</div>";
		$settings_table_output .= "<div style='background-color:#fff;padding:8px;'>";
			
			$settings_table_output .= "<table style='width: 100%;'>
				
				<tr><td class='cf7pp_width'><b>PayPal Cancel URL: </b></td><td><input type='text' name='cancel' value='"; $settings_table_output .= $options['cancel']; $settings_table_output .= "'> Optional <br /></td></tr>
				<tr><td class='cf7pp_width'></td><td>If the customer goes to PayPal and clicks the cancel button, where do they go. Example: http://example.com/cancel. Max length: 1,024. </td></tr>
				
				<tr><td>
				<br />
				</td></tr>
				
				<tr><td class='cf7pp_width'><b>PayPal Return URL: </b></td><td><input type='text' name='return' value='"; $settings_table_output .= $options['return']; $settings_table_output .= "'> Optional <br /></td></tr>
				<tr><td class='cf7pp_width'></td><td>If the customer goes to PayPal and successfully pays, where are they redirected to after. Example: http://example.com/thankyou. Max length: 1,024. </td></tr>
				
				<tr><td>
				<br />
				</td></tr>
				
				<tr><td class='cf7pp_width'><b>Stripe Return URL: </b></td><td><input type='text' name='stripe_return' value='"; $settings_table_output .= $options['stripe_return']; $settings_table_output .= "'> Optional <br /></td></tr>
				<tr><td class='cf7pp_width'></td><td>If the customer successfully pays with Stripe, where are they redirected to after. Example: http://example.com/thankyou. </td></tr>
				
				<tr><td>
				<br />
				</td></tr>
				
				<tr><td class='cf7pp_width'><b>Send email for Skip Redirect: </b></td><td>
				
				<select name='skip_email'>";
				$settings_table_output .= "<option "; if ($options['skip_email'] == "1") { $settings_table_output .= "SELECTED"; } $settings_table_output .= " value='1'>Don't send email</option>";
				$settings_table_output .= "<option "; if ($options['skip_email'] == "2") { $settings_table_output .= "SELECTED"; } $settings_table_output .= " value='2'>Send email</option>";
				$settings_table_output .= "</select> </td></tr>
				
				<tr><td class='cf7pp_width'></td><td>If the form is setup to 'skip redirect' based on either 0.00 amounts or the Redirect Code AND the 'send email after payment' feature is enabled, should the email be sent if the form skips the redirect?</td></tr>
				
				
				<tr><td>
				<br />
				</td></tr>
				
				<tr><td class='cf7pp_width'><b>Requre Shipping Address: </b></td><td>";
				
				$settings_table_output .= "<select name='address' id='address'>";
					$settings_table_output .= "<option value='1' "; if ($options['address'] == "1") { $settings_table_output .= "SELECTED"; } $settings_table_output .= ">Do not prompt for an address</option>";
					$settings_table_output .= "<option value='2' "; if ($options['address'] == "2") { $settings_table_output .= "SELECTED"; } $settings_table_output .= ">Prompt for an address, and require one</option>";
				$settings_table_output .= "</select> Optional <br /> Should the customer be asked for a shipping address at PayPal & Stripe checkout.";
				

				
				
				
				$settings_table_output .= "<tr><td>
				<br />
				</td></tr>
				
				<tr><td class='cf7pp_width'><b>Redirect Method: </b></td><td>";
				
				
				$settings_table_output .= "<select name='redirect'>";
				$settings_table_output .= "<option "; if ($options['redirect'] == "1") { $settings_table_output .= "SELECTED"; } $settings_table_output .= " value='1'>1 (DOM wpcf7mailsent event listener)</option>";
				$settings_table_output .= "<option "; if ($options['redirect'] == "2") { $settings_table_output .= "SELECTED"; } $settings_table_output .= " value='2'>2 (Form sent class listener)</option>";
				$settings_table_output .= "</select> <br />Method 1 recommend unless the form has problems redirecting.";
				
				
				$settings_table_output .= "<tr><td>
				<br />
				</td></tr>
				
				<tr><td class='cf7pp_width'><b>Temporary Storage Method: </b></td><td>";
				
				
				$settings_table_output .= "<select name='session'>";
				$settings_table_output .= "<option "; if ($options['session'] == "1") { $settings_table_output .= "SELECTED"; } $settings_table_output .= " value='1'>Cookies</option>";
				$settings_table_output .= "<option "; if ($options['session'] == "2") { $settings_table_output .= "SELECTED"; } $settings_table_output .= " value='2'>Sessions</option>";
				$settings_table_output .= "</select> <br />Cookies are recommend unless the form has problems.";
				
				
				
				
				$settings_table_output .= "</td></tr>";
				
			$settings_table_output .= "</table>";
			
		$settings_table_output .= "</div>";
	$settings_table_output .= "</div>";




	$settings_table_output .= "<input type='hidden' name='update' value='1'>";
	$settings_table_output .= "<input type='hidden' name='hidden_tab_value' id='hidden_tab_value' value='$active_tab'>";

$settings_table_output .= "</form>";













	$settings_table_output .= "</td><td width='3%' valign='top'>";

	$settings_table_output .= "</td><td width='24%' valign='top'>";
	
	
	
	
	$settings_table_output .= "<div style='border: 1px solid #CCCCCC;'>";
		
		$settings_table_output .= "<div style='background-color:#E4E4E4;padding:8px;color:#000;font-size:15px;color:#464646;font-weight: 700;border-bottom: 1px solid #CCCCCC;'>";
		$settings_table_output .= "&nbsp; License Manager";
		$settings_table_output .= "</div>";
			
		$settings_table_output .= "<div style='background-color:#fff;padding:8px;'>";
			
			$settings_table_output .= "Enter your license key below to get plugin updates: <br /><br />";
			
			
			$license 	= get_option('cf7pp_plicsence_keycf7pp');
			$status 	= get_option('cf7pp_plicsence_key_status');
			$expires 	= get_option('cf7pp_license_expires');
			
			if ($expires == 'lifetime') {
				$expires_date = 'Lifetime License';
			} else {
				$expires_date = date('F j, Y',strtotime($expires));
			}
			
			
			$settings_table_output .= "<form method='post'>
				<table><tr align='left'>
					
					<input name='key' size='40' type='text' value='$license'>
					
					</td><td>";
					if( $status !== false && $status == 'valid' ) {
						// valid
						wp_nonce_field( 'cf7pp_nonce', 'cf7pp_nonce' );
						$settings_table_output .= "<input type='submit' class='button-secondary' name='cf7pp_license_deactivate' value='Deactivate License'>";
					} else {
						// invalid
						wp_nonce_field( 'cf7pp_nonce', 'cf7pp_nonce' );
						$settings_table_output .= "<input type='submit' class='button-secondary' name='cf7pp_license_activate' value='Activate License'>";
					}
					
					$settings_table_output .= "</td></tr><tr><td>
					
					<br />";
					
					if( $status !== false && $status == 'valid' ) {
						$settings_table_output .= "<span style='color:green;'>Your license is valid until: $expires_date.</span>";
					} else {
						$settings_table_output .= "<span style='color:red;'>Your license is not valid.</span>";
					}
				
				$settings_table_output .= "</td></tr></table>";
			$settings_table_output .= "</form>";
		
		$settings_table_output .= "</div>";
	$settings_table_output .= "</div>";

	
	$settings_table_output = apply_filters('cf7pp_settings_page_license_section',$settings_table_output);
	
	
	$settings_table_output .= "</td><td width='2%' valign='top'>";



	$settings_table_output .= "</td></tr></table>";
	
	echo $settings_table_output;

}
