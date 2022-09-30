<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly






// display recurring static input types
function cf7pps_tabs_page_static_value($admin_table_output, $post_id) {


	$recurring_static 				= get_post_meta($post_id, "_cf7pp_recurring_static", true);
	$recurring_static_cycle_p3 		= get_post_meta($post_id, "_cf7pp_recurring_static_cycle_p3", true);
	$recurring_static_cycle_t3 		= get_post_meta($post_id, "_cf7pp_recurring_static_cycle_t3", true);
	$recurring_static_cycle_srt 	= get_post_meta($post_id, "_cf7pp_recurring_static_cycle_srt", true);
	
	
	
	
	if ($recurring_static == "1") { $recurring_static_checked = "CHECKED"; } else {  $recurring_static_checked = ""; }
	
	$admin_table_output .= "<tr><td class='cf7pp_tabs_table_title_width'>Recurring</td><td class='cf7pp_tabs_table_body_width'><input type='checkbox' value='1' id='recurring_static' name='recurring_static'  $recurring_static_checked ></td><td>(Optional, Should this be a recurring payment? Documenation <a target='_blank' href='https://wpplugin.org/documentation/enable-static-recurring-payments/'>here</a>.)</td></tr>";
	
	$admin_table_output .= "
	
	<tr style='display:none;' class='recurring_static_section' id='recurring_2'><td valign='top' class='cf7pp_tabs_table_title_width'>
		Billing cycle: </td><td valign='top' class='cf7pp_tabs_table_body_width'>
		
		<select name='recurring_static_cycle_p3'>
		
		";
		for ($x = 1; $x <= 52; $x++) {
			$admin_table_output .= "<option "; if ($recurring_static_cycle_p3 == $x) { $admin_table_output .= 'SELECTED'; } $admin_table_output .= " value=$x>$x</option>";
		}
		
		$admin_table_output .= "
		</select>
		
		<select name='recurring_static_cycle_t3'>
			<option "; if ($recurring_static_cycle_t3 == 'D') { $admin_table_output .= 'SELECTED'; } $admin_table_output .= " value='D'>day(s)</option>
			<option "; if ($recurring_static_cycle_t3 == 'W') { $admin_table_output .= 'SELECTED'; } $admin_table_output .= " value='W'>week(s)</option>
			<option "; if ($recurring_static_cycle_t3 == 'M') { $admin_table_output .= 'SELECTED'; } $admin_table_output .= " value='M'>month(s)</option>
			<option "; if ($recurring_static_cycle_t3 == 'Y') { $admin_table_output .= 'SELECTED'; } $admin_table_output .= " value='Y'>year(s)</option>
		</select>
		
	</td><td>(Important - Stripe: Maximum of one year interval allowed (1 year, 12 months, or 52 weeks). PayPal: Maxium of 5 year interval allowed.</td></tr>
	";
	
	
	$admin_table_output .= "
	
	<tr style='display:none;' class='recurring_static_section' id='recurring_3'><td valign='top'>
		After how many cycles should billing stop: </td><td>
		
		<select name='recurring_static_cycle_srt'>
			<option "; if ($recurring_static_cycle_srt == '0') { $admin_table_output .= 'SELECTED'; } $admin_table_output .= " value='0'>Never</option>
			<option "; if ($recurring_static_cycle_srt == '2') { $admin_table_output .= 'SELECTED'; } $admin_table_output .= " value='2'>2</option>
			<option "; if ($recurring_static_cycle_srt == '3') { $admin_table_output .= 'SELECTED'; } $admin_table_output .= " value='3'>3</option>
			<option "; if ($recurring_static_cycle_srt == '4') { $admin_table_output .= 'SELECTED'; } $admin_table_output .= " value='4'>4</option>
			<option "; if ($recurring_static_cycle_srt == '5') { $admin_table_output .= 'SELECTED'; } $admin_table_output .= " value='5'>5</option>
			<option "; if ($recurring_static_cycle_srt == '6') { $admin_table_output .= 'SELECTED'; } $admin_table_output .= " value='6'>6</option>
			<option "; if ($recurring_static_cycle_srt == '7') { $admin_table_output .= 'SELECTED'; } $admin_table_output .= " value='7'>7</option>
			<option "; if ($recurring_static_cycle_srt == '8') { $admin_table_output .= 'SELECTED'; } $admin_table_output .= " value='8'>8</option>
			<option "; if ($recurring_static_cycle_srt == '9') { $admin_table_output .= 'SELECTED'; } $admin_table_output .= " value='9'>9</option>
			<option "; if ($recurring_static_cycle_srt == '10') { $admin_table_output .= 'SELECTED'; } $admin_table_output .= " value='10'>10</option>
			<option "; if ($recurring_static_cycle_srt == '11') { $admin_table_output .= 'SELECTED'; } $admin_table_output .= " value='11'>11</option>
			<option "; if ($recurring_static_cycle_srt == '12') { $admin_table_output .= 'SELECTED'; } $admin_table_output .= " value='12'>12</option>
			<option "; if ($recurring_static_cycle_srt == '13') { $admin_table_output .= 'SELECTED'; } $admin_table_output .= " value='13'>13</option>
			<option "; if ($recurring_static_cycle_srt == '14') { $admin_table_output .= 'SELECTED'; } $admin_table_output .= " value='14'>14</option>
			<option "; if ($recurring_static_cycle_srt == '15') { $admin_table_output .= 'SELECTED'; } $admin_table_output .= " value='15'>15</option>
			<option "; if ($recurring_static_cycle_srt == '16') { $admin_table_output .= 'SELECTED'; } $admin_table_output .= " value='16'>16</option>
			<option "; if ($recurring_static_cycle_srt == '17') { $admin_table_output .= 'SELECTED'; } $admin_table_output .= " value='17'>17</option>
			<option "; if ($recurring_static_cycle_srt == '18') { $admin_table_output .= 'SELECTED'; } $admin_table_output .= " value='18'>18</option>
			<option "; if ($recurring_static_cycle_srt == '19') { $admin_table_output .= 'SELECTED'; } $admin_table_output .= " value='19'>19</option>
			<option "; if ($recurring_static_cycle_srt == '20') { $admin_table_output .= 'SELECTED'; } $admin_table_output .= " value='20'>20</option>
			<option "; if ($recurring_static_cycle_srt == '21') { $admin_table_output .= 'SELECTED'; } $admin_table_output .= " value='21'>21</option>
			<option "; if ($recurring_static_cycle_srt == '22') { $admin_table_output .= 'SELECTED'; } $admin_table_output .= " value='22'>22</option>
			<option "; if ($recurring_static_cycle_srt == '23') { $admin_table_output .= 'SELECTED'; } $admin_table_output .= " value='23'>23</option>
			<option "; if ($recurring_static_cycle_srt == '24') { $admin_table_output .= 'SELECTED'; } $admin_table_output .= " value='24'>24</option>
			<option "; if ($recurring_static_cycle_srt == '25') { $admin_table_output .= 'SELECTED'; } $admin_table_output .= " value='25'>25</option>
			<option "; if ($recurring_static_cycle_srt == '26') { $admin_table_output .= 'SELECTED'; } $admin_table_output .= " value='26'>26</option>
			<option "; if ($recurring_static_cycle_srt == '27') { $admin_table_output .= 'SELECTED'; } $admin_table_output .= " value='27'>27</option>
			<option "; if ($recurring_static_cycle_srt == '28') { $admin_table_output .= 'SELECTED'; } $admin_table_output .= " value='28'>28</option>
			<option "; if ($recurring_static_cycle_srt == '29') { $admin_table_output .= 'SELECTED'; } $admin_table_output .= " value='29'>29</option>
			<option "; if ($recurring_static_cycle_srt == '30') { $admin_table_output .= 'SELECTED'; } $admin_table_output .= " value='30'>30</option>
		</select>
		
	</td><td>(This option is only available for PayPal. It will be ignored for Stripe.)</td></tr>
	";
	
	$admin_table_output .= "
	<script>
		
		document.getElementById('recurring_static').onclick = function() {
		
		const recurring_table2 = document.querySelector('#recurring_2');
		const recurring_table3 = document.querySelector('#recurring_3');
		
		if ( this.checked ) {
			recurring_table2.style.display = 'table-row';
			recurring_table3.style.display = 'table-row';
		} else {
			recurring_table2.style.display = 'none';
			recurring_table3.style.display = 'none';
		}
		};
		
		
		
		document.addEventListener('DOMContentLoaded', function() {
			
			const recurring_table2 = document.querySelector('#recurring_2');
			const recurring_table3 = document.querySelector('#recurring_3');
			
			if (document.getElementById('recurring_static').checked) {
				recurring_table2.style.display = 'table-row';
				recurring_table3.style.display = 'table-row';
			} else {
				recurring_table2.style.display = 'none';
				recurring_table3.style.display = 'none';
			}
			
		});
		
		
	</script>
	";
	
	
	return $admin_table_output;
	
}
add_filter('cf7pp_tabs_page_static_value','cf7pps_tabs_page_static_value',10,2);







// display recurring dynamic input types
function cf7pps_tabs_page_dynamic_value($admin_table_output, $post_id) {
	
	$recurring_dynamic 				= get_post_meta($post_id, "_cf7pp_recurring_dynamic", true);
	
	if ($recurring_dynamic == "1") { $recurring_dynamic_checked = "CHECKED"; } else {  $recurring_dynamic_checked = ""; }
	
	
	
	$admin_table_output .= "<tr><td>Recurring</td><td><input type='checkbox' value='1' id='recurring_dynamic' name='recurring_dynamic'  $recurring_dynamic_checked ></td><td>(Optional, Should this be a recurring payment? Documenation <a target='_blank' href='https://wpplugin.org/documentation/enable-dynamic-recurring-payments/'>here</a>.)</td></tr>";
	
	
	
	// show or hide recurring tables based on checkbox value
	$admin_table_output .= "
	<script>
		
		document.getElementById('recurring_dynamic').onclick = function() {
			
			if ( this.checked ) {
				
				var elements = document.getElementsByClassName('cf7pp_dynamic_options_more');
				for(var i = 0; i < elements.length; i++) {
					elements[i].style.display = 'none';
				}
				
			} else {
				var elements = document.getElementsByClassName('cf7pp_dynamic_options_more');
				for(var i = 0; i < elements.length; i++) {
					elements[i].style.display = 'table-row';
				}
			}
			
		};
		
		
		document.addEventListener('DOMContentLoaded', function() {
			
			if (document.getElementById('recurring_dynamic').checked) {
				
				var elements = document.getElementsByClassName('cf7pp_dynamic_options_more');
				for(var i = 0; i < elements.length; i++) {
					elements[i].style.display = 'none';
				}
				
			} else {
				
				var elements = document.getElementsByClassName('cf7pp_dynamic_options_more');
				for(var i = 0; i < elements.length; i++) {
					elements[i].style.display = 'table-row';
				}
				
			}
			
		});
		
		
	</script>
	";
	
	
	return $admin_table_output;
	
}
add_filter('cf7pp_tabs_page_dynamic_value','cf7pps_tabs_page_dynamic_value',10,2);



















// save tabs page values
function cf7pps_tabs_page_static_dynamic_value_save($post_id) {

	// static
	if (!empty($_POST['recurring_static'])) {
		$recurring_static = sanitize_text_field($_POST['recurring_static']);
		update_post_meta($post_id, "_cf7pp_recurring_static", $recurring_static);
	} else {
		update_post_meta($post_id, "_cf7pp_recurring_static", 0);
	}
	
	if (!empty($_POST['recurring_static_cycle_p3'])) {
		$recurring_static_cycle_p3 = sanitize_text_field($_POST['recurring_static_cycle_p3']);
		update_post_meta($post_id, "_cf7pp_recurring_static_cycle_p3", $recurring_static_cycle_p3);
	} else {
		update_post_meta($post_id, "_cf7pp_recurring_static_cycle_p3", 0);
	}
	
	if (!empty($_POST['recurring_static_cycle_t3'])) {
		$recurring_static_cycle_t3 = sanitize_text_field($_POST['recurring_static_cycle_t3']);
		update_post_meta($post_id, "_cf7pp_recurring_static_cycle_t3", $recurring_static_cycle_t3);
	} else {
		update_post_meta($post_id, "_cf7pp_recurring_static_cycle_t3", 0);
	}
	
	if (!empty($_POST['recurring_static_cycle_srt'])) {
		$recurring_static_cycle_srt = sanitize_text_field($_POST['recurring_static_cycle_srt']);
		update_post_meta($post_id, "_cf7pp_recurring_static_cycle_srt", $recurring_static_cycle_srt);
	} else {
		update_post_meta($post_id, "_cf7pp_recurring_static_cycle_srt", "0");
	}
	
	// dynamic
	if (!empty($_POST['recurring_dynamic'])) {
		$recurring_dynamic = sanitize_text_field($_POST['recurring_dynamic']);
		update_post_meta($post_id, "_cf7pp_recurring_dynamic", $recurring_dynamic);
	} else {
		update_post_meta($post_id, "_cf7pp_recurring_dynamic", 0);
	}

	
}
add_action('cf7pp_tabs_page_save_values','cf7pps_tabs_page_static_dynamic_value_save',10,1);