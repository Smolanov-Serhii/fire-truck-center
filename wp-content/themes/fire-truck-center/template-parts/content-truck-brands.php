<?php
/**
 * Truck Brand selector that navigates to real taxonomy term archives.
 *
 * @package Fire_Truck_Center
 */

$truck_brands = get_terms(
	array(
		'taxonomy'   => 'truck_brands',
		'hide_empty' => true,
		'orderby'    => 'name',
		'order'      => 'ASC',
	)
);

if ( is_wp_error( $truck_brands ) ) {
	return;
}

$current_brand = is_tax( 'truck_brands' )
	? get_queried_object()
	: ftc_get_catalog_selected_filter_term( 'truck_brands' );
$taxonomy_availability = ftc_get_catalog_taxonomy_availability( wp_unslash( $_GET ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
$brand_counts = isset( $taxonomy_availability['truck_brands'] ) ? $taxonomy_availability['truck_brands'] : array();

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
<div class="truck-types truck-brands">
	<form class="truck-types__form truck-brands__form" action="<?php echo esc_url( ftc_get_truck_catalog_url() ); ?>" method="get">
		<ul>
			<li>
				<h4 id="truck-brands-title"><?php esc_html_e( 'Truck Brands', 'fire-truck-center' ); ?></h4>
				<label for="truck-brands-select" class="screen-reader-text"><?php esc_html_e( 'Choose a truck brand', 'fire-truck-center' ); ?></label>
				<select class="truck-types__select truck-brands__select" id="truck-brands-select" data-taxonomy="truck_brands" aria-labelledby="truck-brands-title">
					<option value="<?php echo esc_url( $catalog_url ); ?>"<?php selected( ! $current_brand ); ?>>
						<?php esc_html_e( 'All Brands', 'fire-truck-center' ); ?>
					</option>
					<?php foreach ( $truck_brands as $truck_brand ) : ?>
						<?php
						$term_url = get_term_link( $truck_brand );
						if ( is_wp_error( $term_url ) ) {
							continue;
						}
						if ( $preserved_filters ) {
							$term_url = add_query_arg( $preserved_filters, $term_url );
						}
						$is_current = $current_brand instanceof WP_Term && $current_brand->term_id === $truck_brand->term_id;
						$available_count = isset( $brand_counts[ $truck_brand->slug ] ) ? (int) $brand_counts[ $truck_brand->slug ] : 0;
						$is_available = $is_current || 0 < $available_count;
						?>
						<option
							value="<?php echo esc_url( $term_url ); ?>"
							data-term-slug="<?php echo esc_attr( $truck_brand->slug ); ?>"
							data-available-count="<?php echo esc_attr( $available_count ); ?>"
							<?php selected( $is_current ); ?>
							<?php disabled( ! $is_available ); ?>
						>
							<?php echo esc_html( $truck_brand->name ); ?>
						</option>
					<?php endforeach; ?>
				</select>
			</li>
		</ul>
	</form>
</div>
