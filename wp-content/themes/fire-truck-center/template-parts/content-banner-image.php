<?php
$post_id = get_the_ID();
$title   = ! empty( $args['title'] ) ? $args['title'] : get_field( 'title_banner', $post_id );
?>
<section class="banner-image">
    <div class="banner-image__image">
        <img src="<?php echo the_field('image_banner', $post_id) ?>" alt="<?php echo esc_attr( $title ); ?>">
    </div>
    <div class="banner-image__container small-container">
        <h1 class="banner-image__title">
            <?php echo esc_html( $title ); ?>
        </h1>
        <h2 class="banner-image__subtitle">
            <?php echo the_field('subtitle_banner', $post_id) ?>
        </h2>
    </div>
</section>
