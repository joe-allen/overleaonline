<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly



// settings page license section 
function cf7pps_cf7pp_settings_page_license_section($settings_table_output) {
	
	
	$settings_table_output .= "<br />";
	
	$settings_table_output .= "<div style='border: 1px solid #CCCCCC;'>";
		
		$settings_table_output .= "<div style='background-color:#E4E4E4;padding:8px;color:#000;font-size:15px;color:#464646;font-weight: 700;border-bottom: 1px solid #CCCCCC;'>";
		$settings_table_output .= "&nbsp; Contact Form 7 - Recurring Payments Pro | License Manager";
		$settings_table_output .= "</div>";
			
		$settings_table_output .= "<div style='background-color:#fff;padding:8px;'>";
			
			$settings_table_output .= "Enter your license key below to get plugin updates: <br /><br />";
			
			
			$license 	= get_option('cf7pps_plicsence_keycf7pp');
			$status 	= get_option('cf7pps_plicsence_key_status');
			$expires 	= get_option('cf7pps_license_expires');
			
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
						wp_nonce_field( 'cf7pps_nonce', 'cf7pps_nonce' );
						$settings_table_output .= "<input type='submit' class='button-secondary' name='cf7pps_license_deactivate' value='Deactivate License'>";
					} else {
						// invalid
						wp_nonce_field( 'cf7pps_nonce', 'cf7pps_nonce' );
						$settings_table_output .= "<input type='submit' class='button-secondary' name='cf7pps_license_activate' value='Activate License'>";
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

	
	
	
	return $settings_table_output;
	
}
add_filter('cf7pp_settings_page_license_section','cf7pps_cf7pp_settings_page_license_section',10,1);