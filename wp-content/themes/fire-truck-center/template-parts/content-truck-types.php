<?php
/**
 * Truck Type selector that navigates to real taxonomy term archives.
 *
 * @package Fire_Truck_Center
 */

$truck_types = get_terms(
	array(
		'taxonomy'   => 'equipment_type',
		'hide_empty' => true,
		'orderby'    => 'name',
		'order'      => 'ASC',
	)
);

if ( is_wp_error( $truck_types ) ) {
	return;
}

$current_term = is_tax( 'equipment_type' )
	? get_queried_object()
	: ftc_get_catalog_selected_filter_term( 'equipment_type' );
$taxonomy_availability = ftc_get_catalog_taxonomy_availability( wp_unslash( $_GET ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
$type_counts = isset( $taxonomy_availability['equipment_type'] ) ? $taxonomy_availability['equipment_type'] : array();

$preserved_filters = array();
foreach ( wp_unslash( $_GET ) as $key => $value ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	if (
		! is_string( $key )
		|| '_sft_equipment_type' === $key
		|| '_sft_truck_brands' === $key
		|| 'ftc_equipment_type' === $key
		|| 'ftc_truck_brands' === $key
		|| ! preg_match( '/^_(?:sft|sfm|sf_sort_order)/', $key )
	) {
		continue;
	}

	$preserved_filters[ sanitize_key( $key ) ] = map_deep( $value, 'sanitize_text_field' );
}

$catalog_url = ftc_get_truck_catalog_url();
if ( $preserved_filters ) {
	$catalog_url = add_query_arg( $preserved_filters, $catalog_url );
}
?>
<div class="truck-types">
	<form class="truck-types__form" action="<?php echo esc_url( ftc_get_truck_catalog_url() ); ?>" method="get">
		<ul>
			<li>
				<h4 id="truck-types-title"><?php esc_html_e( 'Truck Types', 'fire-truck-center' ); ?></h4>
				<label for="truck-types-select" class="screen-reader-text"><?php esc_html_e( 'Choose a truck type', 'fire-truck-center' ); ?></label>
				<select class="truck-types__select" id="truck-types-select" data-taxonomy="equipment_type" aria-labelledby="truck-types-title">
					<option value="<?php echo esc_url( $catalog_url ); ?>"<?php selected( ! $current_term ); ?>>
						<?php esc_html_e( 'All Trucks', 'fire-truck-center' ); ?>
					</option>
					<?php foreach ( $truck_types as $truck_type ) : ?>
						<?php
						$term_url = get_term_link( $truck_type );
						if ( is_wp_error( $term_url ) ) {
							continue;
						}
						if ( $preserved_filters ) {
							$term_url = add_query_arg( $preserved_filters, $term_url );
						}
						$is_current = $current_term instanceof WP_Term && $current_term->term_id === $truck_type->term_id;
						$available_count = isset( $type_counts[ $truck_type->slug ] ) ? (int) $type_counts[ $truck_type->slug ] : 0;
						$is_available = $is_current || 0 < $available_count;
						?>
						<option
							value="<?php echo esc_url( $term_url ); ?>"
							data-term-slug="<?php echo esc_attr( $truck_type->slug ); ?>"
							data-available-count="<?php echo esc_attr( $available_count ); ?>"
							<?php selected( $is_current ); ?>
							<?php disabled( ! $is_available ); ?>
						>
							<?php echo esc_html( $truck_type->name ); ?>
						</option>
					<?php endforeach; ?>
				</select>
			</li>
		</ul>
	</form>
</div>
