<?php
/**
 * @package ClassifiedListing/Templates
 * @version 1.5.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Rtcl\Helpers\Functions;
use RadiusTheme\CLHotel\Helper;

global $listing;

// phpcs:disable WordPress.Security.NonceVerification.Recommended
if ( isset( $_GET['view'] ) && in_array( wp_unslash( $_GET['view'] ), [ 'grid', 'list' ], true ) ) {
	$view = sanitize_key( wp_unslash( $_GET['view'] ) );
} else {
	$view = Functions::get_option_item( 'rtcl_archive_listing_settings', 'default_view', 'grid' );
}
// phpcs:enable WordPress.Security.NonceVerification.Recommended

?>

<div <?php Functions::listing_class(); ?> <?php Functions::listing_data_attr_options(); ?>>
	<?php
		if ( $view == 'grid' ) {
			Helper::get_custom_listing_template( 'archive/grid/grid-1');
		} else {
			Helper::get_custom_listing_template( 'archive/list/list-1');
		}
	?>
</div>
