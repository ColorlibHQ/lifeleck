<?php 
// Block direct access
if( !defined( 'ABSPATH' ) ){
	exit( 'Direct script access denied.' );
}
/**
 * @Packge 	   : Colorlib
 * @Version    : 1.0
 * @Author 	   : Colorlib
 * @Author URI : http://colorlib.com/wp/
 *
 */
 

	//  Call Header
	get_header(); ?>

		<div id="f0f">
			<div class="container">
				<div class="row justify-content-center">
					<div class="f0f-content text-center">
						<div class="f0f-content-inner">
							<?php 
							$errorText = esc_html__( 'Ooops 404 Error !', 'lifeleck' );
							if( lifeleck_opt( 'lifeleck_fof_titleone' ) ){
								$errorText = lifeleck_opt( 'lifeleck_fof_titleone' );
							}
							//
							echo '<h1 class="h1">'.esc_html( $errorText ).'</h1>';
							

							// Wrong text block

							$wrongText = wp_kses_post( __( 'Either something went wrong or the page dosen&rsquo;t exist anymore.', 'lifeleck' ) );

							if( lifeleck_opt('lifeleck_fof_titletwo') ){
								$wrongText = lifeleck_opt('lifeleck_fof_titletwo');
							}
							echo '<div class="load_btn text-center">';
							$anchor = lifeleck_anchor_tag(
								array(
									'url' 	 => esc_url( site_url( '/' ) ),
									'text' 	 => esc_html__( 'Go To Home page', 'lifeleck' ),
									'class'	 => 'btn_1'
								)
							);

							echo lifeleck_paragraph_tag(
								array(
									'text' 	 => esc_html( $wrongText )
								)
							);

							echo wp_kses_post( $anchor );
							echo '</div>';
							?>
						</div>
					</div>
				</div>
			</div>
		</div>

	<?php
	 // Call Footer
	 get_footer();
?>