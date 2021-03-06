<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Kotre
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function kotre_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter( 'body_class', 'kotre_body_classes' );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function kotre_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'kotre_pingback_header' );

/**
 * Display custom logo
 */
if ( ! function_exists( 'kotre_the_custom_logo' ) ) :

	/**
	 * Displays custom logo.
	 *
	 * @since 1.0.0
	 */
	function kotre_the_custom_logo() {
		if ( function_exists( 'the_custom_logo' ) ) {
			the_custom_logo();
		}
	}
endif;

/**
 * Add go to top
 */
if ( ! function_exists( 'kotre_footer_goto_top' ) ) :

	/**
	 * Add Go to top.
	 *
	 * @since 1.0.0
	 */
	function kotre_footer_goto_top() {

		$goto_top = kotre_get_option( 'goto_top' );

		$goto_top_type = kotre_get_option( 'goto_top_type' );

		if( 1 != $goto_top ){

			echo '<a href="#page" class="scrollup '.$goto_top_type.'" id="btn-scrollup"></a>';

		}
	}
endif;

add_action( 'wp_footer', 'kotre_footer_goto_top' );

if ( ! function_exists( 'kotre_implement_excerpt_length' ) ) :

	/**
	 * Implement excerpt length.
	 *
	 * @since 1.0.0
	 *
	 * @param int $length The number of words.
	 * @return int Excerpt length.
	 */
	function kotre_implement_excerpt_length( $length ) {

		$excerpt_length = kotre_get_option( 'excerpt_length' );
		
		if ( absint( $excerpt_length ) > 0 ) {

			$length = absint( $excerpt_length );

		}

		return $length;

	}
endif;

if ( ! function_exists( 'kotre_content_more_link' ) ) :

	/**
	 * Implement read more in content.
	 *
	 * @since 1.0.0
	 *
	 * @param string $more_link Read More link element.
	 * @param string $more_link_text Read More text.
	 * @return string Link.
	 */
	function kotre_content_more_link( $more_link, $more_link_text ) {

		$read_more_text = kotre_get_option( 'readmore_text' );
		if ( ! empty( $read_more_text ) ) {
			$more_link = str_replace( $more_link_text, esc_html( $read_more_text ), $more_link );
		}
		return $more_link;

	}

endif;

if ( ! function_exists( 'kotre_implement_read_more' ) ) :

	/**
	 * Implement read more in excerpt.
	 *
	 * @since 1.0.0
	 *
	 * @param string $more The string shown within the more link.
	 * @return string The excerpt.
	 */
	function kotre_implement_read_more( $more ) {

		$output = $more;

		$read_more_text = kotre_get_option( 'readmore_text' );

		if ( ! empty( $read_more_text ) ) {

			$output = '&hellip;<p><a href="' . esc_url( get_permalink() ) . '" class="button btn-continue">' . esc_html( $read_more_text ) . '</a></p>';

		}

		return $output;

	}
endif;

if ( ! function_exists( 'kotre_hook_read_more_filters' ) ) :

	/**
	 * Hook read more and excerpt length filters.
	 *
	 * @since 1.0.0
	 */
	function kotre_hook_read_more_filters() {
		if ( is_home() || is_category() || is_tag() || is_author() || is_date() || is_search() ) {

			add_filter( 'excerpt_length', 'kotre_implement_excerpt_length', 999 );
			add_filter( 'the_content_more_link', 'kotre_content_more_link', 10, 2 );
			add_filter( 'excerpt_more', 'kotre_implement_read_more' );

		}
	}
endif;
add_action( 'wp', 'kotre_hook_read_more_filters' );

//=============================================================
// Recommended plugins
//=============================================================
if ( ! function_exists( 'kotre_plugins_recommendation' ) ) :

function kotre_plugins_recommendation() {
	
	$plugins = array(
		array(
			'name'     => esc_html__( 'One Click Demo Import', 'kotre' ),
			'slug'     => 'one-click-demo-import',
			'required' => false,
		),
		array(
			'name'     => esc_html__( 'Elementor Page Builder', 'kotre' ),
			'slug'     => 'elementor',
			'required' => false,
		),
		array(
			'name'     => esc_html__( 'Post Grid Elementor Addon', 'kotre' ),
			'slug'     => 'post-grid-elementor-addon',
			'required' => false,
		),
		array(
			'name'     => esc_html__( 'Add Instagram Feed For Elementor', 'kotre' ),
			'slug'     => 'add-instagram-feed-for-elementor',
			'required' => false,
		),
	);

	tgmpa( $plugins );
}
endif;

add_action( 'tgmpa_register', 'kotre_plugins_recommendation' );