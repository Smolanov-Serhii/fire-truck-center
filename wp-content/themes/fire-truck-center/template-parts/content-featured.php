<section class="featured">
    <div class="featured__container main-container">
        <h2 class="featured__title section-title">
            <strong>Featured</strong> Listings
        </h2>
        <div class="featured__list swiper">
            <div class="featured__wrapper swiper-wrapper">
                <?php
                $result = wp_get_recent_posts( [
                    'numberposts'      => 10,
                    'offset'           => 0,
                    'category'         => 0,
                    'orderby'          => 'post_date',
                    'order'            => 'DESC',
                    'include'          => '',
                    'exclude'          => '',
                    'meta_key'         => '',
                    'meta_value'       => '',
                    'post_type'        => 'truck',
                    'post_status'      => 'draft, publish, future, pending, private',
                    'suppress_filters' => true,
                ], OBJECT );
                foreach( $result as $post ){
                    $post_id = get_the_ID();
                    $sku = get_field('sku', $post_id);
                    $price = get_field('_price', $post_id);
                    ?>
                    <div class="featured__item swiper-slide">
                        <a href="<?php the_permalink();?>" class="featured__item-img" title="<?php the_title();?>">
                            <?php the_post_thumbnail( 'full' );?>
                        </a>
                        <a href="<?php the_permalink();?>" class="featured__item-desc" title="<?php the_title();?>">
                            <h3 class="featured__item-title">
                                <?php the_title();?>
                            </h3>
                            <span class="featured__item-code">
                                <?php echo $sku ?>
                        </span>
                        </a>
                        <div class="featured__item-bottom">
                            <div class="price">
                                $<?php echo number_format($price, 2, '.', ','); ; ?>
                            </div>
                            <a href="<?php the_permalink();?>" class="more" title="<?php the_title();?>">
                                <img src="<?php echo get_template_directory_uri(); ?>/img/header/more.svg" alt="<?php the_title();?>">
                            </a>
                        </div>
                    </div>
                    <?php
                }
                wp_reset_postdata();
                ?>
                <div class="featured__item swiper-slide">
                    <a href="#" class="featured__item-img" title="2014 Pierce Velocity Pumper 1500/750">
                        <img src="<?php echo get_template_directory_uri(); ?>/img/featured/1.png" alt="2014 Pierce Velocity Pumper 1500/750">
                    </a>
                    <a href="#" class="featured__item-desc" title="2014 Pierce Velocity Pumper 1500/750">
                        <h3 class="featured__item-title">
                            2014 Pierce Velocity Pumper 1500/750
                        </h3>
                        <span class="featured__item-code">
                            E4776
                        </span>
                    </a>
                    <div class="featured__item-bottom">
                        <div class="price">
                            $399,000.00
                        </div>
                        <a href="#" class="more" title="2014 Pierce Velocity Pumper 1500/750">
                            <img src="<?php echo get_template_directory_uri(); ?>/img/header/more.svg" alt="2014 Pierce Velocity Pumper 1500/750">
                        </a>
                    </div>
                </div>
                <div class="featured__item swiper-slide">
                    <a href="#" class="featured__item-img" title="2014 Pierce Velocity Pumper 1500/750">
                        <img src="<?php echo get_template_directory_uri(); ?>/img/featured/2.png" alt="2014 Pierce Velocity Pumper 1500/750">
                    </a>
                    <a href="#" class="featured__item-desc" title="2014 Pierce Velocity Pumper 1500/750">
                        <h3 class="featured__item-title">
                            2004 Freightliner FL80 Rescue Pumper 1000/1200
                        </h3>
                        <span class="featured__item-code">
                            E4778
                        </span>
                    </a>
                    <div class="featured__item-bottom">
                        <div class="price">
                            $54,900.00
                        </div>
                        <a href="#" class="more" title="2014 Pierce Velocity Pumper 1500/750">
                            <img src="<?php echo get_template_directory_uri(); ?>/img/header/more.svg" alt="2014 Pierce Velocity Pumper 1500/750">
                        </a>
                    </div>
                </div>
                <div class="featured__item swiper-slide">
                    <a href="#" class="featured__item-img" title="2014 Pierce Velocity Pumper 1500/750">
                        <img src="<?php echo get_template_directory_uri(); ?>/img/featured/3.png" alt="2014 Pierce Velocity Pumper 1500/750">
                    </a>
                    <a href="#" class="featured__item-desc" title="2014 Pierce Velocity Pumper 1500/750">
                        <h3 class="featured__item-title">
                            1966 American LaFrance Original Antique Pumper
                        </h3>
                        <span class="featured__item-code">
                            U0946
                        </span>
                    </a>
                    <div class="featured__item-bottom">
                        <div class="price">
                            $28,000.00
                        </div>
                        <a href="#" class="more" title="2014 Pierce Velocity Pumper 1500/750">
                            <img src="<?php echo get_template_directory_uri(); ?>/img/header/more.svg" alt="2014 Pierce Velocity Pumper 1500/750">
                        </a>
                    </div>
                </div>
                <div class="featured__item swiper-slide">
                    <a href="#" class="featured__item-img" title="2014 Pierce Velocity Pumper 1500/750">
                        <img src="<?php echo get_template_directory_uri(); ?>/img/featured/4.png" alt="2014 Pierce Velocity Pumper 1500/750">
                    </a>
                    <a href="#" class="featured__item-desc" title="2014 Pierce Velocity Pumper 1500/750">
                        <h3 class="featured__item-title">
                            2002 International 4800 Wildland
                        </h3>
                        <span class="featured__item-code">
                            W1386
                        </span>
                    </a>
                    <div class="featured__item-bottom">
                        <div class="price">
                            $79,900.00
                        </div>
                        <a href="#" class="more" title="2014 Pierce Velocity Pumper 1500/750">
                            <img src="<?php echo get_template_directory_uri(); ?>/img/header/more.svg" alt="2014 Pierce Velocity Pumper 1500/750">
                        </a>
                    </div>
                </div>
                <div class="featured__item swiper-slide">
                    <a href="#" class="featured__item-img" title="2014 Pierce Velocity Pumper 1500/750">
                        <img src="<?php echo get_template_directory_uri(); ?>/img/featured/1.png" alt="2014 Pierce Velocity Pumper 1500/750">
                    </a>
                    <a href="#" class="featured__item-desc" title="2014 Pierce Velocity Pumper 1500/750">
                        <h3 class="featured__item-title">
                            2014 Pierce Velocity Pumper 1500/750
                        </h3>
                        <span class="featured__item-code">
                            E4776
                        </span>
                    </a>
                    <div class="featured__item-bottom">
                        <div class="price">
                            $399,000.00
                        </div>
                        <a href="#" class="more" title="2014 Pierce Velocity Pumper 1500/750">
                            <img src="<?php echo get_template_directory_uri(); ?>/img/header/more.svg" alt="2014 Pierce Velocity Pumper 1500/750">
                        </a>
                    </div>
                </div>
                <div class="featured__item swiper-slide">
                    <a href="#" class="featured__item-img" title="2014 Pierce Velocity Pumper 1500/750">
                        <img src="<?php echo get_template_directory_uri(); ?>/img/featured/2.png" alt="2014 Pierce Velocity Pumper 1500/750">
                    </a>
                    <a href="#" class="featured__item-desc" title="2014 Pierce Velocity Pumper 1500/750">
                        <h3 class="featured__item-title">
                            2004 Freightliner FL80 Rescue Pumper 1000/1200
                        </h3>
                        <span class="featured__item-code">
                            E4778
                        </span>
                    </a>
                    <div class="featured__item-bottom">
                        <div class="price">
                            $54,900.00
                        </div>
                        <a href="#" class="more" title="2014 Pierce Velocity Pumper 1500/750">
                            <img src="<?php echo get_template_directory_uri(); ?>/img/header/more.svg" alt="2014 Pierce Velocity Pumper 1500/750">
                        </a>
                    </div>
                </div>
            </div>
            <div class="featured__pagination swiper-pagination"></div>
        </div>
    </div>
</section>