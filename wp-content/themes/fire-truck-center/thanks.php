<?php
/**
Template Name: Thank you page
 */

$post_id = get_the_ID();
get_header();
?>
    <main class="main">
        <?php get_template_part( 'template-parts/content', 'banner-image' ); ?>
    </main>
<?php

//get_footer();