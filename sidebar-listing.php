<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use RadiusTheme\CLHotel\Helper;

// The Ajax Filter widget has its own mobile "Show Filter" bar, so the theme toggle is not needed with it.
$sidebars_widgets = wp_get_sidebars_widgets();
$has_ajax_filter  = ! empty( $sidebars_widgets['rtcl-archive-sidebar'] )
	&& preg_grep( '/^rtcl-widget-ajax-filter-\d+$/', (array) $sidebars_widgets['rtcl-archive-sidebar'] );

?>

<div class="<?php Helper::listing_sidebar_class(); ?><?php echo $has_ajax_filter ? ' has-ajax-filter' : ''; ?>">
    <a id="toggle-listing-sidebar" href="#"><?php esc_html_e( 'Toggle Search Bar', 'cl-hotel' ); ?></a>
	<div class="listing-sidebar listing-archive-sidebar">
		<?php dynamic_sidebar( 'rtcl-archive-sidebar' ); ?>
    </div>
</div>
