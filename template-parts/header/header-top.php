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
$socials = Helper::socials();

$menu_layout_settings = get_post_meta( get_the_id(), 'cl_hotel_layout_settings', true );
$menu_layout = ( empty( $menu_layout_settings['cl_hotel_header_menu'] ) || $menu_layout_settings['cl_hotel_header_menu'] == 'default' ) ? Options::$options['site_body_layout'] : $menu_layout_settings['cl_hotel_header_menu'];

if ( class_exists('Rtcl') && class_exists( 'RtclPro' ) ) {
    if (is_post_type_archive( rtcl()->post_type )) {
        $menu_layout = Options::$options['listing_archive_box_layout'] ? Options::$options['listing_archive_box_layout'] : $menu_layout;
    }
}
if (!empty($menu_layout_settings['cl_hotel_header_top_layout'])) {
    $meta_top = $menu_layout_settings['cl_hotel_header_top_layout'];
} else {
    $meta_top = '';
}
$custom_top = Options::$options['header_top_variation'];
if (!empty($meta_top)) {
    $top = $meta_top;
} else {
    $top = $custom_top;
}

?>

<div id="topbar-wrap" class="topbar topbar-<?php echo esc_attr( $top ); ?>">
    <div class="<?php echo esc_attr( $menu_layout ); ?>">
        <div class="header-top">
            <?php if (!empty(Options::$options['contact_phone'] || Options::$options['contact_email'])) { ?>
                <div class="topbar-contact">
                    <ul>
                        <?php if (!empty(Options::$options['contact_phone'])) { ?>
                        <li class="htop-phone">
                            <a href="tel:<?php echo esc_html( Options::$options['contact_phone'] ); ?>">
                                <i class="clr-icon-rt18-phone"></i>
                                <span class="label-text">
                                    <?php echo esc_html( Options::$options['contact_phone_label'].' '.Options::$options['contact_phone'] ); ?>
                                </span>
                            </a>
                        </li>
                        <?php } if (!empty(Options::$options['contact_email'])) { ?>
                        <li class="htop-email">
                            <a href="mailto:<?php echo esc_html( Options::$options['contact_email'] ); ?>">
                                <i class="clr-icon-email-icon"></i>
                                <span class="label-text">
                                    <?php echo esc_html( Options::$options['contact_email_label'].' '.Options::$options['contact_email'] ); ?>
                                </span>
                            </a>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
            <?php } if ( !empty( $socials ) ) { ?>
                <div class="social-btn">
                    <div class="topbar-follows__header">
                        <span><?php echo esc_html( Options::$options['social_label'] ); ?></span>
                    </div>
                    <ul>
                        <?php foreach ( $socials as $social ): ?>
                        <li class="<?php echo esc_attr( $social['class'] ); ?>">
                            <a class="<?php echo esc_attr( $social['class'] ); ?>" href="<?php echo esc_url( $social['url'] ); ?>" target="_blank">
                                <i class="<?php echo esc_attr( $social['icon'] ); ?>"></i>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
