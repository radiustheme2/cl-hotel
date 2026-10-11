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
use RadiusTheme\CLHotel\Options;

$nav_menu_args  = Helper::nav_menu_args();
$header_login 	= Options::$options['header_login'] ? true : false;
$header_listing = Options::$options['header_listing'] ? true : false;

if ( $header_login == true && $header_listing == true ) {
    $align_class = 'justify-content-center';
} else {
    $align_class = 'justify-content-end';
}

?>
<div class="menu-wrap">
	<div id="site-navigation" class="main-navigation">
        <nav class="site-nav <?php echo esc_attr( $align_class ); ?>">
            <?php if ( has_nav_menu( 'primary' ) ) { 
                wp_nav_menu( $nav_menu_args );
            } else {
                if ( is_user_logged_in() ) {
                    echo '<ul id="menu" class="menu fallbackcd-menu-item"><li class="menu-item"><a class="fallbackcd" href="' . esc_url( admin_url( 'nav-menus.php' ) ) . '">' . esc_html__( 'Add a menu', 'cl-hotel' ) . '</a></li></ul>';
                }
            } ?>
        </nav>
    </div>
</div>