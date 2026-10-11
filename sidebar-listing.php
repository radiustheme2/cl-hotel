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

?>

<div class="<?php Helper::listing_sidebar_class(); ?>">
    <a id="toggle-listing-sidebar" href="#"><?php esc_html_e( 'Toggle Search Bar', 'cl-hotel' ); ?></a>
	<div class="listing-sidebar listing-archive-sidebar">
		<?php dynamic_sidebar( 'rtcl-archive-sidebar' ); ?>
    </div>
</div>
