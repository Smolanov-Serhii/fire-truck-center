<?php
/**
Template Name: Sell your truck
 */

$post_id = get_the_ID();
get_header();
?>
    <main class="main">
        <?php get_template_part( 'template-parts/content', 'banner-image' ); ?>
        <div class="sell-form">
            <div class="sell-form__container small-container">
                <?php echo do_shortcode('[contact-form-7 id="89cde8f" title="Sell your truck"]')?>
            </div>
        </div>
    </main>
<?php

get_footer();