<?php
/**
 * Template Name: Search all for sale
 *
 * @package Fire_Truck_Center
 */

$catalog_page_id = get_the_ID();
$catalog_content = get_post_field( 'post_content', $catalog_page_id );

get_header();
?>
<main class="main">
	<?php
	get_template_part(
		'template-parts/content',
		'banner-image',
		array( 'title' => __( 'Used Fire Trucks for Sale Inventory', 'fire-truck-center' ) )
	);
	?>
	<?php get_template_part( 'template-parts/content', 'breadcrumbs' ); ?>

	<div class="sale">
		<div class="sale__container main-container">
			<?php get_template_part( 'template-parts/content', 'truck-filter' ); ?>

			<div class="sale__main">
				<div class="sale__main-header">
					<button class="filter" type="button" aria-controls="truck-filters" aria-expanded="false">
						<svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
							<path d="M14.1 14.1L20.5 7.7V4.5H4.5V7.7L10.9 14.1V20.5L14.1 17.3V14.1Z" fill="white"/>
						</svg>
						<?php esc_html_e( 'Filter', 'fire-truck-center' ); ?>
					</button>
				</div>

				<div class="sale__result" id="result" aria-live="polite">
					<?php
					$truck_query = new WP_Query(
						array(
							'post_type'           => 'truck',
							'post_status'         => 'publish',
							'posts_per_page'      => -1,
							'search_filter_id'    => ftc_get_truck_filter_form_id(),
							'meta_key'            => '_year',
							'orderby'             => 'meta_value_num',
							'order'               => 'DESC',
							'ignore_sticky_posts' => true,
						)
					);

					if ( $truck_query->have_posts() ) {
						while ( $truck_query->have_posts() ) {
							$truck_query->the_post();
							get_template_part( 'template-parts/content', 'truck-card' );
						}
					} else {
						?>
						<p class="sale__empty"><?php esc_html_e( 'No trucks match the selected filters.', 'fire-truck-center' ); ?></p>
						<?php
					}
					wp_reset_postdata();
					?>
				</div>
			</div>
		</div>
	</div>

	<?php if ( trim( wp_strip_all_tags( $catalog_content ) ) ) : ?>
		<section class="sale__term-content main-container" aria-label="<?php esc_attr_e( 'About our inventory', 'fire-truck-center' ); ?>">
			<div class="sale__term-content-inner">
				<?php echo apply_filters( 'the_content', $catalog_content ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>
		</section>
	<?php endif; ?>
</main>
<?php
get_footer();
