<?php

/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package lifeleck
 */

get_header();

?>
	
	<section class="all_post archive_post section_padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="row">

						<?php
						global $i;
						$i = 1;
	                    if (have_posts()) :
		                    while (have_posts()) : the_post();
								get_template_part('templates/content', get_post_format());
								$i++;
		                    endwhile;
	                    endif;

	                    //Pagination
	                    lifeleck_blog_pagination();
	                    ?>
                    </div>
                </div>
	            <?php
		            get_sidebar();
	            
	            ?>
            </div>
        </div>
    </section>


<?php
get_footer();