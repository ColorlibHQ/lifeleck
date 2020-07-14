<?php
namespace Lifeleckelementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
//use Elementor\Scheme_Color;
//use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;
//use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Background;



// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;  
}


/**
 *
 * Lifeleck elementor about us section widget.
 *
 * @since 1.0
 */
class Lifeleck_Posts_With_Sidebar extends Widget_Base {

	public function get_name() {
		return 'lifeleck-posts-with-sidebar';
	}

	public function get_title() {
		return __( 'Posts With Sidebar', 'lifeleck' );
	}

	public function get_icon() {
		return 'eicon-sidebar';
	}

	public function get_categories() {
		return [ 'lifeleck-elements' ];
    }

    public function lifeleck_featured_post_cat(){
        $post_cat_array = [];
        $cat_args = [
            'orderby' => 'name',
            'order'   => 'ASC'
        ];
        $categories = get_categories($cat_args);
        foreach($categories as $category) {
            $args = array(
                'showposts' => 2,
                'category__in' => array($category->term_id),
                'ignore_sticky_posts'=> 1
            );
            $posts = get_posts($args);
            if ($posts) {
                $post_cat_array[ $category->term_id ] = $category->name;
            } else {
                return __( 'Select a different category, because this category have not enough posts.', 'lifeleck' );
            }
        }
    
        return $post_cat_array;

             
    }

	protected function _register_controls() {

        // ----------------------------------------  content ------------------------------
        $this->start_controls_section(
            'banner_section',
            [
                'label' => __( 'Posts With Sidebar', 'lifeleck' ),
            ]
        );
        $this->add_control(
            'post_number',
            [
                'label'         => esc_html__( 'Number of Posts', 'lifeleck' ),
                'type'          => Controls_Manager::NUMBER,
                'default'       => 5
            ]
        );
        $this->add_control(
            'post_order',
            [
                'label'         => esc_html__( 'Post Order', 'lifeleck' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __( 'ASC', 'lifeleck' ),
				'label_off'     => __( 'DESC', 'lifeleck' ),
				'return_value'  => 'yes',
				'default'       => 'yes',
            ]
        );
        $this->add_control(
            'show_meta',
            [
                'label'         => esc_html__( 'Show/Hide Meta', 'lifeleck' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __( 'Show', 'lifeleck' ),
				'label_off'     => __( 'Hide', 'lifeleck' ),
				'return_value'  => 'yes',
				'default'       => 'yes',
            ]
        );
        $this->add_control(
            'post_not_in',
            [
                'label'         => esc_html__( 'Not Category In', 'lifeleck' ),
                'type'          => Controls_Manager::SELECT2,
                'multiple'      => true,
                'default'       => [4, 5, 6],
                'description'   => esc_html__( 'Please use the featured images size 360px width & 327px height or more for better look. Aslo it should be square image.', 'lifeleck' ),
                'options'       => $this->lifeleck_featured_post_cat()
            ]
        );
        
        $this->end_controls_section(); // End content
	}
    
	protected function render() {
        $settings = $this->get_settings();
        $pNumber = $settings['post_number'];
        $not_cat = $settings['post_not_in'];
        $meta = $settings['show_meta'] == 'yes' ? true : false;
        $order = $settings['post_order'] == 'yes' ? 'desc' : 'asc';
    ?>

    <!-- feature_post start-->
    <section class="all_post section_padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="row">
                        <?php
                            if( function_exists( 'lifeleck_feature_post' ) ) {
                                lifeleck_feature_post( $not_cat, $pNumber, $meta, $order );
                            }
                        ?>
                    </div> <!-- end row -->

                    <div class="load_btn text-center">
                        <a href="<?php echo get_permalink( get_option( 'page_for_posts' ) ); ?>" class="btn_1"><?php echo __( 'LOAD MORE', 'daren' )?> <i class="ti-angle-right"></i></a>
                    </div>
                </div> <!-- end col-lg-8 -->

                <?php get_sidebar();?>
            </div> <!-- end row -->
        </div> <!-- end container -->
    </section>
    <!-- end all_posts -->
    <?php
    }
}
