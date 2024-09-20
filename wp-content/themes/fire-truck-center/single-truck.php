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
                                $image_url = $image['sizes']['large'];
                                ?>
                                <div class="truck-single__slide swiper-slide">
                                    <img src="<?php echo $image_url;?>" alt="<?php the_title();?>">
                                </div>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </div>
                    <div class="swiper-button-next">
                        <svg width="9" height="28" viewBox="0 0 9 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0.241865 25.6392C0.164607 25.7728 0.104209 25.93 0.0641187 26.1017C0.0240285 26.2734 0.00503087 26.4563 0.00821161 26.64C0.0113924 26.8238 0.0366888 27.0047 0.0826563 27.1724C0.128624 27.3401 0.194362 27.4914 0.276118 27.6177C0.357874 27.7439 0.454048 27.8426 0.559146 27.9081C0.664244 27.9736 0.776209 28.0046 0.888649 27.9994C1.00109 27.9942 1.1118 27.9529 1.21446 27.8778C1.31713 27.8027 1.40973 27.6953 1.48699 27.5617L8.76593 14.9691C8.91625 14.7093 9 14.3654 9 14.0079C9 13.6504 8.91625 13.3064 8.76593 13.0466L1.48699 0.452614C1.41025 0.316109 1.31766 0.205879 1.21462 0.12833C1.11158 0.050781 1.00013 0.00745853 0.886759 0.000877017C0.773383 -0.00570449 0.660338 0.0245884 0.554188 0.0899936C0.448038 0.155399 0.3509 0.254612 0.268416 0.381874C0.185932 0.509136 0.119747 0.661908 0.0737046 0.831317C0.0276622 1.00072 0.00268053 1.18339 0.000210412 1.36871C-0.00225971 1.55403 0.0178308 1.7383 0.0593155 1.91082C0.1008 2.08334 0.162852 2.24068 0.241867 2.37369L6.96589 14.0079L0.241865 25.6392Z" fill="#26241F"/>
                        </svg>
                    </div>
                    <div class="swiper-button-prev">
                        <svg width="9" height="28" viewBox="0 0 9 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8.75814 2.36076C8.83539 2.22718 8.89579 2.07004 8.93588 1.89833C8.97597 1.72661 8.99497 1.54367 8.99179 1.35995C8.98861 1.17624 8.96331 0.995344 8.91734 0.827602C8.87138 0.65986 8.80564 0.508554 8.72388 0.382323C8.64213 0.256092 8.54595 0.157407 8.44085 0.0919039C8.33576 0.0264006 8.22379 -0.0046388 8.11135 0.000558256C7.99891 0.00575531 7.8882 0.0470868 7.78554 0.122193C7.68287 0.197299 7.59027 0.304709 7.51301 0.43829L0.234078 13.0309C0.0837583 13.2907 2.38395e-06 13.6346 2.44646e-06 13.9921C2.50897e-06 14.3496 0.0837585 14.6936 0.234078 14.9534L7.51301 27.5474C7.58976 27.6839 7.68235 27.7941 7.78539 27.8717C7.88843 27.9492 7.99987 27.9925 8.11325 27.9991C8.22662 28.0057 8.33967 27.9754 8.44582 27.91C8.55197 27.8446 8.64911 27.7454 8.73159 27.6181C8.81407 27.4909 8.88026 27.3381 8.9263 27.1687C8.97234 26.9993 8.99733 26.8166 8.9998 26.6313C9.00227 26.446 8.98218 26.2617 8.94069 26.0892C8.89921 25.9167 8.83715 25.7593 8.75814 25.6263L2.03412 13.9921L8.75814 2.36076Z" fill="#26241F"/>
                        </svg>
                    </div>
                </div>
                <div class="small swiper">
                    <div class="truck-single__wrapper swiper-wrapper">
                        <?php if( have_rows('image_slider') ): ?>
                            <?php while( have_rows('image_slider') ): the_row();
                                $image = get_sub_field('slide_image');
                                $image_url = $image['sizes']['medium'];
                                ?>
                                <div class="truck-single__slide swiper-slide">
                                    <img src="<?php echo $image_url;?>" alt="<?php the_title();?>">
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
<!--                <div class="truck-single__price">-->
<!--                    --><?php
//                    if (get_field('_price', $post_id)){
//                        echo '$' . number_format(get_field('_price', $post_id), 2, '.', ',');
//                    } else {
//                        echo 'N/A';
//                    }
//                    ?>
<!--                    --><?php //?>
<!---->
<!--                </div>-->
                <div class="truck-single__meta">
                    <div class="truck-single__row">
                        <div class="name">
                            Truck Type
                        </div>
                        <div class="value">
                            <?php
                            $terms = get_the_terms( $post_id, 'equipment_type' );
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
                <div class="truck-single__button">
                    <?php echo do_shortcode( '[contact-form-7 id="3ae4a73" title="Get a price"]' ); ?>
<!--                    <a href="https://firetruck.center/contact-us/" class="button-skew">-->
<!--                        <span>Get a price</span>-->
<!--                    </a>-->
                </div>
            </div>
            <div class="truck-single__tabs tabs-elements">
                <div class="truck-single__tabs-header">
                    <div class="tabs-nav-item">Description</div>
<!--                    <div class="tabs-nav-item">General</div>-->
<!--                    <div class="tabs-nav-item">Pump</div>-->
                </div>
                <div class="truck-single__tabs-content">
                    <div class="tabs-content-item"><?php the_field('description', $post_id) ?></div>
<!--                    <div class="tabs-content-item" style="display: none;">--><?php //the_field('general', $post_id) ?><!--</div>-->
<!--                    <div class="tabs-content-item" style="display: none;">--><?php //the_field('pump', $post_id) ?><!--</div>-->
                </div>
            </div>
        </div>
        <?php get_template_part( 'template-parts/content', 'featured' ); ?>
        <?php
            if (get_field('text_block', $post_id)){
                ?>
                <section class="text">
                    <div class="text__container main-container">
                        <div class="text__content">
                            <?php echo the_field('text_block', $post_id) ?>
                        </div>
                    </div>
                </section>
                <?php
            }
        ?>
    </main>
<?php

get_footer();