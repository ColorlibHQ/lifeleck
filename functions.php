<?php 
/**
 * @Packge 	   : Colorlib
 * @Version    : 1.0
 * @Author 	   : Colorlib
 * @Author URI : http://colorlib.com/wp/
 *
 */
 
	// Block direct access
	if( !defined( 'ABSPATH' ) ){
		exit( 'Direct script access denied.' );
	}

	/**
	 *
	 * Define constant
	 *
	 */
	
	 
	// Base URI
	if( !defined( 'LIFELECK_DIR_URI' ) )
		define( 'LIFELECK_DIR_URI', get_template_directory_uri().'/' );
	
	// assets URI
	if( !defined( 'LIFELECK_DIR_ASSETS_URI' ) )
		define( 'LIFELECK_DIR_ASSETS_URI', LIFELECK_DIR_URI.'assets/' );
	
	// Css File URI
	if( !defined( 'LIFELECK_DIR_CSS_URI' ) )
		define( 'LIFELECK_DIR_CSS_URI', LIFELECK_DIR_ASSETS_URI .'css/' );
	
	// Js File URI
	if( !defined( 'LIFELECK_DIR_JS_URI' ) )
		define( 'LIFELECK_DIR_JS_URI', LIFELECK_DIR_ASSETS_URI .'js/' );
	
	// Icon Images
	if( !defined('LIFELECK_DIR_ICON_IMG_URI') )
		define( 'LIFELECK_DIR_ICON_IMG_URI', LIFELECK_DIR_URI.'img/core-img/' );
	
	//DIR inc
	if( !defined( 'LIFELECK_DIR_INC' ) )
		define( 'LIFELECK_DIR_INC', LIFELECK_DIR_URI.'inc/' );

	//Elementor Widgets Folder Directory
	if( !defined( 'LIFELECK_DIR_ELEMENTOR' ) )
		define( 'LIFELECK_DIR_ELEMENTOR', LIFELECK_DIR_INC.'elementor-widgets/' );

	// Base Directory
	if( !defined( 'LIFELECK_DIR_PATH' ) )
		define( 'LIFELECK_DIR_PATH', get_parent_theme_file_path().'/' );
	
	//Inc Folder Directory
	if( !defined( 'LIFELECK_DIR_PATH_INC' ) )
		define( 'LIFELECK_DIR_PATH_INC', LIFELECK_DIR_PATH.'inc/' );
	
	//Colorlib framework Folder Directory
	if( !defined( 'LIFELECK_DIR_PATH_LIB' ) )
		define( 'LIFELECK_DIR_PATH_LIB', LIFELECK_DIR_PATH_INC.'libraries/' );
	
	//Classes Folder Directory
	if( !defined( 'LIFELECK_DIR_PATH_CLASSES' ) )
		define( 'LIFELECK_DIR_PATH_CLASSES', LIFELECK_DIR_PATH_INC.'classes/' );

	
	//Widgets Folder Directory
	if( !defined( 'LIFELECK_DIR_PATH_WIDGET' ) )
		define( 'LIFELECK_DIR_PATH_WIDGET', LIFELECK_DIR_PATH_INC.'widgets/' );
		
	//Elementor Widgets Folder Directory
	if( !defined( 'LIFELECK_DIR_PATH_ELEMENTOR_WIDGETS' ) )
		define( 'LIFELECK_DIR_PATH_ELEMENTOR_WIDGETS', LIFELECK_DIR_PATH_INC.'elementor-widgets/' );
	

		
	/**
	 * Include File
	 *
	 */
	
	// Breadcrumbs file include
	require_once( LIFELECK_DIR_PATH_INC . 'lifeleck-breadcrumbs.php' );
	// Sidebar register file include
	require_once( LIFELECK_DIR_PATH_INC . 'widgets/lifeleck-widgets-reg.php' );
	// Post widget file include
	require_once( LIFELECK_DIR_PATH_INC . 'widgets/lifeleck-recent-post-thumb.php' );
	// News letter widget file include
	require_once( LIFELECK_DIR_PATH_INC . 'widgets/lifeleck-newsletter-widget.php' );
	//Social Links
	require_once( LIFELECK_DIR_PATH_INC . 'widgets/lifeleck-social-links.php' );
	// Instagram Widget
	require_once( LIFELECK_DIR_PATH_INC . 'widgets/lifeleck-instagram.php' );
	// Nav walker file include
	require_once( LIFELECK_DIR_PATH_INC . 'wp_bootstrap_navwalker.php' );
	// Theme function file include
	require_once( LIFELECK_DIR_PATH_INC . 'lifeleck-functions.php' );

	// Theme Demo file include
	require_once( LIFELECK_DIR_PATH_INC . 'demo/demo-import.php' );

	// Inline css file include
	require_once( LIFELECK_DIR_PATH_INC . 'lifeleck-commoncss.php' );
	// Post Like
	require_once( LIFELECK_DIR_PATH_INC . 'post-like.php' );
	// Theme support function file include
	require_once( LIFELECK_DIR_PATH_INC . 'support-functions.php' );
	// Html helper file include
	require_once( LIFELECK_DIR_PATH_INC . 'wp-html-helper.php' );
	// Pagination file include
	require_once( LIFELECK_DIR_PATH_INC . 'wp_bootstrap_pagination.php' );
	// Elementor Widgets
	require_once( LIFELECK_DIR_PATH_ELEMENTOR_WIDGETS . 'elementor-widget.php' );
	//
	require_once( LIFELECK_DIR_PATH_CLASSES . 'Class-Enqueue.php' );
	
	require_once( LIFELECK_DIR_PATH_CLASSES . 'Class-Config.php' );
	// Customizer
	require_once( LIFELECK_DIR_PATH_INC . 'customizer/customizer.php' );
	// Class autoloader
	require_once( LIFELECK_DIR_PATH_INC . 'class-epsilon-dashboard-autoloader.php' );
	// Class lifeleck dashboard
	require_once( LIFELECK_DIR_PATH_INC . 'class-epsilon-init-dashboard.php' );
	

	// Admin Enqueue Script
	function lifeleck_admin_script(){
		wp_enqueue_style( 'lifeleck-admin', get_template_directory_uri().'/assets/css/lifeleck_admin.css', false, '1.0.0' );
		wp_enqueue_script( 'lifeleck_admin', get_template_directory_uri().'/assets/js/lifeleck_admin.js', false, '1.0.0' );
	}
	add_action( 'admin_enqueue_scripts', 'lifeleck_admin_script' );

	 
	// WooCommerce style desable
	add_filter( 'woocommerce_enqueue_styles', '__return_false' );


	/**
	 * Instantiate Lifeleck object
	 *
	 * Inside this object:
	 * Enqueue scripts, Google font, Theme support features, Lifeleck Dashboard .
	 *
	 */
	
	$Lifeleck = new Lifeleck();
	
