<?php
/**
Template Name: Search all for sale
 */

$post_id = get_the_ID();
get_header();
?>
    <main class="main">
        <?php get_template_part( 'template-parts/content', 'banner-image' ); ?>
        <div class="sale">
            <div class="sale__container main-container">
                <aside class="sale__sidebar">
                    <div class="sale__sidebar-close">
                        <svg width="22" height="21" viewBox="0 0 22 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M21 1L1 20M21 20L1 1" stroke="black" stroke-width="2"/>
                        </svg>
                    </div>
                    <?php echo do_shortcode('[searchandfilter id="59"]')?>
                </aside>
                <div class="sale__main">
                    <div class="sale__main-header">
                        <div class="filter">
                            <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_1106_14204)">
                                    <path d="M14.1 14.1L20.5 7.7V4.5H4.5V7.7L10.9 14.1V20.5L14.1 17.3V14.1Z" fill="white"/>
                                </g>
                                <defs>
                                    <clipPath id="clip0_1106_14204">
                                        <rect width="16" height="16" fill="white" transform="translate(4.5 4.5)"/>
                                    </clipPath>
                                </defs>
                            </svg>
                            Filter
                        </div>
                    </div>
                    <div class="sale__result" id="result">
                        <?php
                        $args = array(
                            'post_type' => 'treners',
                            'relation' => 'OR',
                            'showposts' => "-1", //сколько показать статей
                            'search_filter_id' => 59, //сколько показать статей
                            'orderby' => "menu_order", //сортировка по дате
                            'caller_get_posts' => 1);
                        $my_query = new wp_query($args);
                        if ($my_query->have_posts()) {
                            while ($my_query->have_posts()) {
                                $my_query->the_post();
                                $postpers_id = get_the_ID();
                                $sku = get_field('sku', $postpers_id);
                                $price = get_field('_price', $postpers_id);
                                ?>
                                <?php
                                if ( wp_is_mobile() ) {
                                    ?>
                                    <a href="<?php the_permalink();?>" class="sale__item" target="_blank" title="<?php the_title(); ?>">
                                        <div class="sale__item-image">
                                            <?php the_post_thumbnail( 'large' );?>
                                        </div>
                                        <h3 class="sale__item-title">
                                            <?php the_title(); ?>
                                        </h3>
                                        <div class="sale__item-sku">
                                            <?php echo $sku; ?>
                                        </div>
                                        <div class="sale__item-price">
<!--                                            $--><?php //echo number_format($price, 2, '.', ','); ; ?>
                                            More
                                        </div>
                                        <div class="sale__item-lnk">
                                            <svg width="61" height="41" viewBox="0 0 61 41" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M15.4999 -9.65013e-07L28.9999 -2.18894e-06L17.4615 41L3.96143 41L15.4999 -9.65013e-07Z" fill="#C92D36"/>
                                                <path d="M34.25 -6.1975e-05L39.75 -6.24995e-05L28.5 40.9999L23 40.9999L34.25 -6.1975e-05Z" fill="#C92D36"/>
                                                <path d="M11.3704 -9.94036e-07L61 0.000112342L61 41L3.05188e-06 40.9999L11.3704 -9.94036e-07Z" fill="#C92D36"/>
                                                <path d="M26.9998 23L26.9998 17L34.9998 17L34.9998 12.16L42.8398 20L34.9998 27.84L34.9998 23L26.9998 23Z" fill="white"/>
                                            </svg>
                                        </div>
                                    </a>
                                    <?php
                                } else {
                                    ?>
                                    <a href="<?php the_permalink();?>" class="sale__item ">
                                        <div class="sale__item-image">
                                            <?php the_post_thumbnail( 'large' );?>
                                        </div>
                                        <h3 class="sale__item-title">
                                            <?php the_title(); ?>
                                        </h3>
                                        <div class="sale__item-sku">
                                            <?php echo $sku; ?>
                                        </div>
                                        <div class="sale__item-price">
                                            <?php
//                                            if ($price){
//                                                echo '$' . number_format($price, 0, '.', ',');
//                                            } else {
//                                                echo 'More';
//                                            }
                                            echo 'More';
                                            ?>
                                        </div>
                                        <div class="sale__item-lnk">
                                            <svg width="61" height="41" viewBox="0 0 61 41" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M15.4999 -9.65013e-07L28.9999 -2.18894e-06L17.4615 41L3.96143 41L15.4999 -9.65013e-07Z" fill="#C92D36"/>
                                                <path d="M34.25 -6.1975e-05L39.75 -6.24995e-05L28.5 40.9999L23 40.9999L34.25 -6.1975e-05Z" fill="#C92D36"/>
                                                <path d="M11.3704 -9.94036e-07L61 0.000112342L61 41L3.05188e-06 40.9999L11.3704 -9.94036e-07Z" fill="#C92D36"/>
                                                <path d="M26.9998 23L26.9998 17L34.9998 17L34.9998 12.16L42.8398 20L34.9998 27.84L34.9998 23L26.9998 23Z" fill="white"/>
                                            </svg>
                                        </div>
                                    </a>
                                    <?php
                                }
                                ?>
                            <?php }
                        }
                        wp_reset_query(); ?>
                    </div>
                </div>
            </div>
        </div>
<!--        <script>(function ( $ ) {-->
<!--                "use strict";-->
<!--                $(document).on("sf:ajaxfinish", ".searchandfilter", function(){-->
<!--                    $( ".sale__item" ).on( "click", function() {-->
<!--                        let ItemLnk = $(this).data('href');-->
<!--                        $.ajax({-->
<!--                            type: 'GET', //or POST i don't know which one-->
<!--                            url: ItemLnk, //or should this be the url: ?-->
<!--                            success: function(data){-->
<!--                                $html = $(data).find('.truck-single');-->
<!--                                $html.appendTo(".popup-truck__wrapper");-->
<!--                                var SmallSwiper = new Swiper(".truck-single__img .small", {-->
<!--                                    spaceBetween: 17,-->
<!--                                    slidesPerView: 5,-->
<!--                                    freeMode: true,-->
<!--                                    watchSlidesProgress: true,-->
<!--                                });-->
<!--                                var BigSwiper = new Swiper(".truck-single__img .big", {-->
<!--                                    spaceBetween: 10,-->
<!--                                    navigation: {-->
<!--                                        nextEl: ".swiper-button-next",-->
<!--                                        prevEl: ".swiper-button-prev",-->
<!--                                    },-->
<!--                                    thumbs: {-->
<!--                                        swiper: SmallSwiper,-->
<!--                                    },-->
<!--                                });-->
<!--                                $('.popup-truck').fadeIn(300);-->
<!--                                $(".tabs-elements .tabs-nav-item").click(function() {-->
<!--                                    $(".tabs-elements .tabs-nav-item").removeClass("active").eq($(this).index()).addClass("active");-->
<!--                                    $(".tabs-elements .tabs-content-item").hide().eq($(this).index()) .css("display", "block")-->
<!--                                        .hide()-->
<!--                                        .fadeIn();-->
<!--                                }).eq(0).addClass("active");-->
<!--                                $(".tabs-elements .tabs-content-item").eq(0).addClass("active");-->
<!--                            }-->
<!--                        });-->
<!--                        return false;-->
<!--                    } );-->
<!--                    $( ".popup-truck__close" ).on( "click", function() {-->
<!--                        $('.popup-truck').fadeOut(300);-->
<!--                        setTimeout(function (){-->
<!--                            $('.popup-truck__wrapper').empty();-->
<!--                        }, 300);-->
<!--                    } );-->
<!--                });-->
<!---->
<!--            }(jQuery));</script>-->
    </main>
<?php

get_footer();