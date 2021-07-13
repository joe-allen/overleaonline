<?php
/**
 * Facet
 *
 * Various typical customizations for FacetWP
 *
 * @package BoogieDown\Overlea\Functions
 * @author  Vitamin
 * @version 1.0.0
 */

/**
 * Adds parents of selected terms to the post on save
 *
 * @param int     $post_id Post ID
 * @param WP_POST $post    Post object
 * @param bool    $update  Whether this is an existing post being updated or not
 *
 * @return void
 */
function add_tax_parent_to_project( $post_id, $post, $update ) {
	$post_type = get_post_type( $post_id );
	if ( 'project' !== $post_type ) {
		return;
	}

	if ( wp_is_post_revision( $post_id ) ) {
		return;
	}

	$terms = get_the_terms( $post_id, 'project_type' );
	$terms = $terms ? $terms : [];

	foreach ( $terms as $term ) {
		if ( 0 === $term->parent ) {
			continue;
		}

		wp_set_post_terms( $post_id, [ $term->parent ], 'project_type', true );
	}
}
add_action( 'save_post', 'add_tax_parent_to_project', 10, 3 );


/**
 * Sets the FacetWP flag in custom WP_QUERY
 *
 * @param bool     $bool  whether to enable Facet for the query
 * @param WP_QUERY $query the query
 *
 * @return bool
 */
function v_set_facet_query_flag( $bool, $query ) {
	return ( true === $query->get( 'facetwp' ) ) ? true : $bool;
}
add_filter( 'facetwp_is_main_query', 'v_set_facet_query_flag', 10, 2 );

/**
 * Alters the FacetWP filters
 *
 * @param mixed $output filter HTML
 * @param array $params filter parameters
 *
 * @return mixed
 */
function v_modify_facet_output( $output, $params ) {
	if ( 'project_type' === $params['facet']['name'] ) {
		$all_terms = get_terms(
			[
				'taxonomy'   => 'project_type',
				'hide_empty' => false,
			]
		);

		$values = [];
		foreach ( $all_terms as $v ) {
			if ( 0 === $v->parent ) {
				$values[ $v->term_id ] = [
					'facet_display_value' => $v->name,
					'children'            => [
						[
							'facet_value'         => $v->slug,
							'facet_display_value' => $v->name,
							'term_id'             => $v->term_id,
						],
					],
				];
			}
		}

		foreach ( $params['values'] as $i => $v ) {
			$v['tax_position']      = get_term_meta( $v['term_id'], 'tax_position', 1 );
			$params['values'][ $i ] = $v;
		}

		usort(
			$params['values'],
			function( $a, $b ) {
				$a_order = $a['tax_position'];
				$b_order = $b['tax_position'];
				if ( $a_order === $b_order ) {
					return 0;
				}
				return $a_order < $b_order ? -1 : 1;
			}
		);

		foreach ( $params['values'] as $v ) {
			if ( 0 === $v['parent_id'] ) {
				continue;
			}

			$values[ $v['parent_id'] ]['children'][] = $v;
		}

		$params['values']   = $values;
		$context['filters'] = $params;

		return Timber::fetch( 'facet-filters/facet-filters.twig', $context );
	}
	return $output;
}
add_filter( 'facetwp_facet_html', 'v_modify_facet_output', 10, 2 );


/**
 * Alters the FacetWP pagination
 *
 * @param mixed $output pagination HTML
 * @param array $params pagination parameters
 *
 * @return mixed
 */
function v_modify_facet_pagination_html( $output, $params ) {
	$page        = $params['page'];
	$total_pages = $params['total_pages'];

	$context['facet'] = true;

	if ( $page > 1 ) {
		$context['prev'] = ( $page - 1 );
	}

	if ( $page < $total_pages && $total_pages > 1 ) {
		$context['next'] = ( $page + 1 );
	}

	return Timber::fetch( 'pagination/pagination.twig', $context );
}
add_filter( 'facetwp_pager_html', 'v_modify_facet_pagination_html', 10, 2 );
