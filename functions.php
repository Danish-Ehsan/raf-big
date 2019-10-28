<?php
/**
 * rafbig functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package rafbig
 */

if ( ! function_exists( 'rafbig_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function rafbig_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on rafbig, use a find and replace
		 * to change 'rafbig' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'rafbig', get_template_directory() . '/languages' );

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
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'rafbig' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'rafbig_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'rafbig_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function rafbig_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'rafbig_content_width', 640 );
}
add_action( 'after_setup_theme', 'rafbig_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function rafbig_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'rafbig' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'rafbig' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'rafbig_widgets_init' );


/*
global $project_URLs;

//Pass hero section image URLs to javascript for lazy loading
//if ( is_front_page() ) {
    function my_acf_init() {
        global $project_URLs;
        //$GLOBALS['project_URLs'] = 'test';
        $projects = get_field( 'featured_projects_main', get_option( 'page_on_front' ) );

        foreach ($projects as $key => $project) {
            $project_URLs[$key] = get_the_post_thumbnail_url( $project->ID );
        }

        wp_localize_script( 'ragbig-hero-section', 'projectURLs', $project_URLs );
    }
    
    add_action( 'plugins_loaded', 'my_acf_init' );
//}
//$GLOBALS['project_URLs'] = 'test';
*/


/**
 * Enqueue scripts, styles and fonts
 */
function rafbig_scripts() {
	wp_enqueue_style( 'rafbig-style', get_stylesheet_uri() );
        
        wp_enqueue_style( 'wpb-google-fonts', 'https://fonts.googleapis.com/css?family=Barlow+Condensed|Barlow:400,700&display=swap', false );
        
        if ( is_singular( 'projects') || is_page_template( 'template-about.php' ) ) {
            wp_enqueue_script( 'jquery' );
        }

	wp_enqueue_script( 'rafbig-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'rafbig-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );
        
        //enqueue owl carousel scripts
        wp_enqueue_style( 'owl-carousel-stylesheet', get_template_directory_uri() . '/inc/owl-carousel/owl.carousel.min.css', array(), '20151215', false );
        
        
        
        if ( is_singular( 'projects') ) {
            wp_enqueue_style( 'owl-carousel-project-theme', get_template_directory_uri() . '/inc/owl-carousel/owl.theme.project.css', array(), '20151215', false );
        } else if ( is_page_template( 'template-about.php' ) ) {
            wp_enqueue_style( 'owl-carousel-about-theme', get_template_directory_uri() . '/inc/owl-carousel/owl.theme.about.css', array(), '20151215', false );
        }
        
        if ( is_singular( 'projects') || is_page_template( 'template-about.php' ) ) {
            wp_enqueue_script( 'owl-carousel',  get_template_directory_uri() . '/inc/owl-carousel/owl.carousel.min.js', array(), '20151215', true );
        }
            
        if ( is_singular( 'projects') ) {
            wp_enqueue_script( 'owl-carousel-project', get_template_directory_uri() . '/js/owl-carousel-project.js', array(), '20151215', true );
        } else if ( is_page_template( 'template-about.php' ) ) {
            wp_enqueue_script( 'owl-carousel-about', get_template_directory_uri() . '/js/owl-carousel-about.js', array(), '20151215', true );
        }
        
        if ( is_front_page() ) {
            wp_enqueue_script( 'ragbig-hero-section', get_template_directory_uri() . '/js/hero-section.js', array(), '20190926', true );
        }
        
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
            wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'rafbig_scripts' );


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


// Store custom logo url
$custom_logo_id = get_theme_mod( 'custom_logo' );
global $logo_url;
$logo_url = wp_get_attachment_image_src( $custom_logo_id , 'full' );


//Create custom image sizes
add_image_size( 'hero-large', 1600 );
add_image_size( 'wide-medium', 900 );
add_image_size( 'tall-thumbnail', 0, 300 );