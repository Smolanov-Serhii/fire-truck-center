<?php
/**
 * Truck catalog and taxonomy archive integrations.
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
 * Build availability counts for the taxonomy selectors.
 *
 * The archive's own taxonomy navigates between term pages, while the opposite
 * taxonomy filters the current archive through AJAX. Each selector therefore
 * needs counts calculated without constraining its own taxonomy.
 *
 * @param array $request Filter query parameters.
 * @return array<string,array<string,int>> Counts keyed by taxonomy and slug.
 */
function ftc_get_catalog_taxonomy_availability( $request = array() ) {
	$request = is_array( $request ) ? $request : array();
	static $availability_cache = array();

	$catalog_filters = array(
		'equipment_type' => array(),
		'truck_brands'   => array(),
	);

	foreach ( array_keys( $catalog_filters ) as $taxonomy ) {
		foreach ( array( '_sft_' . $taxonomy, 'ftc_' . $taxonomy ) as $request_key ) {
			if ( empty( $request[ $request_key ] ) ) {
				continue;
			}

			$raw_value = is_array( $request[ $request_key ] )
				? implode( ',', array_map( 'strval', $request[ $request_key ] ) )
				: (string) $request[ $request_key ];

			$catalog_filters[ $taxonomy ] = array_merge(
				$catalog_filters[ $taxonomy ],
				array_filter( array_map( 'sanitize_title', explode( ',', $raw_value ) ) )
			);
		}

		if ( is_tax( $taxonomy ) ) {
			$archive_term = get_queried_object();
			if ( $archive_term instanceof WP_Term ) {
				$catalog_filters[ $taxonomy ][] = $archive_term->slug;
			}
		}

		$catalog_filters[ $taxonomy ] = array_values( array_unique( $catalog_filters[ $taxonomy ] ) );
	}

	$cache_key = md5(
		wp_json_encode(
			array(
				'request'         => $request,
				'catalog_filters' => $catalog_filters,
			)
		)
	);
	if ( isset( $availability_cache[ $cache_key ] ) ) {
		return $availability_cache[ $cache_key ];
	}

	$base_tax_query = array();

	foreach ( array( 'chassis_type', 'pump_size', 'tank_size' ) as $taxonomy ) {
		$query_key = '_sft_' . $taxonomy;
		if ( empty( $request[ $query_key ] ) ) {
			continue;
		}

		$raw_value = $request[ $query_key ];
		if ( is_array( $raw_value ) ) {
			$raw_value = implode( ',', array_map( 'strval', $raw_value ) );
		}

		$slugs = array_filter( array_map( 'sanitize_title', explode( ',', (string) $raw_value ) ) );
		if ( ! $slugs ) {
			continue;
		}

		$base_tax_query[] = array(
			'taxonomy' => $taxonomy,
			'field'    => 'slug',
			'terms'    => array_values( $slugs ),
			'operator' => 'IN',
		);
	}

	$meta_query = array();
	if ( ! empty( $request['_sfm__year'] ) ) {
		$raw_year = is_array( $request['_sfm__year'] )
			? implode( ' ', array_map( 'strval', $request['_sfm__year'] ) )
			: (string) $request['_sfm__year'];
		preg_match_all( '/\d{4}/', $raw_year, $year_matches );

		if ( ! empty( $year_matches[0] ) ) {
			$years = array_map( 'intval', $year_matches[0] );
			$min_year = min( $years );
			$max_year = max( $years );
			$meta_query[] = array(
				'key'     => '_year',
				'value'   => array( $min_year, $max_year ),
				'compare' => 'BETWEEN',
				'type'    => 'NUMERIC',
			);
		}
	}

	$base_query_args = array(
		'post_type'              => 'truck',
		'post_status'            => 'publish',
		'posts_per_page'         => -1,
		'fields'                 => 'ids',
		'no_found_rows'          => true,
		'ignore_sticky_posts'    => true,
		'update_post_meta_cache' => false,
		'update_post_term_cache' => false,
	);

	if ( $meta_query ) {
		$base_query_args['meta_query'] = $meta_query;
	}

	$availability = array(
		'equipment_type' => array(),
		'truck_brands'   => array(),
	);

	foreach ( array_keys( $availability ) as $taxonomy ) {
		$query_args = $base_query_args;
		$tax_query  = $base_tax_query;
		$other_taxonomy = 'equipment_type' === $taxonomy ? 'truck_brands' : 'equipment_type';

		// Facet counts must include the opposite archive/filter, but not
		// constrain themselves to the currently selected value.
		if ( $catalog_filters[ $other_taxonomy ] ) {
			$tax_query[] = array(
				'taxonomy' => $other_taxonomy,
				'field'    => 'slug',
				'terms'    => $catalog_filters[ $other_taxonomy ],
				'operator' => 'IN',
			);
		}

		if ( $tax_query ) {
			$query_args['tax_query'] = $tax_query;
		}

		$post_ids = get_posts( $query_args );
		if ( ! $post_ids ) {
			continue;
		}

		$terms = wp_get_object_terms(
			$post_ids,
			$taxonomy,
			array( 'fields' => 'all_with_object_id' )
		);

		if ( is_wp_error( $terms ) ) {
			continue;
		}

		$seen_relationships = array();
		foreach ( $terms as $term ) {
			$relationship_key = $term->object_id . ':' . $term->term_id;
			if ( isset( $seen_relationships[ $relationship_key ] ) ) {
				continue;
			}

			$seen_relationships[ $relationship_key ] = true;
			if ( ! isset( $availability[ $taxonomy ][ $term->slug ] ) ) {
				$availability[ $taxonomy ][ $term->slug ] = 0;
			}
			++$availability[ $taxonomy ][ $term->slug ];
		}
	}

	$availability_cache[ $cache_key ] = $availability;
	return $availability;
}

/**
 * Return refreshed availability for the two taxonomy navigation selects.
 *
 * @return void
 */
function ftc_ajax_catalog_taxonomy_availability() {
	$request = map_deep( wp_unslash( $_GET ), 'sanitize_text_field' ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	wp_send_json_success( ftc_get_catalog_taxonomy_availability( $request ) );
}
add_action( 'wp_ajax_ftc_catalog_taxonomy_availability', 'ftc_ajax_catalog_taxonomy_availability' );
add_action( 'wp_ajax_nopriv_ftc_catalog_taxonomy_availability', 'ftc_ajax_catalog_taxonomy_availability' );

/**
 * Expose Truck Types and Truck Brands as public inventory archives.
 *
 * @param array  $args        Taxonomy registration arguments.
 * @param string $taxonomy    Taxonomy name.
 * @param array  $object_type Object types assigned to the taxonomy.
 * @return array
 */
function ftc_enable_truck_catalog_taxonomy_archives( $args, $taxonomy, $object_type ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundAfterLastUsed
	$catalog_taxonomies = array( 'equipment_type', 'truck_brands' );
	if ( ! in_array( $taxonomy, $catalog_taxonomies, true ) ) {
		return $args;
	}

	$args['public']              = true;
	$args['publicly_queryable']  = true;
	$args['query_var']           = true;
	$args['show_ui']             = true;
	$args['show_admin_column']   = true;
	$args['show_in_nav_menus']   = true;
	$args['show_in_rest']        = true;
	$args['rewrite']             = array(
		'slug'         => $taxonomy,
		'with_front'   => false,
		'hierarchical' => false,
	);

	return $args;
}
add_filter( 'register_taxonomy_args', 'ftc_enable_truck_catalog_taxonomy_archives', 20, 3 );

/**
 * Flush rewrite rules once after enabling public catalog taxonomy archives.
 *
 * Production previously kept the old non-public taxonomy rules, causing all
 * /equipment_type/{term}/ URLs to return 404 even though the terms existed.
 *
 * @return void
 */
function ftc_maybe_flush_equipment_type_rewrite_rules() {
	$rewrite_version = '2';

	if ( $rewrite_version === get_option( 'ftc_equipment_type_rewrite_version' ) ) {
		return;
	}

	flush_rewrite_rules( false );
	update_option( 'ftc_equipment_type_rewrite_version', $rewrite_version, false );
}
add_action( 'init', 'ftc_maybe_flush_equipment_type_rewrite_rules', 99 );

/**
 * Prepare a Truck Type or Truck Brand archive as the filter result query.
 *
 * The taxonomy condition remains in the main query, while form #59 applies
 * the remaining year, brand, chassis, pump and tank filters.
 *
 * @param WP_Query $query WordPress query.
 * @return void
 */
function ftc_prepare_equipment_type_archive_query( $query ) {
	if (
		is_admin()
		|| ! $query->is_main_query()
		|| ! $query->is_tax( array( 'equipment_type', 'truck_brands' ) )
	) {
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
 * Expose only the opposite taxonomy to Search & Filter form #59.
 *
 * The visible custom selector syncs to that hidden plugin field so it can use
 * Search & Filter's AJAX query and history handling.
 *
 * @param bool   $display_field  Whether the field should be displayed.
 * @param int    $search_form_id Search & Filter form ID.
 * @param string $field_name     Search & Filter field name.
 * @return bool
 */
function ftc_hide_equipment_type_search_field( $display_field, $search_form_id, $field_name ) {
	$taxonomy_fields = array( '_sft_equipment_type', '_sft_truck_brands' );
	if (
		ftc_get_truck_filter_form_id() !== (int) $search_form_id
		|| ! in_array( $field_name, $taxonomy_fields, true )
	) {
		return $display_field;
	}

	if ( ftc_get_equipment_type_request_context() ) {
		return '_sft_equipment_type' !== $field_name;
	}

	if ( ftc_get_truck_brand_request_context() ) {
		return '_sft_truck_brands' !== $field_name;
	}

	// On the catalog hub both custom selectors navigate to taxonomy pages.
	return false;
}
add_filter( 'sf_display_field', 'ftc_hide_equipment_type_search_field', 20, 3 );

/**
 * Resolve a catalog taxonomy term represented by the current request.
 *
 * The explicit query argument is carried to Search & Filter's AJAX form
 * endpoint, where WordPress is no longer in a taxonomy archive context.
 *
 * @param string $taxonomy Catalog taxonomy name.
 * @return WP_Term|false
 */
function ftc_get_catalog_taxonomy_request_context( $taxonomy ) {
	if ( ! in_array( $taxonomy, array( 'equipment_type', 'truck_brands' ), true ) ) {
		return false;
	}

	if ( is_tax( $taxonomy ) ) {
		$term = get_queried_object();
		if ( $term instanceof WP_Term ) {
			return $term;
		}
	}

	$context_key = 'ftc_' . $taxonomy;
	if ( empty( $_GET[ $context_key ] ) || ! is_string( $_GET[ $context_key ] ) ) {
		return false;
	}

	$slug = sanitize_title( wp_unslash( $_GET[ $context_key ] ) );
	$term = get_term_by( 'slug', $slug, $taxonomy );

	return $term instanceof WP_Term ? $term : false;
}

/**
 * Return the taxonomy term selected through a Search & Filter query argument.
 *
 * @param string $taxonomy Catalog taxonomy name.
 * @return WP_Term|false
 */
function ftc_get_catalog_selected_filter_term( $taxonomy ) {
	if ( ! in_array( $taxonomy, array( 'equipment_type', 'truck_brands' ), true ) ) {
		return false;
	}

	$query_key = '_sft_' . $taxonomy;
	if ( empty( $_GET[ $query_key ] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		return false;
	}

	$raw_value = wp_unslash( $_GET[ $query_key ] ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	if ( is_array( $raw_value ) ) {
		$raw_value = reset( $raw_value );
	}
	if ( ! is_string( $raw_value ) ) {
		return false;
	}

	$slug = sanitize_title( strtok( $raw_value, ',' ) );
	if ( ! $slug ) {
		return false;
	}

	$term = get_term_by( 'slug', $slug, $taxonomy );
	return $term instanceof WP_Term ? $term : false;
}

/**
 * Resolve the equipment type represented by the current request.
 *
 * The explicit query argument is carried to Search & Filter's AJAX form
 * endpoint, where WordPress is no longer in a taxonomy archive context.
 *
 * @return WP_Term|false
 */
function ftc_get_equipment_type_request_context() {
	return ftc_get_catalog_taxonomy_request_context( 'equipment_type' );
}

/**
 * Resolve the Truck Brand represented by the current request.
 *
 * @return WP_Term|false
 */
function ftc_get_truck_brand_request_context() {
	return ftc_get_catalog_taxonomy_request_context( 'truck_brands' );
}

/**
 * Scope Search & Filter results and counts to the active taxonomy archive.
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

	$archive_tax_query = array();
	foreach ( array( 'equipment_type', 'truck_brands' ) as $taxonomy ) {
		$term = ftc_get_catalog_taxonomy_request_context( $taxonomy );
		if ( ! $term ) {
			continue;
		}

		$archive_tax_query[] = array(
			'taxonomy'         => $taxonomy,
			'field'            => 'term_id',
			'terms'            => array( (int) $term->term_id ),
			'include_children' => true,
			'operator'         => 'IN',
		);
	}

	if ( $archive_tax_query ) {
		if ( empty( $query_args['tax_query'] ) || ! is_array( $query_args['tax_query'] ) ) {
			$query_args['tax_query'] = array();
		}

		$query_args['tax_query'] = array_merge( $query_args['tax_query'], $archive_tax_query );
	}

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
		$term = ftc_get_truck_brand_request_context();
	}
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
			'ftc_' . $term->taxonomy,
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
 * Return a Truck Brand term URL.
 *
 * @param string $slug Brand term slug.
 * @return string
 */
function ftc_get_truck_brand_url( $slug ) {
	$slug = sanitize_title( $slug );
	$term = get_term_by( 'slug', $slug, 'truck_brands' );

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

/**
 * Redirect old parameter-based Truck Brand results to the brand archive.
 *
 * Other faceted parameters are retained; internal AJAX requests are ignored.
 *
 * @return void
 */
function ftc_redirect_legacy_truck_brand_filter() {
	if (
		is_admin()
		|| wp_doing_ajax()
		|| ! empty( $_GET['sf_data'] )
		|| empty( $_GET['_sft_truck_brands'] )
		|| ! is_string( $_GET['_sft_truck_brands'] )
	) {
		return;
	}

	$raw_slug = wp_unslash( $_GET['_sft_truck_brands'] );
	if ( false !== strpos( $raw_slug, ',' ) ) {
		return;
	}

	$target_url = ftc_get_truck_brand_url( $raw_slug );
	$remaining  = wp_unslash( $_GET );

	unset(
		$remaining['_sft_truck_brands'],
		$remaining['sf_data'],
		$remaining['sfid'],
		$remaining['sf_action'],
		$remaining['sf_paged'],
		$remaining['ftc_truck_brands']
	);

	$remaining = map_deep( $remaining, 'sanitize_text_field' );
	if ( ! empty( $remaining ) ) {
		$target_url = add_query_arg( $remaining, $target_url );
	}

	wp_safe_redirect( $target_url, 301 );
	exit;
}
add_action( 'template_redirect', 'ftc_redirect_legacy_truck_brand_filter', 21 );
