<?php
/**
 * The template for displaying product content in the single-rtcl_listing.php template
 *
 * This template can be overridden by copying it to yourtheme/classified-listing/content-single-rtcl_listing.php.
 *
 * @package ClassifiedListing/Templates
 * @version 1.5.56
 */

use RadiusTheme\CLHotel\Listing_Functions;
use RadiusTheme\CLHotel\Helper;
use Rtcl\Helpers\Functions;

defined('ABSPATH') || exit;

global $listing;

if (post_password_required()) {
    echo wp_kses_post( get_the_password_form() );
    return;
}

$style = Listing_Functions::listing_single_style();

/**
 * Hook: rtcl_before_single_product.
 *
 * @hooked rtcl_print_notices - 10
 */
do_action( 'rtcl_before_single_listing' );

?>

<div id="rtcl-listing-<?php the_ID(); ?>" <?php Functions::listing_class( '', $listing ); ?>>
    <?php Helper::get_custom_listing_template( 'single/content-single-' . $style); ?>   
</div>

<?php do_action('rtcl_after_single_listing'); ?>
