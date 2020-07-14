<?php
// Block direct access
if( !defined( 'ABSPATH' ) ){
    exit( 'Direct script access denied.' );
}

/**
 * @Packge     : Lifeleck
 * @Version    : 1.0
 * @Author     : Colorlib
 * @Author URI : http://colorlib.com/wp/
 *
 */
 
 
function lifeleck_widgets_init() {
    // sidebar widgets 
    
    register_sidebar(array(
        'name'          => esc_html__('Sidebar widgets', 'lifeleck'),
        'description'   => esc_html__('Place widgets in sidebar widgets area.', 'lifeleck'),
        'id'            => 'sidebar_widgets',
        'before_widget' => '<div id="%1$s" class="widget single_sidebar_wiget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<div class="sidebar_tittle"><h3>',
        'after_title'   => '</h3></div>'
    ));

	// footer widgets register
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer One', 'lifeleck' ),
			'id'            => 'footer-1',
			'before_widget' => '<div id="%1$s" class="col-xl-3 col-lg-6 col-sm-6 mb-4 mb-xl-0 single-footer-widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4>',
			'after_title'   => '</h4>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Two', 'lifeleck' ),
			'id'            => 'footer-2',
			'before_widget' => '<div id="%1$s" class="col-xl-3 col-lg-6 col-sm-6 mb-4 mb-xl-0 single-footer-widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4>',
			'after_title'   => '</h4>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Three', 'lifeleck' ),
			'id'            => 'footer-3',
			'before_widget' => '<div id="%1$s" class="col-xl-3 col-lg-6 col-sm-6 mb-4 mb-xl-0 single-footer-widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4>',
			'after_title'   => '</h4>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Four', 'lifeleck' ),
			'id'            => 'footer-4',
			'before_widget' => '<div id="%1$s" class="col-xl-3 col-lg-6 col-sm-6 mb-4 mb-xl-0 single-footer-widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4>',
			'after_title'   => '</h4>',
		)
	);

}
add_action( 'widgets_init', 'lifeleck_widgets_init' );
