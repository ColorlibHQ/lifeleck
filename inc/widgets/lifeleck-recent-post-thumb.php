<?php
/**
 * @version  1.0
 * @package  lifeleck
 *
 */
 
 
/********************************************
*Creating recent post widget width thumb
**********************************************/
 
class lifeleck_recent_widget extends WP_Widget {


function __construct() {

parent::__construct(
// Base ID of your widget
'lifeleck_recent_widget',


// Widget name will appear in UI
esc_html__( '[ lifeleck ] Recent Post', 'lifeleck' ),

// Widget description
array( 'description' => esc_html__( 'Add recent post with thumbnail', 'lifeleck' ), )
);

}

// This is where the action happens
public function widget( $args, $instance ) {
$title 	= apply_filters( 'widget_title', $instance['title'] );
$post_number = apply_filters( 'widget_post_number', $instance['post_number'] );

// before and after widget arguments are defined by themes
echo $args['before_widget'];
if ( ! empty( $title ) )
echo $args['before_title'] . $title . $args['after_title'];

	$author_nickname = get_the_author_meta( 'nickname');
	$arrya = array(
		'post_type' 	 => 'post',
		'order'			 => 'asc',
		'posts_per_page' => esc_html( $post_number ),
	);

	$loop = new WP_Query( $arrya );
	
	if( $loop->have_posts() ){
		

		while( $loop->have_posts() ){
			$loop->the_post();

			if( has_post_thumbnail() ):
				?>
				<div class="single_catagory_post post_2">
					<div class="category_post_img">
						<?php the_post_thumbnail( 'popular_feed_post_360x172', array( 'alt' => get_the_title() ) ); ?>
					</div>
					<div class="post_text_1 pr_30">
						<a href="<?php the_permalink(); ?>">
							<h3><?php the_title();?></h3>
						</a>
						<p><span> By <?php echo $author_nickname?> </span> / <?php the_time('F j') ?></p>
					</div>
				</div>
				<?php 
			endif;
		}
		wp_reset_postdata();

	}
	
	echo $args['after_widget'];
}
		
// Widget Backend 
public function form( $instance ) {
	
if ( isset( $instance[ 'title' ] ) ) {
	$title = $instance[ 'title' ];
}else {
	$title = esc_html__( 'Recent Post', 'lifeleck' );
}
//	
if ( isset( $instance[ 'post_number' ] ) ) {
	$post_number = $instance[ 'post_number' ];
}else {
	$post_number = absint( 3 );
}

// Widget admin form
?>
<p>
<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ,'lifeleck'); ?></label>
<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>
<p>
<label for="<?php echo $this->get_field_id( 'post_number' ); ?>"><?php _e( 'Posts Number:' ,'lifeleck'); ?></label>
<input class="widefat" id="<?php echo $this->get_field_id( 'post_number' ); ?>" name="<?php echo $this->get_field_name( 'post_number' ); ?>" type="number" value="<?php echo esc_attr( $post_number ); ?>" />
</p>
<?php 
}
	
// Updating widget replacing old instances with new
public function update( $new_instance, $old_instance ) {
$instance = array();
$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
$instance['post_number'] = ( ! empty( $new_instance['post_number'] ) ) ? strip_tags( $new_instance['post_number'] ) : '';

return $instance;
}
} // Class lifeleck_recent_widget ends here


// Register and load the widget
function lifeleck_recent_post_load_widget() {
	register_widget( 'lifeleck_recent_widget' );
}
add_action( 'widgets_init', 'lifeleck_recent_post_load_widget' );