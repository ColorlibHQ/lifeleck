<?php 
/**
 * @Packge 	   : Lifeleck
 * @Version    : 1.0
 * @Author 	   : Colorlib
 * @Author URI : http://colorlib.com/wp/
 *
 */
 
	// Block direct access
	if( !defined( 'ABSPATH' ) ){
		exit( 'Direct script access denied.' );
	}

	// Final Class
	final class Lifeleck{

		
		// Theme Version
		private $lifeleck_version = '1.0';

		// Minimum WordPress Version required
		private $min_wp = '4.0';

		// Minimum PHP version required 
		private $min_php = '5.6.25';

		function __construct(){
			// Theme Support
			add_action( 'after_setup_theme', array( $this, 'support' ) );
			// 
			$this->init();
		}

		// Theme init
		public function init(){
			//
			$this->setup();

			// customizer init Instantiate
			if( class_exists('Epsilon_Framework') ){
				$this->customizer_init();
			}
			
			// Instantiate  Dashboard
			$Epsilon_init_Dashboard = Epsilon_init_Dashboard::get_instance();
		}

		// Theme setup
		private function setup(){
			
			// Create enqueue class instance
			$enqueu = new lifeleck_Enqueue();
			$enqueu->scripts = $this->enqueue() ;
			$enqueu->lifeleck_scripts_enqueue_init() ;

		}
		// Theme Support
		public function support(){
			// content width
	        $GLOBALS['content_width'] = apply_filters( 'lifeleck_content_width', 751 );

	        
	        // text domain for translation.
	        load_theme_textdomain( 'lifeleck', LIFELECK_DIR_PATH . '/languages' );
	        
	        // support title tage
	        add_theme_support( 'title-tag' );
	        
	        // support logo
			add_theme_support( 'custom-logo', array(
				'height'      => 40,
				'width'       => 123,
				'flex-height' => true,
				'flex-width'  => true,
				'header-text' => array( 'site-title', 'site-description' ),
			) );

			//Custom Hreader
			add_theme_support( 'custom-header', array(
				'flex-width'    => true,
				'width'         => 1920,
				'flex-height'   => true,
				'height'        => 350,
				'default-image' => get_template_directory_uri() . '/assets/img/banner.png'
			) );

			//Custom background
			add_theme_support( 'custom-background', array(
				'default-color' => 'ffffff'
			) );

	        //  support post format
	        add_theme_support( 'post-formats', array( 'video','audio' ) );
	        
	        // support post-thumbnails
	        add_theme_support( 'post-thumbnails', array( 'post', 'page' ) );
			
			// Site logo size
			add_image_size( 'site_logo_123x40', 123, 40, true );
			
			// Banner post images size
			add_image_size( 'banner_post_626x700', 626, 700, true );

			// Featured post image size
			add_image_size( 'featured_post_750x430', 750, 430, true );
					
			// Category post image size
			add_image_size( 'category_post_360x327', 360, 327, true );
					
			// Popular feed post image size
			add_image_size( 'popular_feed_post_360x172', 360, 172, true );
					
			// Single blog post image size
			add_image_size( 'single_blog_750x375', 750, 375, true );
			add_image_size( 'np_thumb', 60, 60, true );

			// Author bio image size
			add_image_size( 'author_bio_img_90x90', 90, 90, true );

			// Comment thumb image size
			add_image_size( 'comment_thumb_img_70x70', 70, 70, true );
	        	        
	        // support automatic feed links
	        add_theme_support( 'automatic-feed-links' );
	        
	        // support html5
	        add_theme_support( 'html5' );
			
			// Add theme support for selective refresh for widgets.
			add_theme_support( 'customize-selective-refresh-widgets' );
						    
	        // register nav menu
	        register_nav_menus( array(
	            'primary-menu'   	=> esc_html__( 'Primary Menu', 'lifeleck' ),
				'important-links'   => esc_html__( 'Important Links', 'lifeleck' )
	        ) );

	        // editor style
	        add_editor_style('assets/css/editor-style.css');

		} // end support method

		// enqueue theme style and script
		private function enqueue(){

			$cssPath = LIFELECK_DIR_CSS_URI;
			$jsPath  = LIFELECK_DIR_JS_URI;
			
			$scripts = array(
				'style' => array(
					array(
						'handler'		=> 'google-font',
						'file' 			=> $this->google_font(),
					),
					array(
						'handler'		=> 'bootstrap',
						'file' 			=> $cssPath.'bootstrap.min.css',
						'dependency' 	=> array(),
						'version' 		=> '1.0',
					),
					array(
						'handler'		=> 'animate',
						'file' 			=> $cssPath.'animate.css',
						'dependency' 	=> array(),
						'version' 		=> '1.0',
					),
					array(
						'handler'		=> 'owl-carousel',
						'file' 			=> $cssPath.'owl.carousel.min.css',
						'dependency' 	=> array(),
						'version' 		=> '1.0',
					),
					array(
						'handler'		=> 'font-awesome',
						'file' 			=> $cssPath.'font-awesome.min.css',
						'dependency' 	=> array(),
						'version' 		=> '1.0',
					),
					array(
						'handler'		=> 'themify',
						'file' 			=> $cssPath.'themify-icons.css',
						'dependency' 	=> array(),
						'version' 		=> '1.0',
					),
					array(
						'handler'		=> 'linear-icon',
						'file' 			=> $cssPath.'liner_icon.css',
						'dependency' 	=> array(),
						'version' 		=> '1.0',
					),
					array(
						'handler'		=> 'search-css',
						'file' 			=> $cssPath.'search.css',
						'dependency' 	=> array(),
						'version' 		=> '1.0',
					),
					array(
						'handler'		=> 'default-css',
						'file' 			=> $cssPath.'default.css',
						'dependency' 	=> array(),
						'version' 		=> '1.0',
					),
					array(
						'handler'		=> 'style-css',
						'file' 			=> $cssPath.'style.css',
						'dependency' 	=> array(),
						'version' 		=> '1.0',
					),
					
					array(
						'handler'		=> 'lifeleck-style',
						'file' 			=> get_stylesheet_uri(),
					),
				),
				
				'scripts' => array(
					array(
						'handler'		=> 'popper',
						'file' 			=> $jsPath.'popper.min.js',
						'dependency' 	=> array( 'jquery' ),
						'version' 		=> '1.0',
						'in_footer' 	=> true
					),
					array(
						'handler'		=> 'bootstrap',
						'file' 			=> $jsPath.'bootstrap.min.js',
						'dependency' 	=> array( 'jquery' ),
						'version' 		=> '1.0',
						'in_footer' 	=> true
					),
					array(
						'handler'		=> 'instagramFeed',
						'file' 			=> $jsPath.'jquery.instagramFeed.js',
						'dependency' 	=> array( 'jquery' ),
						'version' 		=> '1.0',
						'in_footer' 	=> true
					),

					array(
						'handler'		=> 'lifeleck-custom',
						'file' 			=> $jsPath.'custom.js',
						'dependency' 	=> array( 'jquery' ),
						'version' 		=> $this->lifeleck_version,
						'in_footer' 	=> true
					),

				)
			);

			return $scripts;

		} // end enqueu method 

		// Google Font  
		private function google_font(){

			$fontUrl = '';
			
			if ( 'off' !== _x( 'on', 'Google font: on or off', 'lifeleck' ) ) {
			
				$font_families = array(
					'Cardo:400,700',
					'Lora:400,700'
				);

				$familyArgs = array(
					'family' => htmlentities( implode( '|', $font_families ) ),
					'subset' => urlencode( 'latin, latin-text' ),
				);

				$fontUrl = add_query_arg( $familyArgs, '//fonts.googleapis.com/css' );
			}
			
			return esc_url_raw( $fontUrl );

		} //End google_font method

		// epsilon customizer init
		private function customizer_init(){

			// epsilon customizer quickie settings
		
			add_filter( 'epsilon_quickie_bar_shortcuts', array( $this, 'epsilon_quickie' ) );
			
			// Instantiate Epsilon Framework object
			$Epsilon_Framework = new Epsilon_Framework();

			
			// Instantiate lifeleck theme customizer
			$lifeleck_theme_customizer = new lifeleck_theme_customizer();
		}

		public function epsilon_quickie(){

				return	array(

				'links' => array(
					array(
						'link_to'   => 'lifeleck_theme_options_panel',
						'icon'      => 'dashicons dashicons-admin-home',
						'link_type' => 'panel',
					),
					array(
						'link_to'   => 'nav_menus',
						'icon'      => 'dashicons dashicons-menu',
						'link_type' => 'panel',
					),
					array(
						'link_to'   => 'widgets',
						'icon'      => 'dashicons dashicons-archive',
						'link_type' => 'panel',
					),
					array(
						'link_to'   => 'custom_css',
						'icon'      => 'dashicons dashicons-editor-code',
						'link_type' => 'section',
					),

				),
				'logo'  => array(
					'url' => EPSILON_URI . '/assets/img/epsilon-logo.png',
					'alt' => 'Epsilon Builder Logo',
				),
			);

		}

	} // End Lifeleck Class

?>