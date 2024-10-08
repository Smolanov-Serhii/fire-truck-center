<?php
$post_id = get_the_ID();
?>
<section class="equipment">
    <div class="equipment__container main-container">
        <h2 class="equipment__title section-title">
            <?php echo the_field('title_equipment_block', $post_id) ?>
        </h2>
        <div class="equipment__list">
            <?php
                if( have_rows('equipment_list', $post_id) ):
                    while( have_rows('equipment_list', $post_id) ) : the_row();
                        $image = get_sub_field('image_equipment');
                        $title = get_sub_field('title_equipment');
                        $url = get_sub_field('page_url');
                        $booking_url = get_permalink('60');
                        ?>
                            <a href="<?php echo $url;?>" class="equipment__item" target="_blank">
                                <img class="equipment__image" src="<?php echo $image;?>" alt="<?php echo $title;?>">
                                <h3 class="equipment__item-title"><?php echo $title;?></h3>
                            </a>
                        <?php
                    endwhile;
                endif;
            ?>
        </div>
    </div>
</section>