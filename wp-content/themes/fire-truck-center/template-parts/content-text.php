<section class="text">
    <div class="text__container main-container">
        <h2 class="text__title section-title">
            <?php echo the_field('title_text_block', $post_id) ?>
        </h2>
        <div class="text__content">
            <?php echo the_field('content_text_block', $post_id) ?>
        </div>
        <div class="text__lnk">
            <div class="button-skew">
                SEE NEW LISTINGS
            </div>
        </div>
    </div>
</section>