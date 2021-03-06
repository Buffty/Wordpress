<?php
/**
 * Airi functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Airi
 */

if ( ! function_exists( 'airi_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function airi_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Airi, use a find and replace
		 * to change 'airi' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'airi', get_template_directory() . '/languages' );

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

		add_image_size( 'airi-720', 720 );
		add_image_size( 'airi-360-360', 360, 360, true );
		add_image_size( 'airi-850-485', 850, 485, true );
		add_image_size( 'airi-390-280', 390, 280, true );
		add_image_size( 'airi-969-485', 969, 485, true );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'airi' ),
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
		add_theme_support( 'custom-background', apply_filters( 'airi_custom_background_args', array(
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
add_action( 'after_setup_theme', 'airi_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function airi_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'airi_content_width', 1170 );
}
add_action( 'after_setup_theme', 'airi_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function airi_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'airi' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'A??ada widgets aqui.', 'airi' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

	//Footer widget areas
	$widget_areas = get_theme_mod( 'footer_widget_areas', '4' );
	for ( $i=1; $i <= $widget_areas; $i++ ) {
		register_sidebar( array(
			'name'          => __( 'Footer ', 'airi' ) . $i,
			'id'            => 'footer-' . $i,
			'description'   => '',
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );
	}

	register_widget( 'Airi_Social' );
	register_widget( 'Airi_Recent_Posts' );
	
}
add_action( 'widgets_init', 'airi_widgets_init' );


// CUSTOM WIDGET
function widget_register(){
	register_widget("custom_widget");
}
add_action("widgets_init","widget_register");

/**
 * Enqueue scripts and styles.
 */
function airi_scripts() {
	wp_enqueue_style( 'airi-style', get_stylesheet_uri() );

	wp_enqueue_script( 'airi-skip-link-focus-fix', get_template_directory_uri() . '/js/vendor/skip-link-focus-fix.js', array(), '20151215', true );

	wp_enqueue_style( 'airi-font-awesome', get_template_directory_uri() . '/css/font-awesome/css/font-awesome.min.css' );

	//Deregister FontAwesome from Elementor
	wp_deregister_style( 'font-awesome' );

	if ( !class_exists( 'Kirki_Fonts' ) ) {
		wp_enqueue_style( 'airi-fonts', '//fonts.googleapis.com/css?family=Work+Sans:400,500,600', array(), null );
	}

	//Load masonry
	$blog_layout = airi_blog_layout();
	if ( $blog_layout == 'layout-masonry' ) {
		wp_enqueue_script( 'jquery-masonry' );
	}

	wp_enqueue_script( 'airi-scripts', get_template_directory_uri() . '/js/vendor/scripts.js', array( 'jquery' ), '20180223', true );

	wp_enqueue_script( 'airi-main', get_template_directory_uri() . '/js/custom/custom.min.js', array( 'jquery' ), '20181017', true );	

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

}
add_action( 'wp_enqueue_scripts', 'airi_scripts' );

 /**
 * Enqueue custom Elementor scripts
 */
function airi_elementor_scripts() {
	wp_enqueue_script( 'airi-navigation', get_template_directory_uri() . '/js/vendor/navigation.js', array( 'jquery', 'jquery-slick', 'imagesloaded' ), '20180717', true );
}
add_action('elementor/frontend/after_register_scripts', 'airi_elementor_scripts');

 /**
 * Enqueue Bootstrap
 */
function airi_enqueue_bootstrap() {
	wp_enqueue_style( 'airi-bootstrap', get_template_directory_uri() . '/css/bootstrap/bootstrap.min.css', array(), true );
}
add_action( 'wp_enqueue_scripts', 'airi_enqueue_bootstrap', 9 );

/**
 * Gutenberg
 */
function airi_editor_styles() {
	
	wp_enqueue_style( 'airi-block-editor-styles', get_theme_file_uri( '/editor-styles.css' ), '', '1.0', 'all' );
	
	if ( !class_exists( 'Kirki_Fonts' ) ) {
		wp_enqueue_style( 'airi-fonts', '//fonts.googleapis.com/css?family=Work+Sans:400,500,600', array(), null );
	}
}
add_action( 'enqueue_block_editor_assets', 'airi_editor_styles' );

/**
 * Disable Elementor globals on theme activation
 */
function airi_disable_elementor_globals () {
	update_option( 'elementor_disable_color_schemes', 'yes' );
	update_option( 'elementor_disable_typography_schemes', 'yes' );
}
add_action('after_switch_theme', 'airi_disable_elementor_globals');

/**
 * Custom Elementor widgets
 */
function airi_register_elementor_widgets() {

	if ( defined('ELEMENTOR_PATH') && class_exists('Elementor\Widget_Base') ) {

		require get_template_directory() . '/inc/compatibility/elementor/blocks/block-blog.php';
	}
}
add_action( 'elementor/widgets/widgets_registered', 'airi_register_elementor_widgets' );

/**
 * Elementor ID
 */
if ( ! defined( 'ELEMENTOR_PARTNER_ID' ) ) {
    define( 'ELEMENTOR_PARTNER_ID', 2128 );
}

/**
 * Custom Elementor category
 */
function airi_block_category() {
	
	if ( defined('ELEMENTOR_PATH') && class_exists('Elementor\Widget_Base') ) {
		\Elementor\Plugin::$instance->elements_manager->add_category( 
		'airi-elements',
		[
			'title' => __( 'Airi Elements', 'airi' ),
			'icon' => 'fa fa-plug',
		],
		1
		);		
	}	
}
add_action( 'elementor/elements/categories_registered', 'airi_block_category' );

/**
 * Elementor skins
 */
require get_template_directory() . '/inc/compatibility/elementor/skins/class-airi-google-maps-skin.php';
require get_template_directory() . '/inc/compatibility/elementor/skins/class-airi-image-icon-box-skin.php';
require get_template_directory() . '/inc/compatibility/elementor/skins/class-airi-athemes-blog-skin.php';
require get_template_directory() . '/inc/compatibility/elementor/skins/class-airi-athemes-blog-skin-2.php';
require get_template_directory() . '/inc/compatibility/elementor/skins/class-airi-athemes-blog-skin-3.php';
require get_template_directory() . '/inc/compatibility/elementor/skins/class-airi-athemes-blog-skin-4.php';
require get_template_directory() . '/inc/compatibility/elementor/skins/class-airi-athemes-blog-skin-6.php';

/**
 * Widgets
 */
require get_template_directory() . '/widgets/class-airi-social.php';
require get_template_directory() . '/widgets/class-airi-recent-posts.php';

// CUSTOM WIDGET
require get_template_directory() . '/widgets/widget_custom.php';

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
require get_template_directory() . '/inc/customizer/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}

/**
 * Load Learnpress compatibility file.
 */
if ( class_exists( 'LearnPress' ) ) {
	require get_template_directory() . '/inc/compatibility/learnpress.php';
}

/**
 * Demo content
 */
require_once dirname( __FILE__ ) . '/inc/demo-content/setup.php';

/**
 * TGMPA
 */
require_once get_template_directory() . '/inc/tgmpa/class-tgm-plugin-activation.php';

function airi_register_required_plugins() {

	$plugins = array(

		array(
			'name'      => 'Elementor',
			'slug'      => 'elementor',
			'required'  => false,
		),
		array(
			'name'      => 'Contact Form 7',
			'slug'      => 'contact-form-7',
			'required'  => false,
		),
		array(
			'name'      => 'MailChimp for WordPress',
			'slug'      => 'mailchimp-for-wp',
			'required'  => false,
		),
		array(
			'name'      => 'Theme options',
			'slug'      => 'kirki',
			'required'  => false,
		),
		array(
			'name'      => 'Demo content import',
			'slug'      => 'one-click-demo-import',
			'required'  => false,
		),		
	);	

	$config = array(
		'id'           => 'airi',
		'default_path' => '',
		'menu'         => 'tgmpa-install-plugins',
		'has_notices'  => true,
		'dismissable'  => true,
		'dismiss_msg'  => '',
		'is_automatic' => false,
		'message'      => '',
	);

	tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'airi_register_required_plugins' );

/**
 * Upsell
 */
require get_template_directory() . '/inc/customizer/upsell/class-customize.php';

/* POST PERSONALIZADOS */

function new_posttype(){
	register_post_type("noticias",
		array(
			"labels"=> array(
				"name" => __("Noticias","airi_mod"),
				"singular_name" => __("Noticia","airi_mod")
			),
			"public" => true,
			"has_archive" => true,
			"rewrite" => array("slug" => "noticias"),
			"show_in_rest" => true
		)
	);
}

add_action("init","new_posttype");

function campos_posttype(){
	$labels = array(
		"name" => _x("Noticias","Post Type General Name","airi_mod"),
		"singular_name" => _x("Noticia","Post Type General Name","airi_mod"),
		"menu_name" => __("Noticias","airi_mod"),
		"parent_item_colon" => "",
		"all_items" => __("Todas las noticias","airi_mod"),
		"view_item" => __("Ver noticia","airi_mod"),
		"add_new_item" => __("A??adir nueva noticia","airi_mod"),
		"add_new" => __("A??adir nueva","airi_mod"),
		"edit_item" => __("Editar noticia","airi_mod"),
		"update_item" => __("Actualizar noticia","airi_mod"),
		"search_items" => __("Buscar noticia","airi_mod"),
		"not_found" => __("No encontrado","airi_mod"),
		"not_found_in_trash" => __("No se han encontrado resultados","airi_mod")
	);
	$args = array(
		"label" => __("noticias","airi_mod"),
		"description" => __("Noticias nuevas","airi_mod"),
		"labels" => $labels,
		"supports" => array("title","editor","excerpt","author","thumbnail","comments","revisions","custom-fields"),
		"taxononimies" => array("genres"),
		"hierarchical"        => false,
        "public"              => true,
        "show_ui"             => true,
        "show_in_menu"        => true,
        "show_in_nav_menus"   => true,
        "show_in_admin_bar"   => true,
        "menu_position"       => 5,
        "can_export"          => true,
        "has_archive"         => true,
        "exclude_from_search" => false,
        "publicly_queryable"  => true,
        "capability_type"     => "post",
        "show_in_rest" => true,
	);
	register_post_type("noticias",$args);
}
add_action("init","campos_posttype",0);

/**
 * Onboarding
 */
require get_template_directory() . '/inc/onboarding/class-airi-onboarding.php';


/* HOOKS */

remove_action('airi_footer','airi_footer_credits');
//ACTION
function change_footer(){
	?>
	<div class='container'><h4>Footer Personalizado</h4></div>
	<?php
}
add_action( 'airi_footer', 'change_footer');

/* FILTERS */
function filter_titulo($titulo){
	if($titulo==="Inicio")return "Titulo Filtreado";
	return $titulo;
}
add_filter( 'the_title', 'filter_titulo', 10, 1);