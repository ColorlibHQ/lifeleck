<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package
 */

    $url = 'https://colorlib.com/';
    $copyText = sprintf( __( 'Theme by %s colorlib %s Copyright &copy; %s  |  All rights reserved.', 'lifeleck' ), '<a target="_blank" href="' . esc_url( $url ) . '">', '</a>', date( 'Y' ) );
    $copyRight = !empty( lifeleck_opt( 'lifeleck_footer_copyright_text' ) ) ? lifeleck_opt( 'lifeleck_footer_copyright_text' ) : $copyText;
    ?>

    <!-- footer part start-->
    <?php
        $footer_wtoggle = lifeleck_opt( 'lifeleck_footer_widget_toggle' );
        $footer_active_class = ( $footer_wtoggle == 1 ) ? 'footer_active' : 'footer_deactivated';
    ?>
    
    <footer class="footer-area <?php echo $footer_active_class?>">
        <div class="container">
            <?php
                if( $footer_wtoggle == 1 ) {
            ?>
            <div class="row">
                <?php
                    // Footer Widget 1
                    if ( is_active_sidebar( 'footer-1' ) ) {
                        dynamic_sidebar( 'footer-1' );
                    }

                    // Footer Widget 2
                    if ( is_active_sidebar( 'footer-2' ) ) {
                        dynamic_sidebar( 'footer-2' );
                    }

                    // Footer Widget 3
                    if ( is_active_sidebar( 'footer-3' ) ) {
                        dynamic_sidebar( 'footer-3' );
                    }

                    // Footer Widget 4
                    if ( is_active_sidebar( 'footer-4' ) ) {
                        dynamic_sidebar( 'footer-4' );
                    }
                ?>
            </div>
            <?php
                }
            ?>

            <div class="copyright_text">
				<div class="row align-items-center">
					<div class="col-lg-8">
						<div class="copyright_part">
                            <p class="footer-text m-0"><?php echo wp_kses_post( $copyRight ); ?></p>
                        </div>
                    </div>
                    <div class="col-lg-4 text-center text-lg-right">
						<div class="footer-social">
                            <?php
                                $social_opt = lifeleck_opt('lifeleck_social_profile_toggle');
                                if ( $social_opt == true ) {
                                    $social_items = lifeleck_opt('lifeleck_header_social');
                                    if( is_array( $social_items ) && count( $social_items ) > 0 ){
                                        foreach ($social_items as $value) {
                                            echo '<a href="'. $value['social_url'] .'"><i class="'. $value['social_icon'] .'"></i></a>';
                                        }
                                    }          
                                }          
                            ?>
						</div>
					</div>
                </div>
            </div>
        </div>
    </footer>
    <?php wp_footer();?>
    </body>
</html>