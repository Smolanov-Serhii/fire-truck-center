<?php
/**
Template Name: Home page
 */

$post_id = get_the_ID();
get_header();
?>
    <main class="main">
        <section class="banner">
            <div class="banner__image">
                <img src="<?php echo the_field('banner_image', $post_id) ?>" alt="">
            </div>
            <div class="banner__container">
                <h1 class="banner__title">
                    <?php echo the_field('banner_title', $post_id) ?>
                </h1>
                <h2 class="banner__subtitle">
                    <?php echo the_field('banner_subtitle', $post_id) ?>
                </h2>
                <a href="https://firetruck.center/search-fire-truck-for-sale/" class="banner__button button-skew">
                    View Trucks for Sale
                </a>
            </div>
        </section>
        <section class="vstavka">
            <div class="vstavka__container main-container">
                <h2 class="vstavka__title banner__subtitle"><?php echo the_field('slogan-title', $post_id) ?></h2>
            </div>
        </section>
        <?php get_template_part( 'template-parts/content', 'featured' ); ?>
        <?php get_template_part( 'template-parts/content', 'text' ); ?>
        <?php get_template_part( 'template-parts/content', 'equipment' ); ?>
        <?php get_template_part( 'template-parts/content', 'form' ); ?>
    </main>
<?php

get_footer();