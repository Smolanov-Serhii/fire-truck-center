<?php
$post_id = get_the_ID();
get_header();
?>
    <main class="main">
        <div class="truck-single main-container">
            <div class="truck-single__img">
                <div class="big truck-single__swiper swiper">
                    <div class="truck-single__wrapper swiper-wrapper">
                        <?php if( have_rows('image_slider') ): ?>
                            <?php while( have_rows('image_slider') ): the_row();
                                $image = get_sub_field('slide_image');
                                ?>
                                <div class="truck-single__slide swiper-slide">
                                    <img src="<?php echo $image;?>" alt="<?php the_title();?>">
                                </div>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
                <div class="small swiper">
                    <div class="truck-single__wrapper swiper-wrapper">
                        <?php if( have_rows('image_slider') ): ?>
                            <?php while( have_rows('image_slider') ): the_row();
                                $image = get_sub_field('slide_image');
                                ?>
                                <div class="truck-single__slide swiper-slide">
                                    <img src="<?php echo $image;?>" alt="<?php the_title();?>">
                                </div>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="truck-single__content">
                <h1 class="truck-single__title">
                    <?php the_title();?>
                </h1>
                <div class="truck-single__sku">
                    <?php echo the_field('sku', $post_id) ?>
                </div>
                <div class="truck-single__price">
                    $<?php echo number_format(get_field('_price', $post_id), 2, '.', ','); ; ?>
                </div>
                <div class="truck-single__meta">
                    <div class="truck-single__row">
                        <div class="name">
                            Truck Type
                        </div>
                        <div class="value">
                            <?php
                            $terms = get_the_terms( $post_id, 'truck_types' );
                            if( $terms ){
                                $term = array_shift( $terms );
                                echo $term->name;
                            } else {
                                echo "N/A";
                            }
                            ?>
                        </div>
                    </div>
                    <div class="truck-single__row">
                        <div class="name">
                            Manufacturer
                        </div>
                        <div class="value">
                            <?php
                            $terms = get_the_terms( $post_id, 'truck_brands' );
                            if( $terms ){
                                $term = array_shift( $terms );
                                echo $term->name;
                            } else {
                                echo "N/A";
                            }
                            ?>
                        </div>
                    </div>
                    <div class="truck-single__row">
                        <div class="name">
                            Year Built
                        </div>
                        <div class="value">
                            <?php echo the_field('_year', $post_id) ?>
                        </div>
                    </div>
                    <div class="truck-single__row">
                        <div class="name">
                            Mileage
                        </div>
                        <div class="value">
                            <?php
                            $terms = get_the_terms( $post_id, 'mileage' );
                            if( $terms ){
                                $term = array_shift( $terms );
                            } else {
                                echo "N/A";
                            }
                            ?>
                            <?php echo number_format($term->name, 0, ',', ','); ; ?>
                        </div>
                    </div>
                    <div class="truck-single__row">
                        <div class="name">
                            Location
                        </div>
                        <div class="value">
                            <?php
                            $terms = get_the_terms( $post_id, 'geographic_region' );
                            if( $terms ){
                                $term = array_shift( $terms );
                                echo $term->name;
                            } else {
                                echo "N/A";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="truck-single__tabs tabs-elements">
                <div class="truck-single__tabs-header">
                    <div class="tabs-nav-item">Description</div>
                    <div class="tabs-nav-item">General</div>
                    <div class="tabs-nav-item">Pump</div>
                </div>
                <div class="truck-single__tabs-content">
                    <div class="tabs-content-item"><?php the_field('description', $post_id) ?></div>
                    <div class="tabs-content-item" style="display: none;"><?php the_field('general', $post_id) ?></div>
                    <div class="tabs-content-item" style="display: none;"><?php the_field('pump', $post_id) ?></div>
                </div>
            </div>
        </div>
    </main>
<?php

get_footer();