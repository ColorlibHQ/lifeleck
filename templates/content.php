<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package lifeleck
 */
$author_nickname = get_the_author_meta( 'nickname');
global $i;
$lifeleck_featured_post = ($i == 1) ? ' feature_post' : '';	
?>
    <div class="<?php echo esc_attr(($i == 1) ? 'col-lg-12' : 'col-lg-6 col-sm-6');?>">
        <div class="single_post post_1<?php echo esc_attr( $lifeleck_featured_post )?>">
            <div class="single_post_img">
                <?php 
                    if ( $i == 1 ) {
                        echo has_post_thumbnail() ? the_post_thumbnail( 'featured_post_750x430', ['alt' => get_the_title()] ) : '';
                    } else {
                        echo has_post_thumbnail() ? the_post_thumbnail( 'category_post_360x327', ['alt' => get_the_title()] ) : '';
                    }
                ?>
            </div>
            <div class="single_post_text text-center">
                <?php echo lifeleck_featured_post_cat(' / '); ?>
                <a href="<?php the_permalink(); ?>"><h2><?php the_title(); ?></h2></a> 
                <?php if( lifeleck_opt( 'lifeleck_blog_meta' ) == 1 ) { ?>
                    <p><?php echo esc_html('Posted on ', 'lifeleck');?><?php echo the_time('F j, Y');?></p>
                <?php } ?>
            </div>
        </div>
    </div>
