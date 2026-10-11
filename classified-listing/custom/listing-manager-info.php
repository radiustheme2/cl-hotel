<?php
/**
 * @var string  $address
 * @var string  $phone
 * @var string  $whatsapp_number
 * @var string  $email
 * @var string  $website
 * @var array   $phone_options
 * @var bool    $has_contact_form
 * @var string  $email_to_seller_form
 * @var Listing $listing
 * @var array   $locations
 * @var int     $listing_id Listing id
 * @author       RadiusTheme
 * @package      cl-hotel/templates
 * @version      1.0.0
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use RtclPro\Helpers\Fns;
use Rtcl\Helpers\Functions;
use RadiusTheme\CLHotel\Helper;
use RadiusTheme\CLHotel\Listing_Functions;

global $listing;
$managerEmail = '';
$manager_id = get_post_meta( $listing->get_id(), '_rtcl_manager_id', true );
$owner_id   = $manager_id ? $manager_id : $listing->get_owner_id();
$pp_id      = absint( get_user_meta( $owner_id, '_rtcl_pp_id', true ) );

$user_id = get_post_meta( get_the_ID(), '_rtcl_user_id', true );
$user = get_user_by( 'id', $manager_id );
if (!empty($user)) {
    $managerEmail  = $user->user_email;
}

$namagerPhone = get_user_meta( $manager_id, '_rtcl_phone', true );
$website = get_user_meta( $manager_id, '_rtcl_website', true );
$owmerAddress = get_user_meta( $manager_id, '_rtcl_address', true );
$managerWhatsapp = get_user_meta( $manager_id, '_rtcl_whatsapp_number', true );
$managerWebsite = str_replace(['https://', 'http://'], '', $website );

?>

<div class="rtcl-listing-side-title">
	<h3><?php esc_html_e( "Posted By", 'cl-hotel' ); ?></h3>
</div>
<div class="list-group">
    <div class="listing-author listing-manager">
        <div class="author-logo-wrapper">
            <div class="author-avatar">
                <?php Helper::get_listing_manager_image( $listing, 'full' ); ?>
            </div>
        </div>
        <div class="author-info-wrapper">
            <h4 class="author-name">
                <?php if ( $listing->can_add_user_link() && ! is_author() ) : ?>
                <a class="author-link" href="<?php echo esc_url( $listing->get_the_author_url() ); ?>">
                    <?php echo esc_html( $listing->get_author_name() ); ?>
                </a>
                <?php else: ?>
                <?php echo wp_kses_post( $listing->get_author_name() ); ?>
                <?php endif; ?>
                <?php
                    $status = apply_filters( 'rtcl_user_offline_text', esc_html__( 'Offline Now', 'cl-hotel' ) );
                    if ( class_exists('RtclPro') && Fns::is_online( $listing->get_owner_id() ) ) {
                        $status = apply_filters( 'rtcl_user_online_text', esc_html__( 'Online Now', 'cl-hotel' ) );
                    }
                ?>
                <div class="rtcl-user-status <?php echo esc_attr( strtolower( $status ) ); ?>"><span class="user-staus-text"><?php echo wp_kses_post( $status ); ?></span></div>
            </h4>
            <div class="rtin-user-item">
                <?php do_action('rtcl_after_author_meta', $listing->get_owner_id() ); ?>
            </div>
        </div>
    </div>
    <ul class="info-list">
        <?php if ( $owmerAddress ){ ?>
            <li>
                <i class="demo-icon rt-custom-icon-home-icon"></i>
                <?php echo esc_html( $owmerAddress ); ?>
            </li>
        <?php } if ( $managerEmail && Functions::check_visibility( $listing->get_author_id(), 'email' ) ){ ?>
            <li>
                <a class="rtcl-phone-link" href="mailto:<?php echo esc_attr( $managerEmail ); ?>" target="_blank">
                    <i class="demo-icon rt-custom-icon-email-icon"></i>
                    <?php echo esc_html( $managerEmail ); ?>
                </a>
            </li>
        <?php } if ( $namagerPhone && Functions::check_visibility( $listing->get_author_id(), 'phone' ) ){ ?>
            <li>
                <a class="rtcl-phone-link" href="tel:<?php echo esc_attr( $namagerPhone ); ?>" target="_blank">
                    <i class="demo-icon rt-custom-icon-phone"></i>
                    <?php echo esc_html( $namagerPhone ); ?>
                </a>
            </li>
        <?php } if ( $managerWhatsapp && Functions::check_visibility( $listing->get_author_id(), 'whatsapp' ) ){ ?>
            <li>
                <a class="rtcl-whatsapp-link"
                    href="https://api.whatsapp.com/send?phone=<?php echo esc_attr( $managerWhatsapp ); ?>" target="_blank">
                    <i class="fab fa-whatsapp"></i>
                    <?php echo esc_html( $managerWhatsapp ); ?>
                </a>
            </li>
        <?php } if ( $website ){ ?>
            <li>
                <a class="rtcl-website-link" href="<?php echo esc_url( $website ); ?>" target="_blank"
                    <?php echo Listing_Functions::is_external( $website ) ? ' rel="nofollow"' : ''; ?>>
                    <i class="demo-icon rt-custom-icon-glob"></i>
	                <?php echo esc_html( $managerWebsite ); ?>
                </a>
            </li>
        <?php } ?>
    </ul>
    <?php 
        $social_list = Functions::get_user_social_profile( $manager_id );
        if ( ! empty( $social_list ) ) {
    ?>
        <div class="rtcl-user-social">
            <?php
            foreach ( $social_list as $key => $value ) {
                ?>
                <a href="<?php echo esc_url( $value ) ?>" class="<?php echo esc_attr( $key ) ?>" target="_blank">
	                <?php if ( 'twitter' == $key ) { ?>
                        <i class="rtcl-icon fa-brands fa-x-twitter"></i>
	                <?php } else { ?>
                        <i class="rtcl-icon rtcl-icon-<?php echo esc_attr( $key ) ?>"></i>
	                <?php } ?>
                </a>
                <?php
            }
            ?>
        </div>
    <?php } ?>
</div>
    