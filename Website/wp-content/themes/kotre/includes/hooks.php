<?php
/**
 * Load hooks.
 *
 * @package Kotre
 */

//=============================================================
// Doctype hook of the theme
//=============================================================
if ( ! function_exists( 'kotre_doctype_action' ) ) :
    /**
     * Doctype declaration of the theme.
     *
     * @since 1.0.0
     */
    function kotre_doctype_action() {
    ?><!DOCTYPE html> <html <?php language_attributes(); ?>><?php
    }
endif;

add_action( 'kotre_doctype', 'kotre_doctype_action', 10 );

//=============================================================
// Head hook of the theme
//=============================================================
if ( ! function_exists( 'kotre_head_action' ) ) :
    /**
     * Header hook of the theme.
     *
     * @since 1.0.0
     */
    function kotre_head_action() {
    ?>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <?php
    }
endif;

add_action( 'kotre_head', 'kotre_head_action', 10 );

//=============================================================
// Before header hook of the theme
//=============================================================
if ( ! function_exists( 'kotre_before_header_action' ) ) :
    /**
     * Header Start.
     *
     * @since 1.0.0
     */
    function kotre_before_header_action() { ?>
        <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'kotre' ); ?></a>
        <header id="masthead" class="site-header" role="banner"><?php
    }
endif;

add_action( 'kotre_before_header', 'kotre_before_header_action' );

//=============================================================
// Header main hook of the theme
//=============================================================
if ( ! function_exists( 'kotre_header_action' ) ) :

    /**
     * Site Header.
     *
     * @since 1.0.0
     */
    function kotre_header_action() { ?>

        <div class="container-full">
            <div class="head-wrap">
                <div class="site-branding">
                    <?php 

                    $site_identity = kotre_get_option( 'site_identity' ); 

                    if( 'logo-only' == $site_identity ){  

                        kotre_the_custom_logo(); 

                    }elseif( 'title-only' == $site_identity ){ ?>

                        <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>

                        <?php

                    }else{ ?>

                        <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>

                        <?php
                        $description = get_bloginfo( 'description', 'display' );

                        if ( $description || is_customize_preview() ) : ?>

                            <p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>

                            <?php
                        endif; 
                    } ?>
                </div><!-- .site-branding -->
                <div id="main-navigation" class="navigation-wrap">
                    <div id="main-nav" class="clear-fix">
                        <nav id="site-navigation" class="main-navigation" role="navigation">
                            <div class="wrap-menu-content">
                                <?php
                                wp_nav_menu(
                                    array(
                                    'theme_location' => 'primary',
                                    'menu_id'        => 'primary-menu',
                                    'fallback_cb'    => 'kotre_primary_navigation_fallback',
                                    )
                                );
                                ?>
                            </div><!-- .menu-content -->
                        </nav><!-- #site-navigation -->
                    </div> <!-- #main-nav -->

                    <?php

                    $show_search_form = kotre_get_option( 'show_search_form' );
                    $show_social_icons = kotre_get_option( 'show_social_icons' );

                    if ( true == $show_social_icons || true == $show_search_form || class_exists( 'WooCommerce' ) ) { ?>

                        <div class="additional-menu-item">

                            <?php 

                            if ( true == $show_social_icons && has_nav_menu( 'social' ) ) {

                                do_action( 'kotre_additional_item_social' );

                            } 

                            if ( true == $show_search_form ) { ?>

                                <div class="last-menu-item search-wrap">
                                    <a href="#" class="search-btn"><i class="fa fa-search" aria-hidden="true"></i></a>

                                    <div class="search-box" style="display: none;">
                                        <?php get_search_form(); ?>
                                    </div>
                                </div>

                                <?php

                            }

                            if ( class_exists( 'WooCommerce' ) ) { 
                                
                                do_action( 'kotre_additional_item_cart' );

                            } ?>

                        </div>

                        <?php

                    } ?>
                </div>
            </div>
        </div>

            
        <?php
        
    }

endif;

add_action( 'kotre_header', 'kotre_header_action' );

//=============================================================
// After header hook of the theme
//=============================================================
if ( ! function_exists( 'kotre_after_header_action' ) ) :
    /**
     * Header End.
     *
     * @since 1.0.0
     */
    function kotre_after_header_action() {
       
    ?></header><!-- #masthead --><?php
    }
endif;
add_action( 'kotre_after_header', 'kotre_after_header_action' );


//=============================================================
// Before content hook of the theme
//=============================================================
if ( ! function_exists( 'kotre_before_content_action' ) ) :
    /**
     * Content Start.
     *
     * @since 1.0.0
     */
    function kotre_before_content_action() {

        $pid = get_the_ID(); 

        $disable_space = get_post_meta( absint($pid), 'disable_space', true );

        if( ( 'checked' === $disable_space ) ){
            $content_class = 'site-content no-content-space';
        }else{
            $content_class = 'site-content';
        } ?>

        <div id="content" class="<?php echo $content_class; ?>">
        <?php  
        if( !is_page_template('elementor_header_footer') && !is_page_template('templates/bare-page.php') ){ ?>
            <div class="container">
            <div class="inner-wrapper">
            <?php 
        } 
    }
endif;
add_action( 'kotre_before_content', 'kotre_before_content_action' );

//=============================================================
// After content hook of the theme
//=============================================================
if ( ! function_exists( 'kotre_after_content_action' ) ) :
    /**
     * Content End.
     *
     * @since 1.0.0
     */
    function kotre_after_content_action() { 
        if( !is_page_template('elementor_header_footer') && !is_page_template('templates/bare-page.php') ){ ?>
            </div><!-- .inner-wrapper -->
            </div><!-- .container -->
            <?php 
        } ?>
        </div><!-- #content -->
        <?php    
    }
endif;
add_action( 'kotre_after_content', 'kotre_after_content_action' );

//=============================================================
// Credit info hook of the theme
//=============================================================
if ( ! function_exists( 'kotre_credit_info' ) ) :

    function kotre_credit_info(){ ?>

        <div class="site-info">
            <?php printf( esc_html__( '%1$s by %2$s', 'kotre' ), 'Kotre', '<a href="https://wpcharms.com/" target="_blank">WP Charms</a>' ); ?>
        </div><!-- .site-info -->

        <?php 
         
    }

endif;

add_action( 'kotre_credit', 'kotre_credit_info', 10 );


//=============================================================
// Additional item type social links hook of the theme
//=============================================================
if ( ! function_exists( 'kotre_additional_item_social_action' ) ) :

    function kotre_additional_item_social_action(){ ?>

        <div class="last-menu-item kotre-social-icons"> 
           <?php 
           if ( has_nav_menu( 'social' ) ) {
               wp_nav_menu( array(
                   'theme_location' => 'social',
                   'link_before'    => '<span class="screen-reader-text">',
                   'link_after'     => '</span>',
                   'depth'          => 1,
               ) );
           } ?>
        </div>
       <?php
    }

endif;

add_action( 'kotre_additional_item_social', 'kotre_additional_item_social_action', 10 );

//=============================================================
// Additional item type cart hook of the theme
//=============================================================
if ( ! function_exists( 'kotre_additional_item_cart_action' ) ) :

    function kotre_additional_item_cart_action(){ ?>

        <div class="last-menu-item top-cart-wrap">

            <div class="top-icon-wrap">
                <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="top-cart-link">
                    <span class="cart-value kotre-cart-fragment"><?php echo wp_kses_data( WC()->cart->get_cart_contents_count() );?></span>
                </a>
            </div>
            <div class="top-cart-content">
                <?php the_widget( 'WC_Widget_Cart', '' ); ?>
            </div>

        </div>

        <?php
    }

endif;

add_action( 'kotre_additional_item_cart', 'kotre_additional_item_cart_action', 10 );

//=============================================================
// Body open hook
//=============================================================
if ( ! function_exists( 'wp_body_open' ) ) {
    /**
     * Body open hook.
     */
    function wp_body_open() {
        do_action( 'wp_body_open' );
    }
}