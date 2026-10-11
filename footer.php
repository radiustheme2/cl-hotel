<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Rtcl\Helpers\Functions;
use RadiusTheme\CLHotel\Options;
use RadiusTheme\CLHotel\Listing_Functions;

$has_newsletter = Options::$has_newsletter;

$footer_style = Options::$footer_style ? Options::$footer_style : 1;

?>

<?php 
    if ( Options::$has_newsletter == '1' || Options::$has_newsletter === "on" ) {
        get_template_part( 'template-parts/footer/newsletter'); 
    }
    if ( Options::$footer_area == '1' || Options::$footer_area === "on" ) {
        get_template_part( 'template-parts/footer/footer', $footer_style );
    }
    if ( class_exists( 'RtclPro' ) && !is_singular('rtcl_listing') ) {
        get_template_part( 'template-parts/footer/photoswipe'); 
    }
    if ( class_exists( 'Rtcl' ) && class_exists( 'RtclPro' ) ) {
	    if (Functions::is_enable_favourite()){ 
		    Listing_Functions::logout_user_favourite(); 
		}
	}
?>

<?php wp_footer(); ?>

</div> 
</body>
</html>