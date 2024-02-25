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
                    <?php echo do_shortcode('[searchandfilter id="59"]')?>
                </aside>
                <div class="sale__main">
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

                                <div data-href="<?php the_permalink();?>" class="sale__item">
                                    <div class="sale__item-image">
                                        <?php the_post_thumbnail( 'full' );?>
                                    </div>
                                    <h3 class="sale__item-title">
                                        <?php the_title(); ?>
                                    </h3>
                                    <div class="sale__item-sku">
                                        <?php echo $sku; ?>
                                    </div>
                                    <div class="sale__item-price">
                                        $<?php echo number_format($price, 2, '.', ','); ; ?>
                                    </div>
                                    <div class="sale__item-lnk">
                                        <svg width="61" height="41" viewBox="0 0 61 41" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M15.4999 -9.65013e-07L28.9999 -2.18894e-06L17.4615 41L3.96143 41L15.4999 -9.65013e-07Z" fill="#C92D36"/>
                                            <path d="M34.25 -6.1975e-05L39.75 -6.24995e-05L28.5 40.9999L23 40.9999L34.25 -6.1975e-05Z" fill="#C92D36"/>
                                            <path d="M11.3704 -9.94036e-07L61 0.000112342L61 41L3.05188e-06 40.9999L11.3704 -9.94036e-07Z" fill="#C92D36"/>
                                            <path d="M26.9998 23L26.9998 17L34.9998 17L34.9998 12.16L42.8398 20L34.9998 27.84L34.9998 23L26.9998 23Z" fill="white"/>
                                        </svg>
                                    </div>
                                </div>

                            <?php }
                        }
                        wp_reset_query(); ?>
                    </div>
                </div>
            </div>
        </div>
        <script>(function ( $ ) {
                "use strict";
                $(document).on("sf:ajaxfinish", ".searchandfilter", function(){
                    $( ".sale__item" ).on( "click", function() {
                        let ItemLnk = $(this).data('href');
                        $.ajax({
                            type: 'GET', //or POST i don't know which one
                            url: ItemLnk, //or should this be the url: ?
                            success: function(data){
                                $html = $(data).find('.truck-single');
                                $html.appendTo(".popup-truck__wrapper");
                                var SmallSwiper = new Swiper(".truck-single__img .small", {
                                    spaceBetween: 17,
                                    slidesPerView: 5,
                                    freeMode: true,
                                    watchSlidesProgress: true,
                                });
                                var BigSwiper = new Swiper(".truck-single__img .big", {
                                    spaceBetween: 10,
                                    navigation: {
                                        nextEl: ".swiper-button-next",
                                        prevEl: ".swiper-button-prev",
                                    },
                                    thumbs: {
                                        swiper: SmallSwiper,
                                    },
                                });
                                $('.popup-truck').fadeIn(300);
                                $(".tabs-elements .tabs-nav-item").click(function() {
                                    $(".tabs-elements .tabs-nav-item").removeClass("active").eq($(this).index()).addClass("active");
                                    $(".tabs-elements .tabs-content-item").hide().eq($(this).index()) .css("display", "block")
                                        .hide()
                                        .fadeIn();
                                }).eq(0).addClass("active");
                                $(".tabs-elements .tabs-content-item").eq(0).addClass("active");
                            }
                        });
                        return false;
                    } );
                    $( ".popup-truck__close" ).on( "click", function() {
                        $('.popup-truck').fadeOut(300);
                        setTimeout(function (){
                            $('.popup-truck__wrapper').empty();
                        }, 300);
                    } );
                });

            }(jQuery));</script>
    </main>
<?php

get_footer();