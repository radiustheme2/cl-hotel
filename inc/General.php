<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace RadiusTheme\CLHotel;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class General {

	protected static $instance = null;

	public function __construct() {
		add_action( 'after_setup_theme',	array( $this, 'theme_setup' ) );
		add_action( 'widgets_init',			array( $this, 'register_sidebars' ) );
		add_filter( 'body_class',			array( $this, 'body_classes' ) );
		add_action( 'wp_head',				array( $this, 'noscript_hide_preloader' ), 1 );
		add_action( 'wp_head',				array( $this, 'pingback' ) );
		add_action( 'site_prealoader',      array( $this, 'cl_hotel_preloader' ) );
		add_action( 'wp_footer',            array( $this, 'scroll_to_top_html' ), 1 );
		add_filter( 'get_search_form',		array( $this, 'search_form' ) );
	}

	public static function instance() {
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	public function theme_setup() {
		// Theme supports
		add_theme_support( 'title-tag' );
		add_theme_support( 'custom-logo' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );
		add_theme_support( 'wp-block-styles' );
		remove_theme_support( 'widgets-block-editor' );

		// Image sizes
		$sizes = array(
			'cl-hotel-size1' => array( 415, 280, true ), // Listing Grid
			'cl-hotel-size2' => array( 415, 385, true ), // Listing List
		);

		$sizes = apply_filters( 'clhotel_image_size', $sizes );

		foreach ( $sizes as $size => $value ) {
			add_image_size( $size, $value[0], $value[1], $value[2] );
		}

		// Register menus
		register_nav_menus( array(
			'primary'  => esc_html__( 'Primary', 'cl-hotel' ),
		) );
	}

	public function register_sidebars() {
		$footer_widget_titles1 = array(
			'1' => esc_html__( 'Footer (Style 1) 1', 'cl-hotel' ),
			'2' => esc_html__( 'Footer (Style 1) 2', 'cl-hotel' ),
			'3' => esc_html__( 'Footer (Style 1) 3', 'cl-hotel' ),
			'4' => esc_html__( 'Footer (Style 1) 4', 'cl-hotel' ),
			'5' => esc_html__( 'Footer (Style 1) 5', 'cl-hotel' ),
			'6' => esc_html__( 'Footer (Style 1) 6', 'cl-hotel' ),
		);
		$footer_widget_titles2 = array(
			'1' => esc_html__( 'Footer (Style 2) 1', 'cl-hotel' ),
			'2' => esc_html__( 'Footer (Style 2) 2', 'cl-hotel' ),
			'3' => esc_html__( 'Footer (Style 2) 3', 'cl-hotel' ),
			'4' => esc_html__( 'Footer (Style 2) 4', 'cl-hotel' ),
			'5' => esc_html__( 'Footer (Style 2) 5', 'cl-hotel' ),
			'6' => esc_html__( 'Footer (Style 2) 6', 'cl-hotel' ),
		);
		$widgets_items1 = Options::$options['f1_widgets_area']; 
		$widgets_items2 = Options::$options['f1_widgets_area'];

		register_sidebar( array(
			'name'          => esc_html__( 'Sidebar Widgets', 'cl-hotel' ),
			'id'            => 'sidebar',
			'description'   => esc_html__('Sidebar widgets area', 'cl-hotel'),
			'before_widget' => '<div id="%1$s" class="widget %2$s sidebar-widget">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );
		for ( $i = 1; $i <= $widgets_items1; $i++ ) {
			register_sidebar( array(
				'name'          => $footer_widget_titles1[$i],
				'id'            => 'footer-widget-1-'. $i,
				'before_widget' => '<div id="%1$s" class="widget footer-widgets'. Options::$footer_style .' %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			) );
		}
		if( class_exists( 'CLHotel_Core' ) ){
			for ( $i = 1; $i <= $widgets_items2; $i++ ) {
				register_sidebar( array(
					'name'          => $footer_widget_titles2[$i],
					'id'            => 'footer-widget-2-'. $i,
					'before_widget' => '<div id="%1$s" class="widget footer-widgets'. Options::$footer_style .' %2$s">',
					'after_widget'  => '</div>',
					'before_title'  => '<h3 class="widget-title">',
					'after_title'   => '</h3>',
				) );
			}
		}
	}

	public function body_classes( $classes ) {

		if ( Options::$tr_header == '1' || Options::$tr_header === "on" ) {
			$classes[] = 'trheader';
		}
		if ( Options::$header_top == '1' || Options::$header_top === "on" ) {
			$classes[] = 'top-bar-enable';
		}

		if ( Options::$options['sticky_header'] == 1 ) {
			$classes[] = 'sticky-header';
		}

		if (is_front_page() && !is_home()) {
			$classes[] = 'front-page';
		}

		if (!is_front_page() || is_home()) {
			$classes[] = 'bg-aash';
		}

		return $classes;
	}

	public function noscript_hide_preloader(){
		// Hide preloader if js is disabled
		echo '<noscript><style>#preloader{display:none;}</style></noscript>';
	}

	public function pingback() {
		if ( is_singular() && pings_open() ) {
			printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
		}
	}

	public function cl_hotel_preloader() {
		$stringtext = Options::$options['page_loader_text'];
		$uploaded_img = ! empty( Options::$options['preloader_image'] ) ? Options::$options['preloader_image'] : '';
		// $uploaded_img = get_theme_mod( 'preloader_image', '' );


		if ( $uploaded_img ) {
			echo '
				<div id="pageoverlay" class="pageoverlay">
					<div id="pageLoader" class="pageLoader">
						<img src="' . esc_url( $uploaded_img ) . '" alt="' . esc_attr__( 'Preloader', 'cl-hotel' ) . '" />
					</div>
				</div>
			';
		} else {

			$txt_arrar = str_split($stringtext);
			$items = '';
			foreach ($txt_arrar as $value) {
				$items .= '<span>' . esc_html( $value ) . '</span>';
			}

			echo wp_kses_post( '
			<div id="pageoverlay" class="pageoverlay"><div id="pageLoader" class="pageLoader">
				<div class="loader">
					<div class="window"></div>
					<div class="window"></div>
					<div class="window"></div>
					<div class="window"></div>
					<div class="window"></div>
					<div class="window"></div>
					<div class="window"></div>
					<div class="window"></div>
					<div class="window"></div>
					<div class="window"></div>
					<div class="window"></div>
					<div class="window"></div>
					<div class="window"></div>
					<div class="window"></div>
					<div class="window"></div>
					<div class="window"></div>
					<div class="window"></div>
					<div class="window"></div>
					<div class="window"></div>
					<div class="window"></div>
					<div class="window"></div>
					<div class="window"></div>
					<div class="window"></div>
					<div class="window"></div>
					<div class="window"></div>
					<div class="door"></div>
					<div class="hotel-sign">
						' . $items . '
					</div>
				</div>
			</div></div>
		' );
		}
	}

	public function scroll_to_top_html(){
		// Back-to-top link 
		if ( Options::$options['back_to_top'] == '1' ){
		echo '<a href="#wrapper" data-type="section-switch" class="scrollup">
			<i class="fa-solid fa-arrow-up"></i>
		</a>';
		}
	}

	public function search_form(){
		$output =  '
		<form role="search" method="get" class="search-form" action="' . esc_url( home_url( '/' ) ) . '">
            <div class="custom-search-input widget-box">
                <div class="input-group stylish-input-group">
                    <input type="text" class="form-control" placeholder="' . esc_attr__( 'Search here ...', 'cl-hotel' ) . '" value="' . get_search_query() . '" name="s" />
                    <span class="input-group-addon">
                        <button type="submit">
                            <span class="rt-custom-icon-rt18-search"></span>
                        </button>
                    </span>
                </div>
            </div>
		</form>
		';
		return $output;
	}
}