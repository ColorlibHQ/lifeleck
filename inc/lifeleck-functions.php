<?php 
/**
 * @Packge     : Lifeleck
 * @Version    : 1.0
 * @Author     : Colorlib
 * @Author URI : http://colorlib.com/wp/
 *
 */
 
    // Block direct access
    if( !defined( 'ABSPATH' ) ){
        exit( 'Direct script access denied.' );
    }

/*=========================================================
	Theme option callback
=========================================================*/
function lifeleck_opt( $id = null, $default = '' ) {
	
	$opt = get_theme_mod( $id, $default );
	
	$data = '';
	
	if( $opt ) {
		$data = $opt;
	}
	
	return $data;
}


/*=========================================================
	Body support function
=========================================================*/
if ( ! function_exists( 'wp_body_open' ) ) {
    /**
     * Fire the wp_body_open action.
     *
     * Added for backwards compatibility to support WordPress versions prior to 5.2.0.
     */
    function wp_body_open() {
        /**
         * Triggered after the opening <body> tag.
         */
        do_action( 'wp_body_open' );
    }
}


/*=========================================================
	Site icon callback
=========================================================*/

function lifeleck_site_icon(){
	if ( ! has_site_icon() ) {
		$html = '';
		$icon_path = LIFELECK_DIR_ASSETS_URI . 'img/favicon.png';
		$html .= '<link rel="icon" href="' . esc_url ( $icon_path ) . '" sizes="32x32">';
		$html .= '<link rel="icon" href="' . esc_url ( $icon_path ) . '" sizes="192x192">';
		$html .= '<link rel="apple-touch-icon-precomposed" href="' . esc_url ( $icon_path ) . '">';
		$html .= '<meta name="msapplication-TileImage" content="' . esc_url ( $icon_path ) . '">';

		return $html;
	} else {
		return;
	}
}


/*=========================================================
	Custom meta id callback
=========================================================*/
function lifeleck_meta( $id = '' ){
    
    $value = get_post_meta( get_the_ID(), '_lifeleck_'.$id, true );
    
    return $value;
}


/*=========================================================
	Blog Date Permalink
=========================================================*/
function lifeleck_blog_date_permalink(){
	
	$year  = get_the_time('Y'); 
    $month_link = get_the_time('m');
    $day   = get_the_time('d');

    $link = get_day_link( $year, $month_link, $day);
    
    return $link; 
}



/*========================================================
	Blog Excerpt Length
========================================================*/
if ( ! function_exists( 'lifeleck_excerpt_length' ) ) {
	function lifeleck_excerpt_length( $limit = 30 ) {

		$excerpt = explode( ' ', get_the_excerpt() );
		
		// $limit null check
		if( !null == $limit ){
			$limit = $limit;
		}else{
			$limit = 30;
		}
        
        
		if ( count( $excerpt ) >= $limit ) {
			array_pop( $excerpt );
			$exc_slice = array_slice( $excerpt, 0, $limit );
			$excerpt = implode( " ", $exc_slice ).' ...';
		} else {
			$exc_slice = array_slice( $excerpt, 0, $limit );
			$excerpt = implode( " ", $exc_slice );
		}
		
		$excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
		return $excerpt;

	}
}


/*==========================================================
	Comment number and Link
==========================================================*/
if ( ! function_exists( 'lifeleck_posted_comments' ) ) {
    function lifeleck_posted_comments(){
        
        $comments_num = get_comments_number();
        if( comments_open() ){
            if( $comments_num == 0 ){
                $comments = esc_html__('No Comments','lifeleck');
            } elseif ( $comments_num > 1 ){
                $comments= $comments_num . esc_html__(' Comments','lifeleck');
            } else {
                $comments = esc_html__( '1 Comment','lifeleck' );
            }
            $comments = '<i class="ti-comment"></i>'. $comments;
        } else {
            $comments = esc_html__( 'Comments are closed', 'lifeleck' );
        }
        
        return $comments;
    }
}


/*===================================================
	Post embedded media
===================================================*/
function lifeleck_embedded_media( $type = array() ){
    
    $content = do_shortcode( apply_filters( 'the_content', get_the_content() ) );
    $embed   = get_media_embedded_in_content( $content, $type );
        
    if( in_array( 'audio' , $type) ){
    
        if( count( $embed ) > 0 ){
            $output = str_replace( '?visual=true', '?visual=false', $embed[0] );
        }else{
           $output = '';
        }
        
    }else{
        
        if( count( $embed ) > 0 ){

            $output = $embed[0];
        }else{
           $output = ''; 
        }
        
    }
    
    return $output;
}


/*===================================================
	WP post link pages
====================================================*/
function lifeleck_link_pages(){
    wp_link_pages( array(
    'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'lifeleck' ) . '</span>',
    'after'       => '</div>',
    'link_before' => '<span>',
    'link_after'  => '</span>',
    'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'lifeleck' ) . ' </span>%',
    'separator'   => '<span class="screen-reader-text">, </span>',
    ) );
}


/*====================================================
	Theme logo
====================================================*/
function lifeleck_theme_logo( $class = '' ) {

    $siteUrl = home_url('/');
    // site logo
		
	$custom_logo_id = get_theme_mod( 'custom_logo' );
	$imageUrl = wp_get_attachment_image_src( $custom_logo_id , 'site_logo_123x40' );
	
	if( !empty( $imageUrl[0] ) ){
		$siteLogo = '<a class="'.esc_attr( $class ).'" href="'.esc_url( $siteUrl ).'"><img src="'.esc_url( $imageUrl[0] ).'" alt=""></a>';
	}else{
		$siteLogo = '<a class="'.esc_attr( $class ).'" href="'.esc_url( $siteUrl ).'"><img src="'. LIFELECK_DIR_ASSETS_URI .'img/logo.png" alt=""></a>';
	}
	
	return wp_kses_post( $siteLogo );
	
}


/*================================================
    Page Title Bar
================================================*/
function lifeleck_page_titlebar() {
	if ( ! is_page_template( 'template-builder.php' ) ) {
		?>
        <section class="hero-banner breadcrumb_bg">
            <div class="container">
				<div class="row align-items-center justify-content-between">
					<div class="col-sm-6">
						<div class="breadcrumb_tittle text-left">
							<h2>
								<?php
								if ( is_category() ) {
									single_cat_title( __('Category: ', 'lifeleck') );

								} elseif ( is_tag() ) {
									single_tag_title( __('Tag Archive for - ', 'lifeleck') );

								} elseif ( is_archive() ) {
									echo get_the_archive_title();

								} elseif ( is_page() ) {
									echo get_the_title();

								} elseif ( is_search() ) {
									echo esc_html__( 'Search for: ', 'lifeleck' ) . get_search_query();

								} elseif ( ! ( is_404() ) && ( is_single() ) || ( is_page() ) ) {
									echo  get_the_title();

								} elseif ( is_home() ) {
									echo esc_html__( 'Blog', 'lifeleck' );

								} elseif ( is_404() ) {
									echo esc_html__( '404 error', 'lifeleck' );

								}
								?>
							</h2>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="breadcrumb_content text-right">
							<?php
							if ( function_exists( 'lifeleck_breadcrumbs' ) ) {
								lifeleck_breadcrumbs();
							}
							?>
						</div>
					</div>
				</div>
            </div>
        </section>
		<?php
	}
}



/*================================================
	Blog pull right class callback
=================================================*/
function lifeleck_pull_right( $id = '', $condation ){
    
    if( $id == $condation ){
        return ' '.'order-last';
    }else{
        return;
    }
    
}



/*======================================================
	Inline Background
======================================================*/
function lifeleck_inline_bg_img( $bgUrl ){
    $bg = '';

    if( $bgUrl ){
        $bg = 'style="background-image:url('.esc_url( $bgUrl ).')"'; 
    }

    return $bg;
}


/*======================================================
	Blog Category
======================================================*/
function lifeleck_featured_post_cat( $seperator = ', ', $class_name = null ){

	$categories = get_the_category(); 
	
	if( is_array( $categories ) && count( $categories ) > 0 ){
		$getCat = [];
		foreach ( $categories as $value ) {
			if ( $class_name ) {
				$getCat[] = '<a class="'.$class_name.'" href="'.esc_url( get_category_link( $value->term_id ) ).'">'.esc_html( $value->name ).'</a>';
			} else {
				$getCat[] = '<a href="'.esc_url( get_category_link( $value->term_id ) ).'"><h5>'.esc_html( $value->name ).'</h5></a>';
			}
		}

		return implode( $seperator, $getCat );
	}
         
}


/*=======================================================
	Customize Sidebar Option Value Return
========================================================*/
function lifeleck_sidebar_opt(){

    $sidebarOpt = lifeleck_opt( 'lifeleck_blog_layout' );
    $sidebar = '1';
    // Blog Sidebar layout  opt
    if( is_array( $sidebarOpt ) ){
        $sidebarOpt =  $sidebarOpt;
    }else{
        $sidebarOpt =  json_decode( $sidebarOpt, true );
    }
    
    
    if( !empty( $sidebarOpt['columnsCount'] ) ){
        $sidebar = $sidebarOpt['columnsCount'];
    }


    return $sidebar;
}


/**================================================
	Themify Icon
 =================================================*/
function lifeleck_themify_icon(){
    return[
        'ti-home'       => 'Home',
        'ti-tablet'     => 'Tablet',
        'ti-email'      => 'Email',
        'ti-twitter'    => 'twitter',
        'ti-skype'      => 'skype',
        'ti-instagram'  => 'instagram',
        'ti-dribbble'   => 'dribbble',
        'ti-vimeo'      => 'vimeo',
    ];
}


/*===========================================================
	Set contact form 7 default form template
============================================================*/
function lifeleck_contact7_form_content( $template, $prop ) {
    
    if ( 'form' == $prop ) {

        $template =
            '<div class="row"><div class="col-12"><div class="form-group">[textarea* your-message id:message class:form-control class:w-100 rows:9 cols:30 placeholder "Message"]</div></div><div class="col-sm-6"><div class="form-group">[text* your-name id:name class:form-control placeholder "Enter your  name"]</div></div><div class="col-sm-6"><div class="form-group">[email* your-email id:email class:form-control placeholder "Enter your email"]</div></div><div class="col-12"><div class="form-group">[text your-subject id:subject class:form-control placeholder "Subject"]</div></div></div><div class="form-group mt-3">[submit class:button-contactForm class:btn_1 "Send Message"]</div>';

        return $template;

    } else {
    return $template;
    } 
}
add_filter( 'wpcf7_default_template', 'lifeleck_contact7_form_content', 10, 2 );



/*============================================================
	Pagination
=============================================================*/
function lifeleck_blog_pagination(){
	echo '<nav class="blog-pagination justify-content-center d-flex col-lg-12">';
        echo the_posts_pagination(
            array(
                'mid_size'  => 2,
                'prev_text' => __( '<span class="ti-angle-left"></span>', 'lifeleck' ),
                'next_text' => __( '<span class="ti-angle-right"></span>', 'lifeleck' ),
                'screen_reader_text' => ' '
            )
        );
	echo '</nav>';
}


/*=============================================================
	Blog Single Post Navigation
=============================================================*/
if( ! function_exists('lifeleck_blog_single_post_navigation') ) {
	function lifeleck_blog_single_post_navigation() {

		// Start nav Area
		if( get_next_post_link() || get_previous_post_link()   ):
			?>
			<div class="navigation-area">
				<div class="row">
					<div class="col-lg-6 col-md-6 col-12 nav-left flex-row d-flex justify-content-start align-items-center">
						<?php
						if( get_next_post_link() ){
							$nextPost = get_next_post();

							if( has_post_thumbnail() ){
								?>
								<div class="thumb">
									<a href="<?php the_permalink(  absint( $nextPost->ID )  ) ?>">
										<?php echo get_the_post_thumbnail( absint( $nextPost->ID ), 'np_thumb', array( 'class' => 'img-fluid' ) ) ?>
									</a>
								</div>
								<?php
							} ?>
							<div class="arrow">
								<a href="<?php the_permalink(  absint( $nextPost->ID )  ) ?>">
									<span class="ti-arrow-left text-white"></span>
								</a>
							</div>
							<div class="detials">
								<p><?php echo esc_html__( 'Prev Post', 'lifeleck' ); ?></p>
								<a href="<?php the_permalink(  absint( $nextPost->ID )  ) ?>">
									<h4><?php echo wp_trim_words( get_the_title( $nextPost->ID ), 4, ' ...' ); ?></h4>
								</a>
							</div>
							<?php
						} ?>
					</div>
					<div class="col-lg-6 col-md-6 col-12 nav-right flex-row d-flex justify-content-end align-items-center">
						<?php
						if( get_previous_post_link() ){
							$prevPost = get_previous_post();
							?>
							<div class="detials">
								<p><?php echo esc_html__( 'Next Post', 'lifeleck' ); ?></p>
								<a href="<?php the_permalink(  absint( $prevPost->ID )  ) ?>">
									<h4><?php echo wp_trim_words( get_the_title( $prevPost->ID ), 4, ' ...' ); ?></h4>
								</a>
							</div>
							<div class="arrow">
								<a href="<?php the_permalink(  absint( $prevPost->ID )  ) ?>">
									<span class="ti-arrow-right text-white"></span>
								</a>
							</div>
							<div class="thumb">
								<a href="<?php the_permalink(  absint( $prevPost->ID )  ) ?>">
									<?php echo get_the_post_thumbnail( absint( $prevPost->ID ), 'np_thumb', array( 'class' => 'img-fluid' ) ) ?>
								</a>
							</div>
							<?php
						} ?>
					</div>
				</div>
			</div>
		<?php
		endif;

	}
}


/*=======================================================
	Author Bio
=======================================================*/
function lifeleck_author_bio(){
	$avatar = get_avatar( absint( get_the_author_meta( 'ID' ) ), 90 );
	?>
	<div class="blog-author">
		<div class="media align-items-center">
			<?php
			if( $avatar  ) {
				echo wp_kses_post( $avatar );
			}
			?>
			<div class="media-body">
				<a href="<?php echo esc_url( get_author_posts_url( absint( get_the_author_meta( 'ID' ) ) ) ); ?>"><h4><?php echo esc_html( get_the_author() ); ?></h4></a>
				<p><?php echo esc_html( get_the_author_meta('description') ); ?></p>
			</div>
		</div>
	</div>
	<?php
}


/*===================================================
 Lifeleck Comment Template Callback
 ====================================================*/
function lifeleck_comment_callback( $comment, $args, $depth ) {

	if ( 'div' === $args['style'] ) {
		$tag       = 'div';
		$add_below = 'comment';
	} else {
		$tag       = 'li';
		$add_below = 'div-comment';
	}
	?>
	<<?php echo esc_attr( $tag ); ?> <?php comment_class( ( empty( $args['has_children'] ) ? '' : 'parent').' comment-list' ) ?> id="comment-<?php comment_ID() ?>">
	<?php if ( 'div' != $args['style'] ) : ?>
		<div id="div-comment-<?php comment_ID() ?>" class="comment-list">
	<?php endif; ?>
		<div class="single-comment">
			<div class="user d-flex">
				<div class="thumb">
					<?php if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
				</div>
				<div class="desc">
					<div class="comment">
						<?php comment_text(); ?>
					</div>

					<div class="d-flex justify-content-between">
						<div class="d-flex align-items-center">
							<h5 class="comment_author"><?php printf( __( '<span class="comment-author-name">%s</span> ', 'lifeleck' ), get_comment_author_link() ); ?></h5>
							<p class="date"><?php printf( __('%1$s at %2$s', 'lifeleck'), get_comment_date(),  get_comment_time() ); ?><?php edit_comment_link( esc_html__( '(Edit)', 'lifeleck' ), '  ', '' ); ?> </p>
							<?php if ( $comment->comment_approved == '0' ) : ?>
								<em class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'lifeleck' ); ?></em>
								<br>
							<?php endif; ?>
						</div>

						<div class="reply-btn">
							<?php comment_reply_link(array_merge( $args, array( 'add_below' => $add_below, 'depth' => 1, 'max_depth' => 5, 'reply_text' => 'Reply' ) ) ); ?>
						</div>
					</div>

				</div>
			</div>
		</div>
	<?php if ( 'div' != $args['style'] ) : ?>
		</div>
	<?php endif; ?>
	<?php
}
// add class comment reply link
add_filter('comment_reply_link', 'lifeleck_replace_reply_link_class');
function lifeleck_replace_reply_link_class( $class ) {
	$class = str_replace("class='comment-reply-link", "class='btn-reply comment-reply-link text-uppercase", $class);
	return $class;
}



/*=========================================================
    Banner Post For Elementor Section
===========================================================*/
function lifeleck_banner_post( $cat, $meta = true, $order = 'desc' ){
	
	$bBlog = new WP_Query( array(
        'post_type'      => 'post',
		'posts_per_page' => 3,
		'order'			 => $order,
		'category_name'  => $cat
	) );
	
	$i = 1;

    if( $bBlog->have_posts() ){
        while( $bBlog->have_posts() ){
			$bBlog->the_post();
			$banner_post_img = get_the_post_thumbnail_url(get_the_ID(), 'banner_post_626x700');
	?>
		<div class="banner_post_1 banner_post_bg_<?php echo $i?>" style="background-image: url( <?php echo $banner_post_img?> )">
			<div class="banner_post_iner text-center">
				<?php echo lifeleck_featured_post_cat(' / '); ?>
				<a href="<?php the_permalink(); ?>"><h2><?php the_title(); ?></h2></a> 
				<?php if ( $meta == true ) { ?>
					<p><?php echo esc_html('Posted on ', 'lifeleck');?><?php echo the_time('F j, Y');?></p>
				<?php } ?>
			</div>
		</div>
		<?php
		$i++;
        }
		wp_reset_postdata();
    }

}


/*=========================================================
    Feature Post For Elementor Section
===========================================================*/
function lifeleck_feature_post( $not_cat = '', $pNumber = '9', $meta = true, $order = 'DESC' ){
	
	$fBlog = new WP_Query( array(
        'post_type'      	=> 'post',
        'order'      		=> $order,
		'posts_per_page' 	=> $pNumber,
		'category__not_in'  => $not_cat
	) );
	
    if( $fBlog->have_posts() ){
		$i = 1;
        while( $fBlog->have_posts() ){
			$fBlog->the_post();
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
						<?php if ( $meta == true ) { ?>
							<p><?php echo esc_html('Posted on ', 'lifeleck');?><?php echo the_time('F j, Y');?></p>
						<?php } ?>
					</div>
				</div>
			</div>
			<?php
			$i++;
		}

		wp_reset_postdata();
	}

}



/*=========================================================
    Category Post For Elementor Section
===========================================================*/
function lifeleck_category_post( $cat, $meta, $order, $cat_lbl ){
	
	$cBlog = new WP_Query( array(
        'post_type'      => 'post',
		'posts_per_page' => 3,
		'order'			 => $order,
		'category_name'	 => $cat
	) );
	
	$i = 1;
	$author_nickname = get_the_author_meta( 'nickname');

    if( $cBlog->have_posts() ){
        while( $cBlog->have_posts() ){
			$cBlog->the_post();
			$sing_cont_class = ($i == 3) ? 'd-block d-sm-none d-lg-block' : '';		
	?>

		<div class="col-sm-6 col-lg-4">
			<div class="single_catagory_post post_2 <?php $sing_cont_class?>">
				<div class="category_post_img">
					<?php
						echo has_post_thumbnail() ? the_post_thumbnail( 'category_post_360x336', ['alt' => get_the_title()] ) : '';
					?>
					<?php
						if ( $cat_lbl ) {
							echo lifeleck_featured_post_cat( 'category_btn' );
						}
					?>
				</div>
				<div class="post_text_1 pr_30">
					<?php if ( $meta ) { ?>
						<p><span> By <?php echo $author_nickname?> </span> / <?php the_time('F j, Y') ?></p>
					<?php 
						}
					?>
					<a href="<?php the_permalink(); ?>">
						<h3><?php the_title();?></h3>
					</a>
					<div class="post_icon">
						<ul>
							<li><i class="ti-comment"></i><?php echo lifeleck_posted_comments();?></li>
							<li><?php echo get_simple_likes_button( get_the_ID() );?></li>
							<li><a href="<?php the_permalink(); ?>#social-icons"><i class="ti-export"></i> <?php echo esc_html__( 'Share ', 'lifeleck' );?></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<?php
		$i++;
        }
		wp_reset_postdata();
    }

}


/*=========================================================
    Latest Blog Post For Elementor Section
===========================================================*/
function lifeleck_latest_blog( $not_cat, $pNumber = 5, $meta, $order ){
	
	$bBlog = new WP_Query( array(
        'post_type'      	=> 'post',
		'posts_per_page' 	=> $pNumber,
		'order'			 	=> $order,
		'category__not_in'	=> $not_cat
	) );
	
	$author_nickname = get_the_author_meta( 'nickname');

    if( $bBlog->have_posts() ){
        while( $bBlog->have_posts() ){
			$bBlog->the_post();
	?>
			
			<div class="single_post media post_3">
				<div class="single_post_img">
					<?php
						if( has_post_thumbnail() ){
							the_post_thumbnail( 'all_post_350x340', ['alt' => get_the_title()] );
						}
					?>
					<?php echo lifeleck_featured_post_cat( 'category_btn' );?>
				</div>
				<div class="post_text_1 media-body align-self-center">
					<?php if ( $meta ) { ?>
						<p><span> <?php echo esc_html__( 'By ', 'lifeleck') . $author_nickname?> </span> / <?php the_time('F j, Y') ?></p>
					<?php 
						}
					?>
					<a href="<?php the_permalink(); ?>">
						<h3><?php the_title();?></h3>
					</a>
					<div class="post_icon">
						<ul>
							<li><i class="ti-comment"></i><?php echo lifeleck_posted_comments();?></li>
							<li><?php echo get_simple_likes_button( get_the_ID() );?></li>
							<li><a href="<?php the_permalink(); ?>#social-icons"><i class="ti-export"></i> <?php echo esc_html__( 'Share ', 'lifeleck' );?></a></li>
						</ul>
					</div>
				</div>
			</div>
        <?php
        }

    }

}



/*=========================================================
    Share Button Code
===========================================================*/
function lifeleck_social_sharing_buttons( $ulClass = '', $tagLine = '' ) {

	// Get page URL
	$URL = get_permalink();
	$Sitetitle = get_bloginfo('name');

	// Get page title
	$Title = str_replace( ' ', '%20', get_the_title());

	// Construct sharing URL without using any script
	$twitterURL = 'https://twitter.com/intent/tweet?text='.esc_html( $Title ).'&amp;url='.esc_url( $URL ).'&amp;via='.esc_html( $Sitetitle );
	$facebookURL= 'https://www.facebook.com/sharer/sharer.php?u='.esc_url( $URL );
	$linkedin   = 'https://www.linkedin.com/shareArticle?mini=true&url='.esc_url( $URL ).'&title='.esc_html( $Title );
	$pinterest  = 'http://pinterest.com/pin/create/button/?url='.esc_url( $URL ).'&description='.esc_html( $Title );

	// Add sharing button at the end of page/page content
	$content = '';
	$content  .= '<ul class="'.esc_attr( $ulClass ).'" id="social-icons">';
	$content .= $tagLine;
	$content .= '<li><a href="' . esc_url( $twitterURL ) . '" target="_blank"><i class="ti-twitter-alt"></i></a></li>';
	$content .= '<li><a href="' . esc_url( $facebookURL ) . '" target="_blank"><i class="ti-facebook"></i></a></li>';
	$content .= '<li><a href="' . esc_url( $pinterest ) . '" target="_blank"><i class="ti-pinterest"></i></a></li>';
	$content .= '<li><a href="' . esc_url( $linkedin ) . '" target="_blank"><i class="ti-linkedin"></i></a></li>';
	$content .= '</ul>';

	return $content;

}


/*==========================================================
 *  Flaticon Icon List
=========================================================*/
function lifeleck_flaticon_list(){
    return(
        array(
            'flaticon-growth'     => 'Flaticon Growth',
            'flaticon-wallet'     => 'Flaticon Wallet',
        )
    );
}

