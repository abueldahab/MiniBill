<?php
/**
 * themename functions and definitions
 *
 * @package minibill
 * @since minibill 0.9
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since themename 1.0
 */
if ( ! isset( $content_width ) )
	$content_width = 640; /* pixels */

/**
 * Use this to disable various things across the entire site.
 * 
 * @since themename 1.0
 */
$use_comments = false;
$use_sidebar = false;

if ( ! function_exists( 'minibill_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * @since themename 1.0
 */
function minibill_setup() {

	/**
	 * Custom template tags for this theme.
	 */
	require( get_template_directory() . '/inc/template-tags.php' );

	/**
	 * Custom functions that act independently of the theme templates
	 */
	//require( get_template_directory() . '/inc/tweaks.php' );

	/**
	 * Custom Theme Options
	 */
	//require( get_template_directory() . '/inc/theme-options/theme-options.php' );

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on themename, use a find and replace
	 * to change 'minibill' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'minibill', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Enable support for Post Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'minibill' ),
	) );

	/**
	 * Add support for the Aside Post Formats
	 */
	add_theme_support( 'post-formats', array( 'aside', ) );
}
endif; // minibill_setup
add_action( 'after_setup_theme', 'minibill_setup' );

/**
 * Register widgetized area and update sidebar with default widgets
 *
 * @since themename 1.0
 */
function minibill_widgets_init() {
	if ($use_sidebar)
		register_sidebar( array(
			'name' => __( 'Sidebar', 'minibill' ),
			'id' => 'sidebar-1',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h1 class="widget-title">',
			'after_title' => '</h1>',
		) );
}
add_action( 'widgets_init', 'minibill_widgets_init' );

/**
 * Enqueue scripts and styles
 */
function minibill_scripts() {
	wp_enqueue_style( 'style', get_stylesheet_uri() );

	wp_enqueue_script( 'small-menu', get_template_directory_uri() . '/js/small-menu.js', array( 'jquery' ), '20120206', true );

	if ( $use_comments && ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}
}
add_action( 'wp_enqueue_scripts', 'minibill_scripts' );


// remove_action( 'wp_head',             'wp_enqueue_scripts',              1     );
remove_action( 'wp_head',             'feed_links',                      2     );
remove_action( 'wp_head',             'feed_links_extra',                3     );
remove_action( 'wp_head',             'rsd_link'                               );
remove_action( 'wp_head',             'wlwmanifest_link'                       );
remove_action( 'wp_head',             'adjacent_posts_rel_link_wp_head', 10, 0 );
// remove_action( 'wp_head',             'locale_stylesheet'                      );

// remove_action( 'wp_head',             'noindex',                          1    );
remove_action( 'wp_head',             'wp_print_styles',                  8    );
// remove_action( 'wp_head',             'wp_print_head_scripts',            9    );
remove_action( 'wp_head',             'wp_generator'                           );
// remove_action( 'wp_head',             'rel_canonical'                          );

// remove_action( 'wp_head',             'wp_shortlink_wp_head',            10, 0 );

function clean_header(){
	wp_deregister_script( 'comment-reply' );
         }
add_action('init','clean_header');