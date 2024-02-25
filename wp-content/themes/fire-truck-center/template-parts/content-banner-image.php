<?php
$post_id = get_the_ID();
?>
<section class="banner-image">
    <div class="banner-image__image">
        <img src="<?php echo the_field('image_banner', $post_id) ?>" alt="<?php echo the_field('title_banner', $post_id) ?>">
    </div>
    <div class="banner-image__container small-container">
        <h1 class="banner-image__title">
            <?php echo the_field('title_banner', $post_id) ?>
        </h1>
        <h2 class="banner-image__subtitle">
            <?php echo the_field('subtitle_banner', $post_id) ?>
        </h2>
    </div>
</section>