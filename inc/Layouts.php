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

class Layouts {

    protected static $instance = null;

	public function __construct() {
		add_action( 'template_redirect', array( $this, 'layout_settings' ), 9 );
	}
    
    public static function instance() {
        if ( null == self::$instance ) {
            self::$instance = new self;
        }

        return self::$instance;
    }

	public function layout_settings() {
		// Single Pages
        if( is_single() || is_page() ) {
            $post_type = get_post_type();
            $post_id   = get_the_id();
            switch( $post_type ) {
                case 'page':
                $prefix = 'page';
                break;
                default:
                $prefix = 'single_post';
                break;
            }
			
			$layout_settings = get_post_meta( $post_id, 'cl_hotel_layout_settings', true );
            
            Options::$layout = ( empty( $layout_settings['cl_hotel_layout'] ) || $layout_settings['cl_hotel_layout']  == 'default' ) ? Options::$options[$prefix . '_layout'] : $layout_settings['cl_hotel_layout'];
			
            Options::$header_top = ( empty( $layout_settings['cl_hotel_header_top'] ) || $layout_settings['cl_hotel_header_top'] == 'default' ) ? Options::$options['header_top'] : $layout_settings['cl_hotel_header_top'];

			Options::$tr_header = ( empty( $layout_settings['cl_hotel_tr_header'] ) || $layout_settings['cl_hotel_tr_header'] == 'default' ) ? Options::$options['tr_header'] : $layout_settings['cl_hotel_tr_header'];
			
			Options::$header_area = ( empty( $layout_settings['cl_hotel_header_area'] ) || $layout_settings['cl_hotel_header_area'] == 'default' ) ? Options::$options['header_area'] : $layout_settings['cl_hotel_header_area'];
            
            Options::$header_style = ( empty( $layout_settings['cl_hotel_header'] ) || $layout_settings['cl_hotel_header'] == 'default' ) ? Options::$options['header_style'] : $layout_settings['cl_hotel_header'];

            Options::$has_newsletter = ( empty( $layout_settings['cl_hotel_footer_newsletter'] ) || $layout_settings['cl_hotel_footer_newsletter'] == 'default' ) ? Options::$options['footer_newsletter'] : $layout_settings['cl_hotel_footer_newsletter'];
            
            Options::$footer_area = ( empty( $layout_settings['cl_hotel_footer_area'] ) || $layout_settings['cl_hotel_footer_area'] == 'default' ) ? Options::$options['footer_area'] : $layout_settings['cl_hotel_footer_area'];
			
            Options::$footer_style = ( empty( $layout_settings['cl_hotel_footer'] ) || $layout_settings['cl_hotel_footer'] == 'default' ) ? Options::$options['footer_style'] : $layout_settings['cl_hotel_footer'];
			
            $padding_top = ( empty( $layout_settings['cl_hotel_padding_top'] ) || $layout_settings['cl_hotel_padding_top'] == '' ) ? Options::$options[$prefix . '_padding_top'] : $layout_settings['cl_hotel_padding_top'];
			Options::$padding_top = (int) $padding_top;

			$padding_bottom = ( empty( $layout_settings['cl_hotel_padding_bottom'] ) || $layout_settings['cl_hotel_padding_bottom'] == '' ) ? Options::$options[$prefix . '_padding_bottom'] : $layout_settings['cl_hotel_padding_bottom'];
			Options::$padding_bottom = (int) $padding_bottom;
            
            Options::$has_banner = ( empty( $layout_settings['cl_hotel_banner'] ) || $layout_settings['cl_hotel_banner'] == 'default' ) ? Options::$options[$prefix . '_banner'] : $layout_settings['cl_hotel_banner'];
            
            Options::$bgcolor = empty( $layout_settings['cl_hotel_banner_bgcolor'] ) ? Options::$options[$prefix . '_bgcolor'] : $layout_settings['cl_hotel_banner_bgcolor'];

            Options::$opacity = empty( $layout_settings['cl_hotel_banner_bgopacity'] ) ? Options::$options[$prefix . '_bgopacity'] : $layout_settings['cl_hotel_banner_bgopacity'];

            if( is_singular( 'rtcl_listing' ) ) {
                $padding_top = Options::$options['listing_post_padding_top'];
                $padding_bottom = Options::$options['listing_post_padding_bottom'];
                Options::$has_banner = Options::$options['listing_post_banner'];
                Options::$padding_top = (int) $padding_top;
                Options::$padding_bottom = (int) $padding_bottom;
                Options::$bgcolor = Options::$options['listing_post_bgcolor'];
                Options::$opacity = Options::$options['listing_post_bgopacity']; 
                if (!empty(Options::$options['listing_post_bgimg'])) {
                    $attch_url = wp_get_attachment_image_src( Options::$options['listing_post_bgimg'], 'full', true ); 
                    Options::$bgimg = $attch_url[0];
                } else {
                    Options::$bgimg = '';
                }
			} elseif( !empty( $layout_settings['cl_hotel_banner_bgimg'] ) ) {
                $attch_url      = wp_get_attachment_image_src( $layout_settings['cl_hotel_banner_bgimg'], 'full', true );
                Options::$bgimg = $attch_url[0];
            } elseif( !empty( Options::$options[$prefix . '_bgimg'] ) ) {
                $attch_url      = wp_get_attachment_image_src( Options::$options[$prefix . '_bgimg'], 'full', true );
                Options::$bgimg = $attch_url[0];
            } else {
                Options::$bgimg = '';
            }
			
            Options::$pagebgcolor = empty( $layout_settings['cl_hotel_page_bgcolor'] ) ? Options::$options[$prefix . '_page_bgcolor'] : $layout_settings['cl_hotel_page_bgcolor'];			
            
            if( !empty( $layout_settings['cl_hotel_page_bgimg'] ) ) {
                Options::$pagebgimg = wp_get_attachment_image_src( $layout_settings['cl_hotel_page_bgimg'], 'full', true );
            } elseif( !empty( Options::$options[$prefix . '_page_bgimg'] ) ) {
                Options::$pagebgimg = wp_get_attachment_image_src( Options::$options[$prefix . '_page_bgimg'], 'full', true );
            }
        }
        
        // Blog and Archive
        elseif( is_home() || is_archive() || is_search() || is_404() ) {
            if( is_search() ) {
                $prefix = 'search';
            } else if( is_404() ) {
                $prefix = 'error';
                Options::$options[$prefix . '_layout'] = 'full-width';
            } elseif( is_post_type_archive( "rtcl_listing" ) || is_tax( "rtcl_category" ) ) {
                $prefix = 'listing'; 
            } elseif( function_exists( 'is_woocommerce' ) && is_woocommerce() ) {
                $prefix = 'shop';
			} elseif( is_post_type_archive( "cl_hotel_team" ) || is_tax( "cl_hotel_team_category" ) ) {
                $prefix = 'team_archive'; 
			} else {
                $prefix = 'blog';
            }
            
            Options::$layout         = Options::$options[$prefix . '_layout'];
            Options::$header_top     = Options::$options['header_top'];
            Options::$tr_header      = Options::$options['tr_header'];
            Options::$header_area    = Options::$options['header_area'];
            Options::$has_newsletter = Options::$options['footer_newsletter'];
            Options::$footer_area    = Options::$options['footer_area'];
            Options::$header_style   = Options::$options['header_style'];
            Options::$footer_style   = Options::$options['footer_style'];
            Options::$padding_top    = Options::$options[$prefix . '_padding_top'];
            Options::$padding_bottom = Options::$options[$prefix . '_padding_bottom'];
            Options::$has_banner     = Options::$options[$prefix . '_banner'];
            Options::$bgcolor        = Options::$options[$prefix . '_bgcolor'];
            Options::$opacity        = Options::$options[$prefix . '_bgopacity'];
			
            if( !empty( Options::$options[$prefix . '_bgimg'] ) ) {
                $attch_url      = wp_get_attachment_image_src( Options::$options[$prefix . '_bgimg'], 'full', true );
                Options::$bgimg = $attch_url[0];
            } else {
                Options::$bgimg = '';
            }
			
            Options::$pagebgcolor = Options::$options[$prefix . '_page_bgcolor'];
            if( !empty( Options::$options[$prefix . '_page_bgimg'] ) ) {
                $attch_url  = wp_get_attachment_image_src( Options::$options[$prefix . '_page_bgimg'], 'full', true );
                Options::$pagebgimg = wp_get_attachment_image_src( Options::$options[$prefix . '_page_bgimg'], 'full', true );
            }		
			
        }
	}
}
