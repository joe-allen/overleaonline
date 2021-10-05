<?php
/**
 * W3 Total Cache
 *
 * @package Vitamin\Vanilla_Theme\Functions
 * @author Vitamin
 * @version 1.0.0
 */

/**
 * Add Purge Buttom
 *
 * @param WP_Admin_Bar $admin_bar admin bar
 */
function v_add_purge_button( $admin_bar ) {
	$admin_bar->add_menu(
		[
			'id'    => 'v-purge-cache',
			'title' => 'Purge Cache',
			'href'  => '#',
		]
	);
}
add_action( 'admin_bar_menu', 'v_add_purge_button', 100 );

/**
 * Purge JS
 */
function v_cache_purge_action_js() {
	?>
	<script type="text/javascript" >
		jQuery( '#wp-admin-bar-v-purge-cache .ab-item' )
			.on( 'click', function() {
				var data = {
					'action': 'v_purge_cache',
				};

				jQuery.post( ajaxurl, data, function( response ) {
					alert( response );
				} );
			} );
	</script>
	<?php
}
add_action( 'admin_footer', 'v_cache_purge_action_js' );

/**
 * Purge Cache
 */
function v_purge_cache_callback() {
	if ( function_exists( 'w3tc_flush_all' ) ) {
		w3tc_flush_all();
		$response = 'Cache purge started. Please allow up to 30 seconds for the purge to complete.';
	} else {
		$response = 'Something went wrong. Please contact the site administrator for assistance.';
	}

	echo esc_html( $response );
	wp_die();
}
add_action( 'wp_ajax_v_purge_cache', 'v_purge_cache_callback' );
