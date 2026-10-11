<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace RadiusTheme\CLHotel;

use RtclPro\Helpers\Fns;
use RadiusTheme\CLHotel\Traits\SvgIcons;
use RadiusTheme\CLHotel\Traits\DataTrait;
use RadiusTheme\CLHotel\Traits\LayoutTrait;
use RadiusTheme\CLHotel\Traits\SocialsShare;

class Helper {

	use SvgIcons;
	use DataTrait;
	use LayoutTrait;
	use SocialsShare;

    public static function has_sidebar() {
		return ( self::has_full_width() ) ? false : true;
	}

	public static function has_full_width() {
		$theme_option_full_width = Options::$layout == 'full-width';
		$not_active_sidebar      = ! is_active_sidebar( 'sidebar' );
		$bool                    = $theme_option_full_width || $not_active_sidebar;

		return $bool;
	}

    public static function the_layout_class() {
		$fullwidth_col = ( Options::$options['blog_style'] == 'style1' && is_home() ) ? 'col-sm-10 offset-sm-1 col-12' : 'col-sm-12 col-12';

		$layout_class = self::has_sidebar() ? 'col-lg-8 col-sm-12 col-12' : $fullwidth_col;
		if ( Options::$layout == 'left-sidebar' ) {
			$layout_class .= ' order-lg-2';
		}

		echo esc_attr( apply_filters( 'cl_classified_layout_class', $layout_class ) );
	}

    public static function the_sidebar_class() {
		$sidebar_class = self::has_sidebar() ? 'col-lg-4 col-sm-12 sidebar-break-lg' : 'col-sm-12 col-12';
		echo esc_attr( apply_filters( 'cl_classified_sidebar_class', $sidebar_class ) );
	}

	public static function comments_callback( $comment, $args, $depth ){
		$args2 = get_defined_vars();
		Helper::get_template_part( 'template-parts/comments-callback', $args2 );
	}

	public static function nav_menu_args(){
		$nav_menu_args = array( 
			'theme_location' => 'primary', 
			'container' => 'ul',
			'menu_class' => 'main-menu',
		);
		return $nav_menu_args;
	}

	public static function requires( $filename, $dir = false ) {
		if ( $dir ) {
			$child_file = get_stylesheet_directory() . '/' . $dir . '/' . $filename;

			if ( file_exists( $child_file ) ) {
				$file = $child_file;
			} else {
				$file = get_template_directory() . '/' . $dir . '/' . $filename;
			}
		} else {
			$child_file = get_stylesheet_directory() . '/inc/' . $filename;

			if ( file_exists( $child_file ) ) {
				$file = $child_file;
			} else {
				$file = Constants::$theme_inc_dir . $filename;
			}
		}
		if ( file_exists( $file ) ) {
			require_once $file;
		} else {
			return false;
		}
	}

	public static function get_file( $path ) {
		$file = get_stylesheet_directory_uri() . $path;
		if ( ! file_exists( $file ) ) {
			$file = get_template_directory_uri() . $path;
		}

		return $file;
	}

	public static function get_img( $filename ) {
		$path = '/assets/img/' . $filename;

		return self::get_file( $path );
	}

	public static function get_build_css( $filename ) {
		$path = '/assets/build/' . $filename . '.css';

		return self::get_file( $path );
	}

	public static function get_css( $filename ) {
		$path = '/assets/css/' . $filename . '.css';

		return self::get_file( $path );
	}

	public static function get_min_css( $filename ){
		$path = '/assets/css/minified/' . $filename . '.css';
		return self::get_file( $path );
	}

	public static function get_vendor_css( $filename ){
		$path = '/assets/vendor/' . $filename . '.css';
		return self::get_file( $path );
	}

	public static function get_maybe_rtl_css( $filename ) {
		if ( is_rtl() ) {
			$path = '/assets/rtl-css/' . $filename . '.css';

			return self::get_file( $path );
		} else {
			return self::get_css( $filename );
		}
	}

	public static function get_rtl_css( $filename ) {
		$path = '/assets/css-rtl/' . $filename . '.css';

		return self::get_file( $path );
	}

	public static function get_build_js( $filename ){
		$path = '/assets/build/' . $filename . '.js';
		return self::get_file( $path );
	}

	public static function get_js( $filename ) {
		$path = '/assets/js/' . $filename . '.js';

		return self::get_file( $path );
	}

	public static function get_vendor_js( $filename ){
		$path = '/assets/vendor/' . $filename . '.js';
		return self::get_file( $path );
	}

	public static function get_template_part( $template, $args = [] ) {
		extract( $args );

		$template = '/' . $template . '.php';

		if ( file_exists( get_stylesheet_directory() . $template ) ) {
			$file = get_stylesheet_directory() . $template;
		} else {
			$file = get_template_directory() . $template;
		}
		if ( file_exists( $file ) ) {
			require $file;
		} else {
			return false;
		}
	}

	public static function get_custom_listing_template( $template, $echo = true, $args = array() ){
		$template = 'classified-listing/custom/' . $template;
		if ( $echo ) {
			self::get_template_part( $template, $args );
		}
		else {
			$template .= '.php'; 
			return $template;
		}
	}

	public static function get_custom_store_template( $template, $echo = true, $args = array() ){
		$template = 'classified-listing/store/custom/' . $template;
		if ( $echo ) {
			self::get_template_part( $template, $args );
		}
		else {
			$template .= '.php'; 
			return $template;
		}
	}

public static function is_chat_enabled() {
	if ( Options::$options['header_chat_icon'] && class_exists( 'RtclPro' ) ) {
		if ( Fns::is_enable_chat() ) {
			return true;
		}
	}
	return false;
}

   public static function get_primary_color() {
      return apply_filters( 'rdtheme_primary_color', Options::$options['primary_color'] ); // #5f40fb
   }

	public static function wp_set_temp_query( $query ) {
		global $wp_query;
		$temp = $wp_query;
		$wp_query = $query;
		return $temp;
	}

	public static function wp_reset_temp_query( $temp ) {
		global $wp_query;
		$wp_query = $temp;
		wp_reset_postdata();
	}

	public static function pagination( $max_num_pages = false ) {
		global $wp_query;
		$max = $max_num_pages ? $max_num_pages : $wp_query->max_num_pages;
		$max = intval( $max );

		/** Stop execution if there's only 1 page */
		if( $max <= 1 ) return;

		$paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;

		/**	Add current page to the array */
		if ( $paged >= 1 )
			$links[] = $paged;

		/**	Add the pages around the current page to the array */
		if ( $paged >= 3 ) {
			$links[] = $paged - 1;
			$links[] = $paged - 2;
		}

		if ( ( $paged + 2 ) <= $max ) {
			$links[] = $paged + 2;
			$links[] = $paged + 1;
		}

		echo '<div class="pagination"><ul>' . "\n";

		/**	Previous Post Link */
		if ( get_previous_posts_link() )
			printf( '<li class="prev">%s</li>' . "\n", wp_kses_post( get_previous_posts_link( '<i class="demo-icon rt-custom-icon-long-arrow-right left-angle"></i> Previous' ) ) );

		/**	Link to first page, plus ellipses if necessary */
		if ( ! in_array( 1, $links ) ) {
			printf( '<li%s><a href="%s">%s</a></li>' . "\n", ( 1 == $paged ? ' class="active"' : '' ), esc_url( get_pagenum_link( 1 ) ), '1' );

			if ( ! in_array( 2, $links ) )
				echo '<li>...</li>';
		}

		/**	Link to current page, plus 2 pages in either direction if necessary */
		sort( $links );
		foreach ( (array) $links as $link ) {
			printf( '<li%s><a href="%s">%s</a></li>' . "\n", ( $paged == $link ? ' class="active"' : '' ), esc_url( get_pagenum_link( $link ) ), absint( $link ) );
		}

		/**	Link to last page, plus ellipses if necessary */
		if ( ! in_array( $max, $links ) ) {
			printf( '<li%s><a href="%s">%s</a></li>' . "\n", ( $paged == $max ? ' class="active"' : '' ), esc_url( get_pagenum_link( $max ) ), absint( $max ) );
		}

		/**	Next Post Link */
		if ( get_next_posts_link() )
			printf( '<li class="next">%s</li>' . "\n", wp_kses_post( get_next_posts_link( 'Next <i class="demo-icon rt-custom-icon-long-arrow-right"></i>' ) ) );

		echo '</ul></div>' . "\n";
	}

    public static function hex2rgb($hex) {
        $hex = str_replace("#", "", $hex);
        if(strlen($hex) == 3) {
            $r = hexdec(substr($hex,0,1).substr($hex,0,1));
            $g = hexdec(substr($hex,1,1).substr($hex,1,1));
            $b = hexdec(substr($hex,2,1).substr($hex,2,1));
        } else {
            $r = hexdec(substr($hex,0,2));
            $g = hexdec(substr($hex,2,2));
            $b = hexdec(substr($hex,4,2));
        }
        $rgb = "$r, $g, $b";
        return $rgb;
    }

	public static function hex2rgba( $color, $opacity = false ) {

		$defaultColor = 'rgb(0,0,0)';
	
		// Return default color if no color provided
		if ( empty( $color ) ) {
			return $defaultColor;
		}
	
		// Ignore "#" if provided
		if ( $color[0] == '#' ) {
			$color = substr( $color, 1 );
		}
	
		// Check if color has 6 or 3 characters, get values
		if ( strlen($color) == 6 ) {
			$hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
		} elseif ( strlen( $color ) == 3 ) {
			$hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
		} else {
			return $default;
		}
	
		// Convert hex values to rgb values
		$rgb =  array_map( 'hexdec', $hex );
	
		// Check if opacity is set(rgba or rgb)
		if ( $opacity ) {
			if( abs( $opacity ) > 1 ) {
				$opacity = 1.0;
			}
			$output = 'rgba(' . implode( ",", $rgb ) . ',' . $opacity . ')';
		} else {
			$output = 'rgb(' . implode( ",", $rgb ) . ')';
		}
	
		// Return rgb(a) color string
		return $output;
	
	}

}