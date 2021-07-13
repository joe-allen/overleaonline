<?php
/**
 * Relevanssi
 *
 * Search modifications
 *
 * @package BoogieDown\Overlea\Functions
 * @author Vitamin
 * @version 1.0.0
 */

/**
 * Modify Indexed Content
 *
 * For the team page, get team member content
 * and add it to the indexed content so the
 * page shows up in search results for team members
 *
 * @param  string  $content content to add
 * @param  WP_Post $post    the post being indexed
 * @return string
 */
function v_modify_indexed_content( $content, $post ) {
	if ( 16 === $post->ID ) { // the team page
		// Get the team members
		$team = get_posts(
			[
				'post_type'      => 'team',
				'posts_per_page' => -1,
				'orderby'        => 'menu_order',
				'order'          => 'ASC',
			]
		);

		// Map the team members to an array of strings of content to be indexed
		$team = array_map(
			function( $member ) {
				// Get the content to be indexed
				$name  = get_post_meta( $member->ID, 'team_name', true );
				$title = get_post_meta( $member->ID, 'team_job', true );
				$bio   = get_post_meta( $member->ID, 'team_bio', true );

				// Return the content as a combined string
				return implode(
					' ',
					[
						( $name ? $name : $member->post_title ),
						$title,
						apply_filters( 'the_content', $bio ),
					]
				);
			},
			$team
		);

		// Append the team content to the content to be indexed
		$content .= implode( ' ', $team );
	}

	return $content;
}
add_filter( 'relevanssi_content_to_index', 'v_modify_indexed_content', 10, 2 );
