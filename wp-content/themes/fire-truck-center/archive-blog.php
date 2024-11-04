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
        <ul class="post__list main-container">
            <?php if ( have_posts() ) : ?>
                <?php
                while ( have_posts() ) :
                    the_post();
                        ?>
                            <li class="post__list-item">
                                <a href="<?php the_permalink();?>" class="post__list-img" title="<?php the_title();?>">
                                    <?php the_post_thumbnail('medium');?>
                                </a>
                                <a href="<?php the_permalink();?>" class="post__list-lnk" title="<?php the_title();?>">
                                    <h2 class="post__list-title">
                                        <?php the_title();?>
                                    </h2>
                                </a>
                                <span class="post__list-except">
                                    <?php the_excerpt();?>
                                </span>
                                <a href="<?php the_permalink();?>" class="post__list-more" title="<?php the_title();?>">
                                    <?php echo 'Read more'; ?>
                                    <img src="<?php echo get_template_directory_uri(); ?>/img/header/more.svg" alt="<?php the_title();?>">
                                </a>
                            </li>
                        <?php
                endwhile;
                echo "<div class='pagination'>";
                global $wp_query;

                $big = 999999999; // уникальное число для замены

                $args = array(
                    'base'               => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                    'format'             => '?paged=%#%',
                    'current'            => max(1, get_query_var('paged')),
                    'total'              => $wp_query->max_num_pages,
                    'prev_text'          => __('&laquo; Previous'),
                    'next_text'          => __('Next &raquo;'),
                    'show_all'           => false,
                    'end_size'           => 2,
                    'mid_size'           => 3,
                    'before_page_number' => '<span class="page-num">',
                    'after_page_number'  => '</span>',
                );

                echo paginate_links($args);
                echo "</div>";
            endif;

            ?>
        </ul>
	</main>

<?php
get_footer();
