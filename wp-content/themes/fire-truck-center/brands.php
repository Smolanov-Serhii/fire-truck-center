<?php
/**
 * Template Name: Truck Brands Hub
 *
 * Static landing page with a dynamic Truck Brands directory.
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
	$truck_brands = array();
}

get_header();
?>
<main class="main brands-hub">
	<section class="brands-hub__hero" aria-labelledby="brands-hub-title">
		<div class="brands-hub__hero-inner main-container">
			<p class="brands-hub__eyebrow">Used fire trucks by manufacturer</p>
			<h1 class="brands-hub__hero-title" id="brands-hub-title">Fire Truck Brands</h1>
			<p class="brands-hub__hero-text">Explore available apparatus from trusted manufacturers and find the right truck for your department.</p>
			<a class="brands-hub__hero-link" href="#truck-brands-directory">
				<span>Explore brands</span>
				<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
					<path d="M9 3V15M9 15L14 10M9 15L4 10" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
			</a>
		</div>
	</section>

	<?php get_template_part( 'template-parts/content', 'breadcrumbs' ); ?>

	<section class="brands-hub__intro main-container" aria-labelledby="brands-intro-title">
		<div class="brands-hub__intro-label">
			<span>Shop by manufacturer</span>
		</div>
		<div class="brands-hub__intro-content">
			<h2 id="brands-intro-title">Find the right fire apparatus from a manufacturer you trust</h2>
			<p>Browse our used fire truck inventory by brand. Every listing includes detailed specifications, photos and the information your department needs to compare available apparatus.</p>
			<p>Our team can also help with inspections, pump testing, aerial certifications, financing and worldwide delivery.</p>
		</div>
	</section>

	<section class="brands-hub__directory" id="truck-brands-directory" aria-labelledby="brands-directory-title">
		<div class="main-container">
			<div class="brands-hub__section-heading">
				<div>
					<p class="brands-hub__eyebrow">Current inventory</p>
					<h2 id="brands-directory-title">Browse Fire Truck Brands</h2>
				</div>
				<p>Select a manufacturer to view all fire trucks currently listed under that brand.</p>
			</div>

			<?php if ( $truck_brands ) : ?>
				<ul class="brands-hub__grid">
					<?php foreach ( $truck_brands as $brand_index => $truck_brand ) : ?>
						<?php
						$brand_url = get_term_link( $truck_brand );
						if ( is_wp_error( $brand_url ) ) {
							continue;
						}

						$inventory_label = sprintf(
							/* translators: %s: number of trucks available. */
							_n( '%s truck available', '%s trucks available', (int) $truck_brand->count, 'fire-truck-center' ),
							number_format_i18n( (int) $truck_brand->count )
						);
						?>
						<li class="brands-hub__brand-item">
							<a class="brands-hub__brand-card" href="<?php echo esc_url( $brand_url ); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'View %s fire trucks', 'fire-truck-center' ), $truck_brand->name ) ); ?>">
								<span class="brands-hub__brand-number" aria-hidden="true"><?php echo esc_html( sprintf( '%02d', $brand_index + 1 ) ); ?></span>
								<span class="brands-hub__brand-name"><?php echo esc_html( $truck_brand->name ); ?></span>
								<span class="brands-hub__brand-meta"><?php echo esc_html( $inventory_label ); ?></span>
								<span class="brands-hub__brand-arrow" aria-hidden="true">
									<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" focusable="false">
										<path d="M5 12H19M19 12L13 6M19 12L13 18" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
									</svg>
								</span>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php else : ?>
				<p class="brands-hub__empty">Brand inventory is being updated. Please check back soon.</p>
			<?php endif; ?>
		</div>
	</section>

	<section class="brands-hub__steps main-container" aria-labelledby="brands-steps-title">
		<div class="brands-hub__steps-heading">
			<p class="brands-hub__eyebrow">A straightforward process</p>
			<h2 id="brands-steps-title">From inventory search to delivery</h2>
		</div>
		<ol class="brands-hub__steps-list">
			<li>
				<span class="brands-hub__step-number">01</span>
				<h3>Choose a manufacturer</h3>
				<p>Open a brand page to see every matching truck in one place.</p>
			</li>
			<li>
				<span class="brands-hub__step-number">02</span>
				<h3>Compare the apparatus</h3>
				<p>Review years, chassis, pump and tank specifications across the available inventory.</p>
			</li>
			<li>
				<span class="brands-hub__step-number">03</span>
				<h3>Talk with our team</h3>
				<p>Get answers about condition, testing, financing and delivery before you purchase.</p>
			</li>
		</ol>
	</section>

	<section class="brands-hub__cta">
		<div class="brands-hub__cta-inner main-container">
			<div>
				<p class="brands-hub__eyebrow">Need help finding a truck?</p>
				<h2>Tell us what your department needs</h2>
				<p>We will help narrow the inventory and identify the apparatus that best fits your requirements and budget.</p>
			</div>
			<div class="brands-hub__cta-actions">
				<a class="brands-hub__button brands-hub__button--light" href="<?php echo esc_url( home_url( '/contact-us/' ) ); ?>">Contact us</a>
				<a class="brands-hub__button brands-hub__button--outline" href="<?php echo esc_url( ftc_get_truck_catalog_url() ); ?>">View all trucks</a>
			</div>
		</div>
	</section>
</main>
<?php
get_footer();
