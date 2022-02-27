jQuery(document).ready(function($) {

	var cf7pp_formid;
	var cf7pp_id_long;
	var cf7pp_pub_key;
	var cf7pp_amount_total;
	var cf7pp_stripe_return;
	var cf7pp_tags_id;
	var cf7pp_input_id;
	var cf7pp_payment_id;
	
	
	
	
	// for redirect method 1
	document.addEventListener('wpcf7mailsent', function( event ) {
		
		if (ajax_object_cf7pp.method == 1) {
			
			var cf7pp_id_long =			event.detail.unitTag;
			var cf7pp_id = 				event.detail.contactFormId;
			
			var cf7pp_formid = cf7pp_id;
			
			cf7pp_redirect(cf7pp_formid, cf7pp_id_long);
		}
		
	}, false );
	
	
	
	
	
	
	
	
	// for redirect method 2
	if (ajax_object_cf7pp.method == 2) {
	
		var cf7pp_form_counter = 0;
		
		jQuery('.wpcf7-form').bind('DOMSubtreeModified', function(e) {
			
			if (cf7pp_form_counter == 0) {
				if (jQuery('.wpcf7-form').hasClass('sent')) {
					
					// get form id
					var cf7pp_id = jQuery(this).parent().attr('id').substring(7);
					
					cf7pp_id = cf7pp_id.split('-')[0];
					
					var cf7pp_id_long = jQuery(this).parent().attr('id');
					
					cf7pp_redirect(cf7pp_id, cf7pp_id_long);
					cf7pp_form_counter = 1;
				}
			}
			
		  });
	}
	
	

	// used for redirect method 1 and 2
	function cf7pp_redirect(cf7pp_id, cf7pp_id_long) {
		
		var cf7pp_forms = ajax_object_cf7pp.forms;
		var cf7pp_result_paypal = cf7pp_forms.indexOf(cf7pp_id+'|paypal');
		var cf7pp_result_stripe = cf7pp_forms.indexOf(cf7pp_id+'|stripe');
		
		
		var cf7pp_gateway;
		
		var cf7pp_data = {
			'action':	'cf7pp_get_form_post',
		};
		
		jQuery.ajax({
			type: "GET",
			data: cf7pp_data,
			dataType: "json",
			async: false,
			url: ajax_object_cf7pp.ajax_url,
			xhrFields: {
				withCredentials: true
			},
			success: function (response) {
				cf7pp_gateway = 			response.gateway;
				cf7pp_skip = 				response.skip;
				cf7pp_pub_key = 			response.pub_key;
				cf7pp_amount_total = 		response.amount_total;
				cf7pp_stripe_return = 		response.stripe_return;
				cf7pp_tags_id =				response.tags_id;
				cf7pp_input_id =			response.input_id;
				cf7pp_payment_id =			response.payment_id;
			}
		});
		
		
		var cf7pp_paypal_path = ajax_object_cf7pp.path_paypal+cf7pp_id+'&cf7pp_t='+cf7pp_tags_id+'&cf7pp_i='+cf7pp_input_id+'&cf7pp_p='+cf7pp_payment_id;
		var cf7pp_stripe_path = ajax_object_cf7pp.path_stripe+cf7pp_id+'&cf7pp_t='+cf7pp_tags_id+'&cf7pp_i='+cf7pp_input_id+'&cf7pp_p='+cf7pp_payment_id+'&cf7pp_fid='+cf7pp_id_long+'&cf7pp_return='+window.location.href;
		
		
		// skip redirect for 0.00 amounts
		if (cf7pp_skip != '1') {
			
			
			// gateway chooser
			if (cf7pp_gateway != null) {
				// paypal
				if (cf7pp_result_paypal > -1 && cf7pp_gateway == 'paypal') {
					window.location.href = cf7pp_paypal_path;
				}
				
				// stripe
				if (cf7pp_result_stripe > -1 && cf7pp_gateway == 'stripe') {
					window.location.href = cf7pp_stripe_path;
				}
			} else {
				// no gateway chooser
				if (cf7pp_result_paypal > -1) {
					window.location.href = cf7pp_paypal_path;
				}
				
				// stripe
				if (cf7pp_result_stripe > -1) {
					window.location.href = cf7pp_stripe_path;
				}
			}
		}
		
	};
	
	
	// show stripe success message
	let searchParams = new URLSearchParams(window.location.search)
	
	if (searchParams.has('cf7pp_stripe_success')) {
		
		let fid 		= searchParams.get('cf7pp_fid');
		let tags_id 	= searchParams.get('cf7pp_tags_id');
		let success_url = searchParams.get('cf7pp_success');
		let redirect 	= searchParams.get('cf7pp_redirect');
		
		if (redirect == '1') {
			window.location.href = success_url;
		} else {
			
			var cf7pp_data = {
				'action':			'cf7pp_get_form_stripe_success',
				'cf7pp_tags_id':	tags_id,
				'cf7pp_success':	success_url,
				'cf7pp_redirect':	redirect,
			};
			
			jQuery.ajax({
				type: "POST",
				data: cf7pp_data,
				dataType: "json",
				async: false,
				url: ajax_object_cf7pp.ajax_url,
				xhrFields: {
					withCredentials: true
				},
				success: function (response) {
					var html_response = response.html;
					
					jQuery('#'+fid).html(html_response);
					
				}
			});
			
		}
		
	}
	
	

});
