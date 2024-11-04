<?php
$post_id = get_the_ID();
get_header();
?>
    <main class="main">
        <section class="banner-image">
            <div class="banner-image__image">
                <img src="<?php echo the_field('image_banner', $post_id) ?>" alt="<?php the_title();?>">
            </div>
            <div class="banner-image__container small-container">
                <h1 class="banner-image__title">
                    <?php the_title();?>
                </h1>

                <nav class="breadcrumbs">
                    <ul class="breadcrumbs__list">
                        <li class="breadcrumbs__item"><a href="<?php echo get_home_url(); ?>" class="breadcrumbs__lnk">Home</a></li>
                        <li class="breadcrumbs__item"><a href="<?php echo get_home_url() . '/blog'; ?>" class="breadcrumbs__lnk">Blog</a></li>
                        <li class="breadcrumbs__item"><span class="breadcrumbs__lnk current-page"> <?php the_title();?></span></li>
                    </ul>
                </nav>
            </div>
        </section>
        <div class="blog main-container">
            <div class="blog-wrapper">
                <?php
                if (get_field('top_content', $post_id)){
                    ?>
                    <section class="blog-top">
                        <?php echo the_field('top_content', $post_id) ?>
                    </section>
                    <?php
                }
                ?>
                <?php
                if (get_field('text_block', $post_id)){
                    ?>
                    <section class="text">
                        <div class="text__container">
                            <div class="text__content">
                                <?php echo the_field('text_block', $post_id) ?>
                            </div>
                        </div>
                    </section>
                    <?php
                }
                ?>
                <?php
                if( have_rows('images_block', $post_id) ):
                    echo '<div class="blog-images">';
                    while( have_rows('images_block', $post_id) ) : the_row();
                        $img = get_sub_field('image');
                        $alt = get_sub_field('image_description');
                        ?>
                        <div class="blog-images-item">
                            <img src="<?php echo $img;?>" alt="<?php echo $alt;?>">
                        </div>
                    <?php
                    endwhile;
                    echo '</div>';
                endif;
                ?>
                <?php
                if (get_field('middle_content', $post_id)){
                    ?>
                    <section class="blog-middle">
                        <?php echo the_field('middle_content', $post_id) ?>
                    </section>
                    <?php
                }
                ?>
                <?php
                if( have_rows('pluses_items', $post_id) ):
                    echo '<div class="blog__pluses">';
                    while( have_rows('pluses_items', $post_id) ) : the_row();
                        $img = get_sub_field('icon');
                        $title = get_sub_field('title');
                        $desc = get_sub_field('description');
                        ?>
                        <div class="blog__pluses-item">
                            <div class="blog__pluses-icon">
                                <img src="<?php echo $img;?>" alt="<?php echo $alt;?>">
                            </div>
                            <div class="blog__pluses-content">
                                <h3 class="blog__pluses-title"><?php echo $title;?></h3>
                                <div class="blog__pluses-desc">
                                    <?php echo $desc;?>
                                </div>
                            </div>
                        </div>
                    <?php
                    endwhile;
                    echo '</div>';
                endif;
                ?>
                <?php
                if (get_field('bottom_content', $post_id)){
                    ?>
                    <section class="blog-bottom">
                        <?php echo the_field('bottom_content', $post_id) ?>
                    </section>
                    <?php
                }
                ?>
            </div>
        </div>
        <?php get_template_part( 'template-parts/content', 'form' ); ?>
    </main>
<?php

get_footer();