<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Fire_Truck_Center
 */
$post_id = get_the_ID();
get_header();
?>

	<main class="main">
        <section class="banner-image">
            <div class="banner-image__image">
                <img src="<?php echo the_field('image_banner', 1358) ?>" alt="BLOG">
            </div>
            <div class="banner-image__container small-container">
                <h1 class="banner-image__title">
                    BLOG
                </h1>

                <nav class="breadcrumbs">
                    <ul class="breadcrumbs__list">
                        <li class="breadcrumbs__item"><a href="<?php echo get_home_url(); ?>" class="breadcrumbs__lnk">Home</a></li>
                        <li class="breadcrumbs__item"><span class="breadcrumbs__lnk current-page">Blog</span></li>
                    </ul>
                </nav>
            </div>
        </section>
        <div class="post__list main-container">
            <?php if ( have_posts() ) : ?>
                <?php
                while ( have_posts() ) :
                    the_post();

                    /*
                    * Include the Post-Type-specific template for the content.
                    * If you want to override this in a child theme, then include a file
                    * called content-___.php (where ___ is the Post Type name) and that will be used instead.
                    */
                    get_template_part( 'template-parts/content', get_post_type() );
                endwhile;


            else :

                echo "Not found the post";

            endif;
            $args = array(
                'show_all'     => false, // показаны все страницы участвующие в пагинации
                'end_size'     => 1,     // количество страниц на концах
                'mid_size'     => 1,     // количество страниц вокруг текущей
                'prev_next'    => true,  // выводить ли боковые ссылки "предыдущая/следующая страница".
                'prev_text'    => __('« Previous'),
                'next_text'    => __('Next »'),
                'add_args'     => false, // Массив аргументов (переменных запроса), которые нужно добавить к ссылкам.
                'add_fragment' => '',     // Текст который добавиться ко всем ссылкам.
                'screen_reader_text' => __( 'Posts navigation' ),
                'class'        => 'pagination', // CSS класс, добавлено в 5.5.0.
            );
            the_posts_pagination( $args );
            ?>
        </div>
	</main>

<?php
get_footer();
