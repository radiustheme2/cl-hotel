<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use RadiusTheme\CLHotel\Options;
use RtclStore\Helpers\Functions as StoreFunctions;

if ( is_404() ) {
	$rdtheme_title = Options::$options['error_page_breadcrumb_title'];
	$rdtheme_title = $rdtheme_title . get_search_query();
} elseif ( is_search() ) {
	$rdtheme_title = esc_html__( 'Search Results for : ', 'cl-hotel' ) . get_search_query();
} elseif ( is_home() ) {
	if (!empty(Options::$options['blog_breadcrumb_title'])) {
		$rdtheme_title = Options::$options['blog_breadcrumb_title'];
	} elseif ( get_option( 'page_for_posts' ) ) {
		$rdtheme_title = get_the_title( get_option( 'page_for_posts' ) );
	} else {
		$rdtheme_title = apply_filters( "clhotel_blog_title", esc_html__( 'All Posts', 'cl-hotel' ) );
	}	
} elseif ( is_archive() ) {
	if ( is_post_type_archive( "rtcl_listing" ) ) {
		$rdtheme_title = esc_html__( 'Listing Archive', 'cl-hotel' );
	} else {
		$rdtheme_title = get_the_archive_title();
	}
} elseif (is_singular( 'rtcl_listing' )) {

	if ( (Options::$options['show_heading_on_banner']) ) {
		$rdtheme_title  = get_the_title();
	} else {
		$rdtheme_title  = esc_html__( 'Listing Details', 'cl-hotel' );
	}

} elseif (is_singular( 'rtcl_agent' )) {
	$rdtheme_title  = esc_html__( 'Single Author Page', 'cl-hotel' );
} elseif (is_singular( 'store' )) {
	$rdtheme_title  =  get_the_title();
} elseif (is_single()) {
	if (!empty(Options::$options['post_details_breadcrumb_title'])) {
		$rdtheme_title = Options::$options['post_details_breadcrumb_title'];
	} else {
		$rdtheme_title = apply_filters( "clhotel_blog_title", esc_html__( 'Post Details', 'cl-hotel' ) );
	}
} else {
	$rdtheme_title = get_the_title();	
}

$bgimg = Options::$bgimg;

?>

<section class="breadcrumbs-banner">
    <div class="container">
        <div class="breadcrumbs-area">
			<?php 
				if( function_exists( 'bcn_display') ){
					get_template_part( 'template-parts/content', 'breadcrumb' );
				}
				if ( is_post_type_archive( "rtcl_agent" ) || is_post_type_archive( "store" ) ) { ?>
					<h1 class="heading-title"><?php StoreFunctions::page_title(); ?></h1>
				<?php } else {
					echo '<h1 class="heading-title">'.wp_kses_post( $rdtheme_title ).'</h1>';

				}
			?>
        </div>
    </div>
</section>

<!--=====================================-->
<!--=         Inner Banner Start    	=-->
<!--=====================================-->