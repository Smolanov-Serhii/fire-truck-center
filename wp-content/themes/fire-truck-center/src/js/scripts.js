$(document).ready(function () {

    function MobMenuInit(){
        if ($(".mobile-menu").length){
            $( ".header__burger-button" ).on( "click", function() {
                $('body').addClass('locked');
                $('.mobile-menu').addClass('active');
            } );

            $( ".mobile-menu-close" ).on( "click", function() {
                $('body').removeClass('locked');
                $('.mobile-menu').removeClass('active');
            } );
        }
    }
    MobMenuInit();
    function AosStart(){
        AOS.init({
            // Global settings:
            disable: false, // accepts following values: 'phone', 'tablet', 'mobile', boolean, expression or function
            startEvent: 'DOMContentLoaded', // name of the event dispatched on the document, that AOS should initialize on
            initClassName: 'aos-init', // class applied after initialization
            animatedClassName: 'aos-animate', // class applied on animation
            useClassNames: false, // if true, will add content of `data-aos` as classes on scroll
            disableMutationObserver: false, // disables automatic mutations' detections (advanced)
            debounceDelay: 50, // the delay on debounce used while resizing window (advanced)
            throttleDelay: 99, // the delay on throttle used while scrolling the page (advanced)
            // Settings that can be overridden on per-element basis, by `data-aos-*` attributes:
            offset: 120, // offset (in px) from the original trigger point
            delay: 0, // values from 0 to 3000, with step 50ms
            duration: 1000, // values from 0 to 3000, with step 50ms
            easing: 'ease', // default easing for AOS animations
            once: true, // whether animation should happen only once - while scrolling down
            mirror: false, // whether elements should animate out while scrolling past them
            anchorPlacement: 'top-bottom', // defines which position of the element regarding to window should trigger the animation

        });
    }
    AosStart()
    function HeaderMove(){
        if ($("header").length){
            let $menu = $("header");
            $(window).scroll(function() {
                let winScrollTop = $(this).scrollTop();
                if ( winScrollTop > 100 && $menu.hasClass("default")){
                    $menu.removeClass("default").addClass("moved");
                    $('.start__decoration-top').addClass("moved");
                } else if(winScrollTop <= 100 && $menu.hasClass("moved")) {
                    $menu.removeClass("moved").addClass("default");
                } else if(winScrollTop <= 80 && $('.start__decoration-top').hasClass("moved")) {
                    $('.start__decoration-top').removeClass("moved");
                }
            });
        }
    }
    HeaderMove();



    function PopupInit(){
        if ($(".popup").length){
            document.addEventListener( 'wpcf7mailsent', function( event ) {
                $('.popup').fadeIn(300);
                setTimeout(function (){
                    $('.popup').fadeOut(300);
                }, 2000);
            }, false );
        };
    }
    PopupInit();

    function FeaturedContainer(){
        var swiper = new Swiper(".featured .swiper", {
            slidesPerView: 4,
            spaceBetween: 24,
            pagination: {
                el: ".featured .swiper-pagination",
                clickable: true,
            },
            breakpoints: {
                '320': {
                    slidesPerView: 1.5,
                    spaceBetween: 10,
                },
                '500': {
                    slidesPerView: 2,
                    spaceBetween: 10,
                },
                '768': {
                    slidesPerView: 2.5,
                    spaceBetween: 10,
                },
                '1024': {
                    slidesPerView: 3,
                    spaceBetween: 10,
                },
                '1400': {
                    slidesPerView: 4,
                    spaceBetween: 10,
                },
            },
        });
    }
    if ($('.featured').length) {
        FeaturedContainer();
    }


    function TabInit(){
        if($('.tabs-elements').length){
            $(".tabs-elements .tabs-nav-item").click(function() {
                $(".tabs-elements .tabs-nav-item").removeClass("active").eq($(this).index()).addClass("active");
                $(".tabs-elements .tabs-content-item").hide().eq($(this).index()) .css("display", "block")
                    .hide()
                    .fadeIn();
            }).eq(0).addClass("active");
            $(".tabs-elements .tabs-content-item").eq(0).addClass("active");
        }
    }
    TabInit();

    $(function() {
        $('select').selectric();
    });
    $('select').selectric().on('change', function() {
        $('.sf-field-submit input').trigger('click');

    });
    $(document).on("sf:ajaxfinish", ".searchandfilter", function(){
        console.log("ajax complete");
        //so load your lightbox or JS scripts here again
    });
    function PopupTruck(){
        if ($(".sale__result").length){
            $( ".sale__item-desctop" ).on( "click", function() {
                let ItemLnk = $(this).data('href');
                $.ajax({
                    type: 'GET', //or POST i don't know which one
                    url: ItemLnk, //or should this be the url: ?
                    success: function(data){
                        $html = $(data).find('.truck-single');
                        $html.appendTo(".popup-truck__wrapper");
                        SwiperThumb();
                        TabInit();
                        $('.popup-truck').fadeIn(300);
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
            $( ".sale__main-header .filter" ).on( "click", function() {
                $('.sale__sidebar').addClass('active');
            } );
            $( ".sale__sidebar-close" ).on( "click", function() {
                $('.sale__sidebar').removeClass('active');
            } );
        }
    }
    PopupTruck();

    function SwiperThumb() {
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
    }

    if ($('.truck-single__img').length) {
        SwiperThumb();
    }

    if ($('.page-template').length) {
        $("a[href*='#']").on("click", function (e) {
            var anchor = $(this);
            $('html, body').stop().animate({
                scrollTop: $(anchor.attr('href')).offset().top
            }, 1000);
            e.preventDefault();
            return false;
        });
    }

});

