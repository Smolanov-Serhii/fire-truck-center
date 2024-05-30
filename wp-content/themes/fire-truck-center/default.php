<?php
/**
Template Name: Default
 */

$post_id = get_the_ID();
get_header();
?>
    <main class="main">
        <?php get_template_part( 'template-parts/content', 'banner-image' ); ?>
        <div class="main-container">
            <div class="text default-page">
                <?php the_content();?>
            </div>
        </div>
    </main>
<?php

get_footer();