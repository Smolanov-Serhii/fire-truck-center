<?php
/**
 * Truck Type taxonomy archive.
 *
 * @package Fire_Truck_Center
 */

$truck_type      = get_queried_object();
$catalog_page_id = ftc_get_truck_catalog_page_id();
$banner_image    = $catalog_page_id && function_exists( 'get_field' ) ? get_field( 'image_banner', $catalog_page_id ) : '';
$banner_subtitle = $catalog_page_id && function_exists( 'get_field' ) ? get_field( 'subtitle_banner', $catalog_page_id ) : '';
$top_content     = $truck_type instanceof WP_Term && function_exists( 'get_field' ) ? get_field( 'top_content', $truck_type ) : '';
$bottom_content  = $truck_type instanceof WP_Term && function_exists( 'get_field' ) ? get_field( 'bottom_content', $truck_type ) : '';

if ( ! $bottom_content && $truck_type instanceof WP_Term ) {
	$bottom_content = term_description( $truck_type->term_id, 'equipment_type' );
}

if ( is_array( $banner_image ) && ! empty( $banner_image['url'] ) ) {
	$banner_image = $banner_image['url'];
} elseif ( is_numeric( $banner_image ) ) {
	$banner_image = wp_get_attachment_image_url( (int) $banner_image, 'full' );
}

$archive_title = $truck_type instanceof WP_Term
	? sprintf(
		/* translators: %s: truck type term name. */
		__( '%s Fire Trucks for Sale', 'fire-truck-center' ),
		$truck_type->name
	)
	: __( 'Fire Trucks for Sale', 'fire-truck-center' );

get_header();
?>
<main class="main">
	<section class="banner-image banner-image--taxonomy">
		<?php if ( $banner_image ) : ?>
			<div class="banner-image__image">
				<img src="<?php echo esc_url( $banner_image ); ?>" alt="<?php echo esc_attr( $archive_title ); ?>">
			</div>
		<?php endif; ?>
		<div class="banner-image__container small-container">
			<h1 class="banner-image__title"><?php echo esc_html( $archive_title ); ?></h1>
			<?php if ( $banner_subtitle ) : ?>
				<p class="banner-image__subtitle"><?php echo wp_kses_post( str_ireplace( '</br>', '<br>', $banner_subtitle ) ); ?></p>
			<?php endif; ?>
		</div>
	</section>

	<?php get_template_part( 'template-parts/content', 'breadcrumbs' ); ?>

	<div class="sale sale--taxonomy">
		<?php if ( $top_content ) : ?>
			<section class="sale__term-content sale__term-content--top main-container" aria-label="<?php esc_attr_e( 'Truck type overview', 'fire-truck-center' ); ?>">
				<div class="sale__term-content-inner">
					<?php echo wp_kses_post( $top_content ); ?>
				</div>
			</section>
		<?php endif; ?>

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
					<?php if ( have_posts() ) : ?>
						<?php while ( have_posts() ) : ?>
							<?php
							the_post();
							get_template_part( 'template-parts/content', 'truck-card' );
							?>
						<?php endwhile; ?>
					<?php else : ?>
						<p class="sale__empty"><?php esc_html_e( 'No trucks match the selected filters.', 'fire-truck-center' ); ?></p>
					<?php endif; ?>
				</div>
			</div>
		</div>

		<?php if ( $bottom_content ) : ?>
			<section class="sale__term-content sale__term-content--bottom main-container" aria-label="<?php esc_attr_e( 'About this truck type', 'fire-truck-center' ); ?>">
				<div class="sale__term-content-inner">
					<?php echo wp_kses_post( $bottom_content ); ?>
				</div>
			</section>
		<?php endif; ?>
	</div>
</main>
<?php
get_footer();
