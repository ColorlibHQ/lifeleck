<?php 
/**
 * @Packge     : Lifeleck
 * @Version    : 1.0
 * @Author     : Colorlib
 * @Author URI : http://colorlib.com/wp/
 *
 * Customizer panels and sections
 *
 */

/***********************************
 * Register customizer panels
 ***********************************/

$panels = array(
    /**
     * Theme Options Panel
     */
    array(
        'id'   => 'lifeleck_theme_options_panel',
        'args' => array(
            'priority'       => 0,
            'capability'     => 'edit_theme_options',
            'theme_supports' => '',
            'title'          => esc_html__( 'Theme Options', 'lifeleck' ),
        ),
    )
);


/***********************************
 * Register customizer sections
 ***********************************/


$sections = array(
    /**
     * General Section
     */
    array(
        'id'   => 'lifeleck_general_section',
        'args' => array(
            'title'    => esc_html__( 'General', 'lifeleck' ),
            'panel'    => 'lifeleck_theme_options_panel',
            'priority' => 1,
        ),
    ),

    /**
     * Header Section
     */
    array(
        'id'   => 'lifeleck_header_section',
        'args' => array(
            'title'    => esc_html__( 'Header', 'lifeleck' ),
            'panel'    => 'lifeleck_theme_options_panel',
            'priority' => 2,
        ),
    ),

    /**
     * Blog Section
     */
    array(
        'id'   => 'lifeleck_blog_section',
        'args' => array(
            'title'    => esc_html__( 'Blog', 'lifeleck' ),
            'panel'    => 'lifeleck_theme_options_panel',
            'priority' => 3,
        ),
    ),


    /**
     * 404 Page Section
     */
    array(
        'id'   => 'lifeleck_fof_section',
        'args' => array(
            'title'    => esc_html__( '404 Page', 'lifeleck' ),
            'panel'    => 'lifeleck_theme_options_panel',
            'priority' => 6,
        ),
    ),

    /**
     * Footer Section
     */
    array(
        'id'   => 'lifeleck_footer_section',
        'args' => array(
            'title'    => esc_html__( 'Footer Page', 'lifeleck' ),
            'panel'    => 'lifeleck_theme_options_panel',
            'priority' => 7,
        ),
    ),



);


/***********************************
 * Add customizer elements
 ***********************************/
$collection = array(
    'panel'   => $panels,
    'section' => $sections,
);

Epsilon_Customizer::add_multiple( $collection );

?>