<?php
/**
 * Truck catalog sidebar shared by the catalog and taxonomy archives.
 *
 * @package Fire_Truck_Center
 */
?>
<aside class="sale__sidebar" id="truck-filters" aria-label="<?php esc_attr_e( 'Truck filters', 'fire-truck-center' ); ?>">
	<button class="sale__sidebar-close" type="button" aria-label="<?php esc_attr_e( 'Close filters', 'fire-truck-center' ); ?>">
		<svg width="22" height="21" viewBox="0 0 22 21" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
			<path d="M21 1L1 20M21 20L1 1" stroke="black" stroke-width="2"/>
		</svg>
	</button>
	<?php get_template_part( 'template-parts/content', 'truck-types' ); ?>
	<?php get_template_part( 'template-parts/content', 'truck-brands' ); ?>
	<?php
	if ( shortcode_exists( 'searchandfilter' ) ) {
		echo do_shortcode( '[searchandfilter id="' . ftc_get_truck_filter_form_id() . '"]' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
	?>
</aside>
