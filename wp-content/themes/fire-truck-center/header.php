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
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<header id="header" class="header">
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
                <span>(610) FIRETRUCK</span>
                <svg width="6" height="7" viewBox="0 0 6 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="3.04031" cy="3.49991" r="2.70865" fill="white"/>
                </svg>
                <a href="tel:(610) 347-3878">(610) 347-3878</a>
            </div>
        </div>
    </div>
</header>
