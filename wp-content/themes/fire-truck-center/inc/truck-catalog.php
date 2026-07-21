<?php
/**
 * Truck catalog and equipment type archive integrations.
 *
 * @package Fire_Truck_Center
 */

/**
 * Return the Search & Filter Pro form used by the truck catalog.
 *
 * @return int
 */
function ftc_get_truck_filter_form_id() {
	return 59;
}

/**
 * Enable Search & Filter's cascading option counts for the truck catalog.
 *
 * The versioned migration keeps the setting portable with the theme instead
 * of relying on a manual change in one WordPress database.
 *
 * @return void
 */
function ftc_enable_truck_filter_dynamic_counts() {
	$settings_version = '2';
	if ( $settings_version === get_option( 'ftc_truck_filter_settings_version' ) ) {
		return;
	}

	$form_id  = ftc_get_truck_filter_form_id();
	$settings = get_post_meta( $form_id, '_search-filter-settings', true );
	$fields   = get_post_meta( $form_id, '_search-filter-fields', true );

	if ( ! is_array( $settings ) || ! is_array( $fields ) ) {
		return;
	}

	$settings['enable_auto_count']       = 1;
	$settings['auto_count_refresh_mode'] = 1;
	update_post_meta( $form_id, '_search-filter-settings', $settings );

	foreach ( $fields as &$field ) {
		if ( isset( $field['type'] ) && 'taxonomy' === $field['type'] ) {
			$field['hide_empty'] = 0;
		}

		if ( isset( $field['type'] ) && 'post_meta' === $field['type'] && isset( $field['meta_type'] ) && 'choice' === $field['meta_type'] ) {
			$field['hide_empty'] = 0;
		}
	}
	unset( $field );

	update_post_meta( $form_id, '_search-filter-fields', $fields );
	update_option( 'ftc_truck_filter_settings_version', $settings_version, false );
}
add_action( 'init', 'ftc_enable_truck_filter_dynamic_counts', 20 );

/**
 * Keep empty filter choices visible but prevent users from selecting them.
 *
 * The currently selected value remains enabled even when an old bookmarked
 * URL no longer has results, so the user can still remove that selection.
 *
 * @param array $input_args     Search & Filter input arguments.
 * @param int   $search_form_id Search & Filter form ID.
 * @return array
 */
function ftc_disable_empty_truck_filter_options( $input_args, $search_form_id ) {
	if (
		ftc_get_truck_filter_form_id() !== (int) $search_form_id
		|| empty( $input_args['options'] )
		|| ! is_array( $input_args['options'] )
	) {
		return $input_args;
	}

	$defaults = isset( $input_args['defaults'] ) && is_array( $input_args['defaults'] )
		? array_map( 'strval', $input_args['defaults'] )
		: array();

	foreach ( $input_args['options'] as $option ) {
		if (
			! is_object( $option )
			|| ! isset( $option->count )
			|| 0 !== (int) $option->count
			|| ! isset( $option->value )
			|| '' === (string) $option->value
		) {
			continue;
		}

		$selected_value = isset( $option->selected_value ) ? $option->selected_value : $option->value;
		if ( in_array( (string) $selected_value, $defaults, true ) ) {
			continue;
		}

		if ( ! isset( $option->attributes ) || ! is_array( $option->attributes ) ) {
			$option->attributes = array();
		}

		$option->attributes['disabled'] = 'disabled';
		$option->attributes['class']    = trim(
			( isset( $option->attributes['class'] ) ? $option->attributes['class'] : '' )
			. ' ftc-filter-option-unavailable'
		);
	}

	return $input_args;
}
add_filter( 'sf_input_object_pre', 'ftc_disable_empty_truck_filter_options', 20, 2 );

/**
 * Expose Truck Types in wp-admin so term descriptions and Rank Math metadata
 * can be managed on real taxonomy archives.
 *
 * @param array  $args        Taxonomy registration arguments.
 * @param string $taxonomy    Taxonomy name.
 * @param array  $object_type Object types assigned to the taxonomy.
 * @return array
 */
function ftc_enable_equipment_type_archives( $args, $taxonomy, $object_type ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundAfterLastUsed
	if ( 'equipment_type' !== $taxonomy ) {
		return $args;
	}

	$args['public']              = true;
	$args['publicly_queryable']  = true;
	$args['query_var']           = true;
	$args['show_ui']             = true;
	$args['show_admin_column']   = true;
	$args['show_in_nav_menus']   = true;
	$args['show_in_rest']        = true;

	return $args;
}
add_filter( 'register_taxonomy_args', 'ftc_enable_equipment_type_archives', 20, 3 );

/**
 * Prepare a Truck Type archive as the Search & Filter result query.
 *
 * The taxonomy condition remains in the main query, while form #59 applies
 * the remaining year, brand, chassis, pump and tank filters.
 *
 * @param WP_Query $query WordPress query.
 * @return void
 */
function ftc_prepare_equipment_type_archive_query( $query ) {
	if ( is_admin() || ! $query->is_main_query() || ! $query->is_tax( 'equipment_type' ) ) {
		return;
	}

	$query->set( 'post_type', 'truck' );
	$query->set( 'post_status', 'publish' );
	$query->set( 'posts_per_page', -1 );
	$query->set( 'ignore_sticky_posts', true );
	$query->set( 'search_filter_id', ftc_get_truck_filter_form_id() );
	$query->set( 'meta_key', '_year' );
	$query->set( 'orderby', 'meta_value_num' );
	$query->set( 'order', 'DESC' );
}
add_action( 'pre_get_posts', 'ftc_prepare_equipment_type_archive_query', 20 );

/**
 * Remove Truck Types from Search & Filter form #59.
 *
 * Truck type selection is rendered as crawlable taxonomy links instead.
 *
 * @param bool   $display_field  Whether the field should be displayed.
 * @param int    $search_form_id Search & Filter form ID.
 * @param string $field_name     Search & Filter field name.
 * @return bool
 */
function ftc_hide_equipment_type_search_field( $display_field, $search_form_id, $field_name ) {
	if ( ftc_get_truck_filter_form_id() === (int) $search_form_id && '_sft_equipment_type' === $field_name ) {
		return false;
	}

	return $display_field;
}
add_filter( 'sf_display_field', 'ftc_hide_equipment_type_search_field', 20, 3 );

/**
 * Resolve the equipment type represented by the current request.
 *
 * The explicit query argument is carried to Search & Filter's AJAX form
 * endpoint, where WordPress is no longer in a taxonomy archive context.
 *
 * @return WP_Term|false
 */
function ftc_get_equipment_type_request_context() {
	if ( is_tax( 'equipment_type' ) ) {
		$term = get_queried_object();
		if ( $term instanceof WP_Term ) {
			return $term;
		}
	}

	if ( empty( $_GET['ftc_equipment_type'] ) || ! is_string( $_GET['ftc_equipment_type'] ) ) {
		return false;
	}

	$slug = sanitize_title( wp_unslash( $_GET['ftc_equipment_type'] ) );
	$term = get_term_by( 'slug', $slug, 'equipment_type' );

	return $term instanceof WP_Term ? $term : false;
}

/**
 * Scope Search & Filter results and option counts to the active Truck Type.
 *
 * The taxonomy archive condition on the main WordPress query is not inherited
 * by Search & Filter's internal count queries. Adding it through the plugin's
 * query filter keeps brands, chassis, pump and tank choices limited to trucks
 * that belong to the current equipment type.
 *
 * @param array $query_args     Search & Filter query arguments.
 * @param int   $search_form_id Search & Filter form ID.
 * @return array
 */
function ftc_scope_truck_filter_to_equipment_type( $query_args, $search_form_id ) {
	if ( ftc_get_truck_filter_form_id() !== (int) $search_form_id ) {
		return $query_args;
	}

	$term = ftc_get_equipment_type_request_context();
	if ( ! $term ) {
		return $query_args;
	}

	if ( empty( $query_args['tax_query'] ) || ! is_array( $query_args['tax_query'] ) ) {
		$query_args['tax_query'] = array();
	}

	$query_args['tax_query'][] = array(
		'taxonomy'         => 'equipment_type',
		'field'            => 'term_id',
		'terms'            => array( (int) $term->term_id ),
		'include_children' => true,
		'operator'         => 'IN',
	);

	return $query_args;
}
add_filter( 'sf_edit_query_args', 'ftc_scope_truck_filter_to_equipment_type', 20, 2 );

/**
 * Keep the remaining Search & Filter controls on the active taxonomy URL.
 *
 * @param array $attributes     Generated form attributes.
 * @param int   $search_form_id Search & Filter form ID.
 * @return array
 */
function ftc_equipment_type_filter_form_attributes( $attributes, $search_form_id ) {
	if ( ftc_get_truck_filter_form_id() !== (int) $search_form_id ) {
		return $attributes;
	}

	$term = ftc_get_equipment_type_request_context();
	if ( ! $term ) {
		return $attributes;
	}

	$term_url = get_term_link( $term );
	if ( is_wp_error( $term_url ) ) {
		return $attributes;
	}

	$attributes['action']           = $term_url;
	$attributes['data-results-url'] = $term_url;
	$attributes['data-ajax-url']    = add_query_arg(
		'sf_data',
		! empty( $attributes['data-auto-count'] ) ? 'all' : 'results',
		$term_url
	);

	if ( ! empty( $attributes['data-ajax-form-url'] ) ) {
		$attributes['data-ajax-form-url'] = add_query_arg(
			'ftc_equipment_type',
			$term->slug,
			$attributes['data-ajax-form-url']
		);
	}

	return $attributes;
}
add_filter( 'search_filter_form_attributes', 'ftc_equipment_type_filter_form_attributes', 20, 2 );

/**
 * Return an equipment type term URL, with aliases for old filter values.
 *
 * @param string $slug Term slug or historical Search & Filter value.
 * @return string
 */
function ftc_get_equipment_type_url( $slug ) {
	$aliases = array(
		'wildland-brush-trucks' => 'wildland-brush-4x4',
		'tanks'                 => 'tanker',
	);

	$slug = sanitize_title( $slug );
	if ( isset( $aliases[ $slug ] ) ) {
		$slug = $aliases[ $slug ];
	}

	$term = get_term_by( 'slug', $slug, 'equipment_type' );
	if ( $term instanceof WP_Term ) {
		$term_url = get_term_link( $term );
		if ( ! is_wp_error( $term_url ) ) {
			return $term_url;
		}
	}

	return function_exists( 'ftc_get_truck_catalog_url' )
		? ftc_get_truck_catalog_url()
		: home_url( '/search-fire-truck-for-sale/' );
}

/**
 * Redirect old parameter-based Truck Type results to the canonical archive.
 *
 * Other faceted filter parameters are retained. Search & Filter's internal
 * AJAX requests are deliberately left alone.
 *
 * @return void
 */
function ftc_redirect_legacy_equipment_type_filter() {
	if (
		is_admin()
		|| wp_doing_ajax()
		|| ! empty( $_GET['sf_data'] )
		|| empty( $_GET['_sft_equipment_type'] )
		|| ! is_string( $_GET['_sft_equipment_type'] )
	) {
		return;
	}

	$raw_slug = wp_unslash( $_GET['_sft_equipment_type'] );
	if ( false !== strpos( $raw_slug, ',' ) ) {
		return;
	}

	$target_url = ftc_get_equipment_type_url( $raw_slug );
	$remaining  = wp_unslash( $_GET );

	unset(
		$remaining['_sft_equipment_type'],
		$remaining['sf_data'],
		$remaining['sfid'],
		$remaining['sf_action'],
		$remaining['sf_paged'],
		$remaining['ftc_equipment_type']
	);

	$remaining = map_deep( $remaining, 'sanitize_text_field' );
	if ( ! empty( $remaining ) ) {
		$target_url = add_query_arg( $remaining, $target_url );
	}

	wp_safe_redirect( $target_url, 301 );
	exit;
}
add_action( 'template_redirect', 'ftc_redirect_legacy_equipment_type_filter', 20 );
