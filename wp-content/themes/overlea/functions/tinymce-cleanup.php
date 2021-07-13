<?php
/**
 * TinyMCE Cleanup
 *
 * Clean up WYSIWIG options
 *
 * @package BoogieDown\Overlea\Functions
 * @author  Vitamin
 * @version 1.1.0
 */

/**
 * Customizes the TinyMCE toolbars
 *
 * @param  array $toolbars TinyMCE toolbars
 *
 * @return array
 */
function v_acf_toolbars( $toolbars ) {
	/**
	 * Create new toolbars
	 */
	$toolbars['Bare']      = [];
	$toolbars['Bare'][1]   = [ 'link', 'unlink', 'bold', 'italic', 'undo', 'redo' ];
	$toolbars['Simple']    = [];
	$toolbars['Simple'][1] = [ 'link', 'unlink', 'bold', 'italic', 'bullist', 'numlist', 'undo', 'redo' ];

	/**
	 * Add the style dropdown to the toolbars
	 */
	array_unshift( $toolbars['Basic'][1], 'styleselect' );
	array_unshift( $toolbars['Full'][1], 'styleselect' );

	/**
	 * Remove buttons from the default toolbars
	 */
	$remove_buttons = [
		'wp_more', // read more link
		'dfw', // distraction free writing mode
		'wp_adv',
		'blockquote',
		'hr',
		'indent',
		'outdent',
		'hr',
		'forecolor',
	];

	foreach ( $remove_buttons as $button ) {
		for ( $row = 1; $row <= 2; $row++ ) {
			if ( $toolbars['Full'][ $row ] ) {
				$key = array_search( $button, $toolbars['Full'][ $row ], true );
				if ( false !== $key ) {
					unset( $toolbars['Full'][ $row ][ $key ] );
				}
			}

			if ( $toolbars['Basic'][ $row ] ) {
				$key = array_search( $button, $toolbars['Basic'][ $row ], true );
				if ( false !== $key ) {
					unset( $toolbars['Basic'][ $row ][ $key ] );
				}
			}
		}
	}

	/**
	 * Return the modified toolbars
	 */
	return $toolbars;
}
add_filter( 'acf/fields/wysiwyg/toolbars', 'v_acf_toolbars' );

/**
 * Format options
 *
 * @param array $init_array Initial TinyMCE options
 *
 * @return array
 */
function v_mce_formats( $init_array ) {
	$style_formats = [
		[
			'title' => 'Headings',
			'items' => [
				[
					'title'    => 'Alpha',
					'classes'  => 'alpha',
					'wrapper'  => false,
					'selector' => 'h2, h3, h4, h5, h6, p, li, td',
				],

				[
					'title'    => 'Beta',
					'classes'  => 'beta',
					'wrapper'  => false,
					'selector' => 'h2, h3, h4, h5, h6, p, li, td',
				],

				[
					'title'    => 'Gamma',
					'classes'  => 'gamma',
					'wrapper'  => false,
					'selector' => 'h2, h3, h4, h5, h6, p, li, td',
				],

				[
					'title'    => 'Delta',
					'classes'  => 'delta',
					'wrapper'  => false,
					'selector' => 'h2, h3, h4, h5, h6, p, li, td',
				],

				[
					'title'    => 'Epsilon',
					'classes'  => 'epsilon',
					'wrapper'  => false,
					'selector' => 'h2, h3, h4, h5, h6, p, li, td',
				],

				[
					'title'    => 'Zeta',
					'classes'  => 'zeta',
					'wrapper'  => false,
					'selector' => 'h2, h3, h4, h5, h6, p, li, td',
				],
			],
		],
		[
			'title' => 'Quotes',
			'items' => [
				[
					'title'   => 'Blockquote',
					'block'   => 'blockquote',
					'classes' => 'v-blockquote',
					'wrapper' => true,
				],

				[
					'title'    => 'Cite',
					'block'    => 'p',
					'classes'  => 'v-blockquote__cite',
					'wrapper'  => false,
					'exact'    => true,
					'selector' => '.v-blockquote p',
				],
			],
		],
	];
	$init_array['style_formats'] = wp_json_encode( $style_formats );

	$block_formats = [
		'Paragraph=p',
		'Heading 2=h2',
		'Heading 3=h3',
		'Heading 4=h4',
		'Heading 5=h5',
		'Heading 6=h6',
	];

	$init_array['block_formats'] = implode( ';', $block_formats );

	return $init_array;
}
add_filter( 'tiny_mce_before_init', 'v_mce_formats' );

/**
 * Enable full toolbar by default
 *
 * @param array $in Initial TinyMCE options
 *
 * @return array
 */
function v_change_mce_default( $in ) {
	$in['wordpress_adv_hidden'] = false;
	return $in;
}
add_filter( 'tiny_mce_before_init', 'v_change_mce_default' );

/**
 * Add editor-style.css to TinyMCE
 *
 * @return void
 */
function v_add_editor_styles() {
	add_editor_style();
}
add_action( 'init', 'v_add_editor_styles' );
