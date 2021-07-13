<?php
/**
 * Login Logo
 *
 * @package BoogieDown\Overlea\Functions
 * @author Vitamin
 * @version 1.0.0
 */

/**
 * Login Logo
 *
 * @return void
 */
function v_login_logo() { ?>
	<style>
			#login h1 a,
			.login h1 a {
				width: 300px; /* 300px max */
				height: 70px;
				padding-bottom: 15px;
				background-image: url("<?php echo esc_url( get_theme_file_uri() ); ?>/img/login-logo.png");
				background-size: 300px 70px; /* match width, height */
				background-repeat: no-repeat;
			}

			@media
			(-webkit-min-device-pixel-ratio: 2),
			(min-resolution: 192dpi) {
					#login h1 a,
					.login h1 a {
						background-image: url("<?php echo esc_url( get_theme_file_uri() ); ?>/img/login-logo@2x.png")
					}
			}
	</style>
	<?php
}
add_action( 'login_enqueue_scripts', 'v_login_logo' );

/**
 * Login Logo URL
 *
 * @return string
 */
function v_login_logo_url() {
	return home_url();
}
add_filter( 'login_headerurl', 'v_login_logo_url' );

/**
 * Login Logo Title
 *
 * @return string
 */
function v_login_logo_url_title() {
	return 'Vitamin'; // Change this!
}
add_filter( 'login_headertitle', 'v_login_logo_url_title' );
