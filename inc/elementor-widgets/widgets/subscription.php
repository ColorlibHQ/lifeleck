<?php
namespace Lifeleckelementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Utils;



// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;  
}


/**
 *
 * Lifeleck elementor subscription section widget.
 *
 * @since 1.0
 */
class Lifeleck_Subscription extends Widget_Base {

	public function get_name() {
		return 'lifeleck-subscription';
	}

	public function get_title() {
		return __( 'Subscription', 'lifeleck' );
	}

	public function get_icon() {
		return 'eicon-posts-ticker';
	}

	public function get_categories() {
		return [ 'lifeleck-elements' ];
	}

	protected function _register_controls() {

        // ----------------------------------------  content ------------------------------
        $this->start_controls_section(
            'subscription_section',
            [
                'label' => __( 'Subscription Section Content', 'lifeleck' ),
            ]
        );
        $this->add_control(
			'sec_title',
			[
                'label'     => __( 'Subscription Heading', 'lifeleck' ),
                'type'      => Controls_Manager::TEXT,
                'label_block' => true,
                'default'   => __( 'Subscribe Our Newsletter', 'lifeleck' )
			]
        );
        $this->add_control(
			'sub_form',
			[
                'label'         => __( 'Subscription Form Shortcode', 'lifeleck' ),
                'type'          => Controls_Manager::TEXTAREA,
                'label_block'   => true,
                'placeholder'   => '[contact-form-7 id="224" title="Subscription Form"]'
			]
        );

        $this->end_controls_section(); // End content


        /**
         * Style Tab
         * ------------------------------ Background Style ------------------------------
         *
         */

        // Heading Style ==============================
        $this->start_controls_section(
            'color_sect', [
                'label' => __( 'Subscription Style', 'lifeleck' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'color_secttitle', [
                'label'     => __( 'Title Color', 'lifeleck' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .subscribe_form .subscribe_form_iner h3' => 'color: {{VALUE}};',
                ],
            ]
        );    
        $this->add_control(
            'sec_border_col', [
                'label'     => __( 'Section Border Color', 'lifeleck' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .subscribe_form .subscribe_form_iner' => 'border-color: {{VALUE}};',
                ],
            ]
        );    
        $this->add_control(
            'btn_styles_separator',
            [
                'label'     => __( 'Button Styles', 'lifeleck' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'after',
            ]
        ); 
        $this->add_control(
            'btn_color', [
                'label'     => __( 'Button Color', 'lifeleck' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .subscribe_form .wpcf7 .btn_1' => 'color: {{VALUE}};',
                ],
            ]
        );    
        $this->add_control(
            'btn_bg_color', [
                'label'     => __( 'Button BG Color', 'lifeleck' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .subscribe_form .wpcf7 .btn_1' => 'background-color: {{VALUE}};',
                ],
            ]
        );    
        $this->add_control(
            'btn_hvr_color', [
                'label'     => __( 'Button Hover Color', 'lifeleck' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .subscribe_form .wpcf7 .btn_1:hover' => 'color: {{VALUE}} !important;',
                ],
            ]
        );    
        $this->add_control(
            'btn_hvr_bg_color', [
                'label'     => __( 'Button Hover BG Color', 'lifeleck' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .subscribe_form .wpcf7 .btn_1:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );    
        
        $this->end_controls_section();

	}

	protected function render() {
        $settings = $this->get_settings();
        $sec_head = !empty( $settings['sec_title'] ) ? $settings['sec_title'] : '';
        $form_shortcode = !empty( $settings['sub_form'] ) ? $settings['sub_form'] : '';
    ?>

    <!-- subscribe form start-->
    <div class="subscribe_form padding_top margin_top">
        <div class="container">
            <div class="row ">
                <div class="col-lg-12">
                    <div class="subscribe_form_iner">
                            
                            <?php
                                //Form Shortcode ==============
                                if( $form_shortcode ){
                                    echo do_shortcode( $form_shortcode );
                                }
                            ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- subscribe form end-->
    <?php

    }
	
}
