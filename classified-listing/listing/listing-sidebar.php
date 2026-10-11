<?php
/**
 * @author        RadiusTheme
 * @package       cl-hotel/templates
 * @version       1.1.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use RadiusTheme\CLHotel\Options;
use Rtcl\Helpers\Functions;
global $listing;

$sidebar_position = Functions::get_option_item( 'rtcl_single_listing_settings', 'detail_page_sidebar_position', 'right' );
$sidebar_class = [
	'col-lg-3',
	'order-lg-2',
];
if ( $sidebar_position == "left" ) {
	$sidebar_class   = array_diff( $sidebar_class, [ 'order-2' ] );
	$sidebar_class[] = 'order-1';
} elseif ( $sidebar_position == "bottom" ) {
	$sidebar_class   = array_diff( $sidebar_class, [ 'col-lg-3' ] );
	$sidebar_class[] = 'rtcl-listing-bottom-sidebar';
}
?>

<!-- Seller / User Information -->
<div id="sticky_sidebar" class="<?php echo esc_attr( implode( ' ', $sidebar_class ) ); ?>">
    <div class="listing-sidebar">
		<?php 
			if (Options::$options['listing_list_information']) {
				$listing->the_user_info();
			} 
			if (Options::$options['listing_list_timing']) {
				do_action('rtcl_single_listing_business_hours');
			} 
		?>
		<?php if ( is_active_sidebar( 'rtcl-single-sidebar' ) ): ?>
            <aside class="sidebar-widget">
				<?php dynamic_sidebar( 'rtcl-single-sidebar' ); ?>
            </aside>
		<?php endif; ?>

    </div>
</div>
