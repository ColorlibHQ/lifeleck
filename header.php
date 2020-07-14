<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <!-- For Resposive Device -->
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <?php echo lifeleck_site_icon();?>
        <?php wp_head(); ?>
    </head>
    <body <?php body_class(); ?>>

    <?php wp_body_open(); ?>

    <!--::header part start::-->
    <header class="main_menu">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <nav class="navbar navbar-expand-lg navbar-light">
                        <?php
                            echo lifeleck_theme_logo( 'navbar-brand' );
                        ?>
                        <button class="navbar-toggler" type="button" data-toggle="collapse"
                            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <?php
                            if(has_nav_menu('primary-menu')) {
                                wp_nav_menu(array(
                                    'menu'           => 'primary-menu',
                                    'theme_location' => 'primary-menu',
                                    'menu_id'        => 'menu-main-menu',
                                    'container_class'=> 'collapse navbar-collapse main-menu-item justify-content-center',
                                    'container_id'   => 'navbarSupportedContent',
                                    'menu_class'     => 'navbar-nav',
                                    'walker'         => new lifeleck_bootstrap_navwalker,
                                    'depth'          => 3
                                ));
                            }
                        ?>

                        <div class="header_social_icon d-none d-lg-block">
                            <ul>
                                <?php
                                    $searchIcon = lifeleck_opt( 'lifeleck_hsearchform_toggle' );
                                    if( $searchIcon == 1 ){ ?>
                                <li>
                                    <div id="wrap">
                                    <form action="<?php echo esc_url( site_url( '/' ) ); ?>">
                                        <input id="search" type="text" class="form-control" name="s" placeholder="<?php esc_html_e( 'Search here', 'lifeleck' ); ?>">
                                        <button type="submit" class="btn" ><span class="ti-search"></span> </button>
                                    </form>
                                    </div>
                                </li>
                                <?php }?>

                                <?php
                                    $social_opt = lifeleck_opt('lifeleck_social_profile_toggle');
                                    if ( $social_opt == true ) {
                                        $social_items = lifeleck_opt('lifeleck_header_social');
                                        if( is_array( $social_items ) && count( $social_items ) > 0 ){
                                            foreach ($social_items as $value) {
                                                echo '<li><a href="'. $value['social_url'] .'" class="d-none d-lg-block"><i class="'. $value['social_icon'] .'"></i></a></li>';
                                            }
                                        }          
                                    }          
                        
                                ?>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <!-- Header part end-->

    <?php
    //Page Title Bar
    if( function_exists( 'lifeleck_page_titlebar' ) ){
	    lifeleck_page_titlebar();
    }

