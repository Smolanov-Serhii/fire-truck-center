<?php
/**
 * Fire Truck Center functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Fire_Truck_Center
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.2.1' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function fire_truck_center_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on Fire Truck Center, use a find and replace
		* to change 'fire-truck-center' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'fire-truck-center', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'Page-menu' => esc_html__( 'Page menu', 'fire-truck-center' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'fire_truck_center_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'fire_truck_center_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function fire_truck_center_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'fire_truck_center_content_width', 640 );
}
add_action( 'after_setup_theme', 'fire_truck_center_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function fire_truck_center_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'fire-truck-center' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'fire-truck-center' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'fire_truck_center_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function fire_truck_center_scripts() {
	wp_enqueue_style( 'fire-truck-center-style', get_template_directory_uri() . '/dist/css/style.css', array(), _S_VERSION );
	wp_style_add_data( 'fire-truck-center-style', 'rtl', 'replace' );

	wp_enqueue_script( 'fire-truck-center-navigation', get_template_directory_uri() . '/dist/js/common.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'fire_truck_center_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}
add_action( 'wp_footer', 'wpm_redirect_cf7' );
function wpm_redirect_cf7() { ?>
    <script type="text/javascript">
        document.addEventListener('wpcf7mailsent', function(event) {
            location = 'https://firetruck.center/thank-you/';
        }, false);
    </script>
<?php }


//admin filter
add_action( 'restrict_manage_posts', 'wpse45436_admin_posts_filter_restrict_manage_posts' );
/**
 * First create the dropdown
/** Create the filter dropdown */
function wpse45436_admin_posts_filter_restrict_manage_posts(){
    $type = 'truck'; // change to custom post name.
    if (isset($_GET['truck'])) {
        $type = $_GET['truck'];
    }

    //only add filter to post type you want
    if ('truck' == $type){
        //change this to the list of values you want to show
        //in 'label' => 'value' format
        $values = array(
            'default' => 'default',
            'pending' => 'pending',
            'sold' => 'sold',
        );
        ?>
        <select name="ADMIN_FILTER_FIELD_VALUE">
            <option value=""><?php _e('Status ', 'wose45436'); ?></option>
            <?php
            $current_v = isset($_GET['ADMIN_FILTER_FIELD_VALUE'])? $_GET['ADMIN_FILTER_FIELD_VALUE']:'';
            foreach ($values as $label => $value) {
                printf
                (
                    '<option value="%s"%s>%s</option>',
                    $value,
                    $value == $current_v? ' selected="selected"':'',
                    $label
                );
            }
            ?>
        </select>
        <?php
    }
}


add_filter( 'parse_query', 'wpse45436_posts_filter' );
/**
 * if submitted filter by post meta

 * @return Void
 */
function wpse45436_posts_filter( $query ){
    global $pagenow;
    $type = 'truck'; // change to custom post name.
    if (isset($_GET['truck'])) {
        $type = $_GET['truck'];
    }
    if ( 'truck' == $type && is_admin() && $pagenow=='edit.php' && isset($_GET['ADMIN_FILTER_FIELD_VALUE']) && $_GET['ADMIN_FILTER_FIELD_VALUE'] != '') {
        $query->query_vars['meta_key'] = 'status_sibgle'; // change to meta key created by acf.
        $query->query_vars['meta_value'] = $_GET['ADMIN_FILTER_FIELD_VALUE'];
    }
}

// Название вашего типа записи из функции register_post_type
$post_type = 'truck';

// Регистрируем свои колонки
add_filter( "manage_{$post_type}_posts_columns", function ( $defaults ) {

//    $defaults['custom-one'] = 'Custom One';
    $defaults['custom-two'] = 'SKU';

    return $defaults;
} );

// Вставляем значения для отображения в наших колонках
add_action( "manage_{$post_type}_posts_custom_column", function ( $column_name, $post_id ) {

//    if ( $column_name == 'custom-one' ) {
//        // пример статических данных
//        echo 'Some value here';
//    }

    if ( $column_name == 'custom-two' ) {
        // Пример вывода из поля ACF
        echo get_field( 'sku', $post_id );
    }

}, 10, 2 );

// добавляем возможность сортировать колонку
add_filter( 'manage_edit-' . 'truck' . '_sortable_columns', 'add_views_sortable_column' );
function add_views_sortable_column( $sortable_columns ) {
    $sortable_columns['custom-two'] = [ 'truck_truck', false ];
    // false = asc (по умолчанию)
    // true  = desc

    return $sortable_columns;
}
