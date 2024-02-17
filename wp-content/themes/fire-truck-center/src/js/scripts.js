$(document).ready(function () {

    function MobMenuInit(){
        if ($(".header__mob").length){
            $( ".header__burger" ).on( "click", function() {
                $(this).toggleClass('active');
                $('.start__decoration-top').toggleClass('burger-active').css({transition: "all 1s", 'transition-delay': "0.5s"});
                setTimeout(function() {
                    $('.header__mob').fadeToggle(300);
                }, 700);
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
                $('.popup').fadeOut(300);
                // $('#success-send').fadeIn(300);
                // $('.wpcf7-response-output').empty();
                barba.go($('.popup').data('thanks'));
                // setTimeout(function (){
                //     $('#success-send').fadeOut(300);
                // }, 2000);
            }, false );
            $(".js-form").click(function () {
                // $('body').removeClass('locked');
                $('.popup').fadeIn(300);
            });
            $(".popup__close").click(function () {
                // $('body').removeClass('locked');
                $(this).closest('.popup').fadeOut(300);
            });
        };
    }
    PopupInit();

    function ReviewsContainer(){
        var swiper = new Swiper(".featured .swiper", {
            slidesPerView: 4,
            spaceBetween: 24,
            pagination: {
                el: ".featured .swiper-pagination",
                clickable: true,
            },
        });
    }
    if ($('.featured').length) {
        ReviewsContainer();
    }


    function TabInit(){
        if($('.tabs-elements').length){
            $(".tabs-elements .tabs-nav-item").click(function() {
                $(".tabs-elements .tabs-nav-item").removeClass("active").eq($(this).index()).addClass("active");
                $(".tabs-elements .tabs-content-item").hide().eq($(this).index()) .css("display", "block")
                    .hide()
                    .fadeIn();
                    PotrfolioCosm();
            }).eq(0).addClass("active");
            $(".tabs-elements .tabs-content-item").eq(0).addClass("active");
        }
    }
    TabInit();


});

