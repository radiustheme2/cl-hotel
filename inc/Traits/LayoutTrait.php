<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace RadiusTheme\CLHotel\Traits;
use RadiusTheme\CLHotel\Options;

trait LayoutTrait {
  public static function has_sidebar() {
    return ( self::has_full_width() ) ? false : true;
  }

  /**
   * It will determine whether content will take full width or not 
   * this is determine by 2 parameters - redux theme option and active sidebar
   * @return boolean [description]
   */
  public static function has_full_width() {
    $theme_option_full_width = ( Options::$layout == 'full-width' ) ? true : false; 
    $not_active_sidebar = ! is_active_sidebar('sidebar') ;
    $bool = $theme_option_full_width || $not_active_sidebar;
    return  $bool;
  }

  public static function the_layout_class() {
    $layout_class = self::has_sidebar() ? 'col-lg-8' : 'col-12';
    if ( Options::$layout == 'right-sidebar' ) {
      $layout_class = $layout_class.' order-lg-1';
    } elseif ( Options::$layout == 'left-sidebar' ) {
      $layout_class = $layout_class.' order-lg-2';
    } else {
      $layout_class = $layout_class;
    }
    echo esc_attr( apply_filters( 'cl_hotel_layout_class', $layout_class ) );
  }

  public static function the_sidebar_class() {
    if ( class_exists( 'WooCommerce' ) ) {
      if ( is_shop() || is_product() ) {
        if ( Options::$layout == 'right-sidebar' ) {
          echo esc_attr( apply_filters( 'rt_sidebar_class', 'col-lg-3 order-lg-2' ) );
        } else {
          echo esc_attr( apply_filters( 'rt_sidebar_class', 'col-lg-3 order-lg-1' ) );
        }
      } else {
        if ( Options::$layout == 'right-sidebar' ) {
          echo esc_attr( apply_filters( 'rt_sidebar_class', 'col-lg-4 order-lg-2' ) );
        } else {
          echo esc_attr( apply_filters( 'rt_sidebar_class', 'col-lg-4 order-lg-1' ) );
        }
      }
    } else {
      if ( Options::$layout == 'right-sidebar' ) {
        echo esc_attr( apply_filters( 'rt_sidebar_class', 'col-lg-4 order-lg-2' ) );
      } else {
        echo esc_attr( apply_filters( 'rt_sidebar_class', 'col-lg-4 order-lg-1' ) );
      }
    }
  }

  public static function clhotel_sidebar() {
    if ( Options::$layout == 'right-sidebar' || Options::$layout == 'left-sidebar' && ! self::has_full_width() ) {
      get_sidebar();
    }
  }

  public static function has_footer(){
    if ( !Options::$options['footer_area'] ) {
      return false;
    }
    $footer_column = Options::$options['footer_column'];
    for ( $i = 1; $i <= $footer_column; $i++ ) {
      if ( is_active_sidebar( 'footer-'. $i ) ) {
        return true;
      }
    }
    return false;
  }
  
  public static function has_footer_widget(){
    return is_active_sidebar('footer-1') || is_active_sidebar('footer-2') || is_active_sidebar('footer-3') || is_active_sidebar('footer-4') ;
  }

  public static function listing_archive_lay_cols(){
    return is_active_sidebar('footer-1') || is_active_sidebar('footer-2') || is_active_sidebar('footer-3') || is_active_sidebar('footer-4') ;
  }

  // Listing Layout
  public static function listing_layout_class() {
    $listing_layout_class = is_active_sidebar('rtcl-archive-sidebar') && Options::$options['listing_layout'] != 'full-width' ? 'col-lg-9' : 'col-12';
    if ( Options::$options['listing_layout'] == 'right-sidebar' ) {
      $listing_layout_class = $listing_layout_class.' order-1';
    } elseif ( Options::$options['listing_layout'] == 'left-sidebar' ) {
      $listing_layout_class = $listing_layout_class.' order-2';
    } else {
      $listing_layout_class = $listing_layout_class;
    }
    echo esc_attr( apply_filters( 'listing_layout_class', $listing_layout_class ) );
  }

  public static function listing_sidebar() {
    if ( Options::$options['listing_layout'] == 'right-sidebar' || Options::$options['listing_layout'] == 'left-sidebar' && Options::$options['listing_layout'] != 'full-width' && is_active_sidebar('rtcl-archive-sidebar') ) {
      get_sidebar( 'listing' );
    }
  }
  public static function listing_sidebar_class() {
    if ( Options::$options['listing_layout'] == 'right-sidebar' ) {
      echo esc_attr( apply_filters( 'rt_sidebar_class', 'col-lg-3 order-2 listing-sidebar-right' ) );
    } else {
      echo esc_attr( apply_filters( 'rt_sidebar_class', 'col-lg-3 order-1 listing-sidebar-left' ) );
    }
  }

}
