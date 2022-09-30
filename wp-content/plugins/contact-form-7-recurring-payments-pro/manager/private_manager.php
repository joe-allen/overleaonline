<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


// activate

if(isset($_POST['cf7pps_license_activate'])) {

	// retrieve the license from the database
	$license = $_POST['key'];
	
	$license = str_replace(' ', '',$license);
		
		
		// data to send in our API request
		$api_params = array(
			'edd_action' => 'activate_license',
			'license'    => $license,
			//'item_name'  => urlencode( CF7PPS_PRODUCT_NAME ), // the name of our product in EDD
			'item_id'  => urlencode( CF7PPS_ITEM_ID ), // the name of our product in EDD
			'url'        => home_url()
		);
		
		// Call the custom API.
		$response = wp_remote_post( CF7PPS_STORE_URL, array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );
		
		// make sure the response came back okay
		if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
			
			$message =  'An error occurred, please try again.';
			
		} else {
			
			$license_data = json_decode( wp_remote_retrieve_body( $response ) );
			
			if ( false === $license_data->success ) {
				
				switch( $license_data->error ) {
					
					case 'expired' :
						
						$message = sprintf(
							__( 'Your license key expired on %s.' ),
							date_i18n( get_option( 'date_format' ), strtotime( $license_data->expires, current_time( 'timestamp' ) ) )
						);
						break;
						
					case 'revoked' :
						
						$message = __( 'Your license key has been disabled.' );
						break;
						
					case 'missing' :
						
						$message = __( 'Invalid license.' );
						break;
						
					case 'invalid' :
					case 'site_inactive' :
						
						$message = __( 'Your license is not active for this URL.' );
						break;
						
					case 'item_name_mismatch' :
						
						$message = sprintf( __( 'This appears to be an invalid license key for %s.' ), CF7PPS_PRODUCT_NAME );
						break;
						
					case 'no_activations_left':
						
						$message = __( 'Your license key has reached its activation limit.' );
						break;
						
					default :
						
						$message = __( 'An error occurred, please try again.' );
						break;
				}
				
			}
			
		}
		
		if (empty($message)) {
			$message = "valid";
		}
	
	update_option( 'cf7pps_plicsence_keycf7pp', $license );
	update_option( 'cf7pps_plicsence_key_status', $message );
	
	if (!empty($license_data->expires)) {
		update_option( 'cf7pps_license_expires', $license_data->expires );
	} else {
		update_option( 'cf7pps_license_expires', '' );
	}
}


// deactivate

if(isset($_POST['cf7pps_license_deactivate'])) {

	// retrieve the license from the database
	$license = trim( get_option( 'cf7pps_plicsence_keycf7pp' ) );

	// data to send in our API request
	$api_params = array(
		'edd_action'=> 'deactivate_license',
		'license' 	=> $license,
		//'item_name' => urlencode( CF7PPS_PRODUCT_NAME ), // the name of our product in EDD
		'item_id' => urlencode( CF7PPS_ITEM_ID ), // the name of our product in EDD
		'url'       => home_url()
	);

	// Call the custom API.
	$response = wp_remote_post( CF7PPS_STORE_URL, array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );
	
	// make sure the response came back okay
	if ( is_wp_error( $response ) ) {
		return false;
	}

	// decode the license data
	$license_data = json_decode( wp_remote_retrieve_body( $response ) );
	
	// $license_data->license will be either "deactivated" or "failed"
	if($license_data->license == 'deactivated' || $license_data->license == 'failed') {
		delete_option('cf7pps_plicsence_key_status');
		delete_option('cf7pps_license_expires');
	}

}