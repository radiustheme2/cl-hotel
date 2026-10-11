<?php
/**
 * @author  RadiusTheme
 * @since   1.0.0
 * @version 1.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'WP_Customize_Control' ) ) {

	/* = Blog Columns 
	==========================================================*/
	if ( ! function_exists( 'rt_blog_style_2' ) ) {
		function rt_blog_style_2() {
			$blog_style = get_theme_mod( 'blog_style' );
			if ( $blog_style == 2 ) {
				return true;
			}
			return false;
		}
	}

}