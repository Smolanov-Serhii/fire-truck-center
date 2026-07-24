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
$post_id = get_the_ID();
?>
    <main class="main brands-hub">
        <section class="brands-hub__hero" aria-labelledby="brands-hub-title">
            <div class="brands-hub__hero-inner main-container">
                <p class="brands-hub__eyebrow"><?php echo the_field('banner-untitle', $post_id) ?></p>
                <h1 class="brands-hub__hero-title" id="brands-hub-title"><?php echo the_field('title', $post_id) ?></h1>
                <p class="brands-hub__hero-text"><?php echo the_field('subtitle', $post_id) ?></p>
                <a class="brands-hub__hero-link" href="#truck-brands-directory">
                    <span><?php echo the_field('button_text', $post_id) ?></span>
                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
                        <path d="M9 3V15M9 15L14 10M9 15L4 10" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
            </div>
        </section>
        <?php get_template_part( 'template-parts/content', 'breadcrumbs' ); ?>
        <section class="brands-hub__directory" id="truck-brands-directory" aria-labelledby="brands-directory-title">
            <div class="main-container">
                <div class="brands-hub__section-heading">
                    <div>
                        <p class="brands-hub__eyebrow"><?php echo the_field('untitle-filter', $post_id) ?></p>
                        <h2 id="brands-directory-title"><?php echo the_field('title-filter', $post_id) ?></h2>
                    </div>
                    <p><?php echo the_field('subtitle-filter', $post_id) ?></p>
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
        <section class="brands-hub__intro main-container" aria-labelledby="brands-intro-title">
            <div class="brands-hub__intro-label">
                <span><?php echo the_field('untitle-block3', $post_id) ?></span>
            </div>
            <div class="brands-hub__intro-content">
                <h2 id="brands-intro-title"><?php echo the_field('title-block3', $post_id) ?></h2>
                <?php echo the_field('description-block3', $post_id) ?>
            </div>
        </section>
        <?php
        $steps_eyebrow = get_field( 'untitle-block4', $post_id );
        $steps_title   = get_field( 'title-block4', $post_id );
        $brand_steps   = array();

        if ( have_rows( 'items-block4', $post_id ) ) {
            while ( have_rows( 'items-block4', $post_id ) ) {
                the_row();

                $step_title    = get_sub_field( 'title' );
                $step_subtitle = get_sub_field( 'subtitle' );

                if ( ! $step_title && ! $step_subtitle ) {
                    continue;
                }

                $brand_steps[] = array(
                    'title'    => $step_title,
                    'subtitle' => $step_subtitle,
                );
            }
        }
        ?>
        <?php if ( $steps_eyebrow || $steps_title || $brand_steps ) : ?>
            <section
                class="brands-hub__steps main-container"
                <?php if ( $steps_title ) : ?>aria-labelledby="brands-steps-title"<?php endif; ?>
            >
                <?php if ( $steps_eyebrow || $steps_title ) : ?>
                    <div class="brands-hub__steps-heading">
                        <?php if ( $steps_eyebrow ) : ?>
                            <p class="brands-hub__eyebrow"><?php echo esc_html( $steps_eyebrow ); ?></p>
                        <?php endif; ?>
                        <?php if ( $steps_title ) : ?>
                            <h2 id="brands-steps-title"><?php echo esc_html( $steps_title ); ?></h2>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                <?php if ( $brand_steps ) : ?>
                    <ol class="brands-hub__steps-list">
                        <?php foreach ( $brand_steps as $step_index => $brand_step ) : ?>
                            <li>
                                <span class="brands-hub__step-number" aria-hidden="true"><?php echo esc_html( sprintf( '%02d', $step_index + 1 ) ); ?></span>
                                <?php if ( $brand_step['title'] ) : ?>
                                    <h3><?php echo esc_html( $brand_step['title'] ); ?></h3>
                                <?php endif; ?>
                                <?php if ( $brand_step['subtitle'] ) : ?>
                                    <p><?php echo esc_html( $brand_step['subtitle'] ); ?></p>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ol>
                <?php endif; ?>
            </section>
        <?php endif; ?>
        <section class="brands-hub__cta">
            <div class="brands-hub__cta-inner main-container">
                <div>
                    <p class="brands-hub__eyebrow"><?php echo the_field('untitle-block5', $post_id) ?></p>
                    <h2><?php echo the_field('title-block5', $post_id) ?></h2>
                    <p><?php echo the_field('subtitle-block5', $post_id) ?></p>
                </div>
                <div class="brands-hub__cta-actions">
                    <a class="brands-hub__button brands-hub__button--light" href="<?php echo esc_url( home_url( '/contact-us/' ) ); ?>">Contact us</a>
                    <a class="brands-hub__button brands-hub__button--outline" href="<?php echo esc_url( ftc_get_truck_catalog_url() ); ?>">View all trucks</a>
                </div>
            </div>
        </section>
        <section class="brands-hub__text" aria-label="<?php esc_attr_e( 'Fire truck manufacturer guide', 'fire-truck-center' ); ?>">
            <div class="brands-hub__text-inner main-container">
                <div class="brands-hub__article-content">
                    <?php the_content(); ?>
                </div>
            </div>
        </section>
        <?php get_template_part( 'template-parts/content', 'form' ); ?>
    </main>
<?php
get_footer();
