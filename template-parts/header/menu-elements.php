<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Rtcl\Helpers\Link;
use RadiusTheme\CLHotel\Options;

$loginBtnLink = $listingFormLink = '';
// My Account
$header_login = Options::$options['header_login'] ? true : false;
$login_text = Options::$options['header_login_text'];
$login_btn_link = Options::$options['login_btn_link'];
if (!empty($login_btn_link)) {
	$loginBtnLink = $login_btn_link;
} else {
    if (class_exists('Rtcl')) {
	    $loginBtnLink = Link::get_my_account_page_link();
    }
}
// Listing Form
$header_listing = Options::$options['header_listing'] ? true : false;
$btn_text = Options::$options['listing_btn_text'];
$btn_link = Options::$options['listing_btn_link'];
if (!empty($btn_link)) {
	$listingFormLink = $btn_link;
} else {
	if (class_exists('Rtcl')) {
		$listingFormLink = Link::get_listing_form_page_link();
	}
}

if ( $header_login == true || $header_listing == true && $listingFormLink && class_exists( 'Rtcl' ) == true ) {
    
?>
    <div class="nav-action-elements">
        <ul>
            <?php if ( $header_login == true ) { ?>
            <li class="header-login">
                <a href="<?php echo esc_url( $loginBtnLink ); ?>" class="login-btn">
                    <i class="rt-custom-icon-user-2"></i>
                    <?php if ( is_user_logged_in() ) { ?>
                    <span class="text-part"><?php esc_html_e( 'My Account', 'cl-hotel' ); ?></span>
                    <?php } else { ?>
                        <span class="text-part"><?php echo esc_html( $login_text ); ?></span>
                    <?php } ?>
                </a>
            </li>
            <?php } if ( $header_listing == true && $listingFormLink && class_exists( 'Rtcl' ) ) { ?>
                <li class="header-btn">
                    <a href="<?php echo esc_url( $listingFormLink ); ?>" class="listing-btn">
                        <span class="listing-btn__icon">
                            <i class="fa-solid fa-plus"></i>
                        </span>
                        <span class="listing-btn__text"><?php echo esc_html( $btn_text ); ?></span>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </div>
    <?php 
}

?>