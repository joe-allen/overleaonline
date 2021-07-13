<?php
/**
 * Post Thumbnail Labels
 *
 * Customizes the post thumnail metabox
 *
 * @package BoogieDown\Overlea\Functions
 * @author  Vitamin
 * @version 1.0.0
 */

/**
 * Adds table button to TinyMCE
 *
 * !ATTENTION:
 * You MUST download the TinyMCE Table plugin and add it to
 * the wp-content folder in order for this code to work.
 * Be sure to download the correct version of TinyMCE to get
 * the compatible plugin.
 *
 * @param array $buttons TinyMCE buttons (Row 1)
 *
 * @return array
 */
function v_add_table_button( $buttons ) {
	array_push( $buttons, 'separator', 'table' );
	return $buttons;
}
add_filter( 'mce_buttons', 'v_add_table_button' );


/**
 * Loads TinyMCE Table plugin
 *
 * @param array $plugins TinyMCE plugins
 *
 * @return array
 */
function v_add_table_plugin( $plugins ) {
	$plugins['table'] = content_url() . '/tinymce-plugins/table/plugin.min.js';
	return $plugins;
}
add_filter( 'mce_external_plugins', 'v_add_table_plugin' );


/**
 * Cleans up table output whenever the_content filter is run
 *
 * @param mixed $content WYSIWYG html
 *
 * @return mixed
 */
function v_clean_table_html( $content ) {
	preg_match_all( '/<table.*?>.*?<\/table>/is', $content, $tables );
	foreach ( $tables as $table ) {
		$classes   = preg_replace( '/<table(.*?)>(.*?)<\/table>/is', '<table class="v-table"\1>\2</table>', $table );
		$no_styles = preg_replace( '/(?:style=".*?(width: .*?;)?.*?")/is', 'style="\1"', $classes );
		$no_styles = preg_replace( '/(?:border=".*?")|(?:cellspacing=".*?")|(?:cellpadding=".*?")|(?:<caption>.*?<\/caption>)/is', '', $no_styles );
		$content   = str_replace( $table, $no_styles, $content );
	}
	return $content;
}
add_filter( 'the_content', 'v_clean_table_html' );
