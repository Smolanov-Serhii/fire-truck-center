<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Fire_Truck_Center
 */
$post_id = get_the_ID();
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
	<?php wp_head(); ?>
	<?php echo the_field('microdata', $post_id); ?>
	<!-- Meta Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '979027410453304');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=979027410453304&ev=PageView&noscript=1"
/></noscript>
<!-- End Meta Pixel Code -->
	
</head>
<script>
    window.onload = function () {
        document.body.classList.add('loaded_hiding');
        window.setTimeout(function () {
            document.body.classList.add('loaded');
            document.body.classList.remove('loaded_hiding');
        }, 500);

    }
</script>
<body <?php body_class(); ?>>
<div class="preloader">
    <div class="preloader__row">
        <div class="preloader__item"></div>
        <div class="preloader__item"></div>
    </div>
</div>
<?php wp_body_open(); ?>
<?php
    if ( is_404() ) {
        // add search form so that users can search other posts
    } else {
        ?>
        <header id="header" class="header default">
            <div class="header__container">
                <div class="header__logo padding-left">
                    <?php the_custom_logo(); ?>
                </div>
                <nav class="header__nav">
                    <?php
                    wp_nav_menu(
                        array(
                            'theme_location' => 'Page-menu',
                            'menu_id'        => 'primary-menu',
                        )
                    );
                    ?>
                </nav>
                <div class="header__contacts padding-right">
                    <img src="<?php echo get_template_directory_uri(); ?>/img/header/contacts-bg.svg" alt="">
                    <div class="header__contacts-in">
                        <span>CALL US:</span>
                        <!--                <svg width="6" height="7" viewBox="0 0 6 7" fill="none" xmlns="http://www.w3.org/2000/svg">-->
                        <!--                    <circle cx="3.04031" cy="3.49991" r="2.70865" fill="white"/>-->
                        <!--                </svg>-->
                        &nbsp &nbsp
                        <a href="tel:215-559-9119">(215) 559-9119</a>
                    </div>
                </div>
                <div class="header__burger padding-right">
                    <div class="header__burger-button">
                        <span>Menu</span>
                        <div class="header__burger-wrapper">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                </div>
                <div class="mobile-menu">
                    <div class="mobile-menu__container">
                        <div class="mobile-menu-close">
                            <svg width="33" height="32" viewBox="0 0 33 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M32 1L1 31M32 31L1 1" stroke="#FFFFFF" stroke-width="2"/>
                            </svg>
                        </div>
                        <nav class="header__nav">
                            <?php
                            wp_nav_menu(
                                array(
                                    'theme_location' => 'Page-menu',
                                    'menu_id'        => 'primary-menu',
                                )
                            );
                            ?>
                        </nav>
                        <div class="header__contacts-in">
                            
                            <svg width="6" height="7" viewBox="0 0 6 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="3.04031" cy="3.49991" r="2.70865" fill="white"/>
                            </svg>
                            <a href="tel:+12155599119">(215) 559-9119</a>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <?php
    }
?>
