<?php 

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use RtclPro\Helpers\Fns;
use Rtcl\Helpers\Functions;
use Rtrs\Modules\Review\Helpers\ReviewFns;
use RadiusTheme\CLHotel\Listing_Functions;
use Rtcl\Controllers\BusinessHoursController;
use RtclClaimListing\Helpers\Functions as ClaimFunctions;
use RadiusTheme\CLHotel\Options;

global $listing;
global $wp_locale;

$images = $listing->get_images();

$banner = Listing_Functions::listing_single_banner_option();

if ( Listing_Functions::business_open_close_status( $listing ) ) {
	$onoff = '<span class="onoff-status open"><i class="fas fa-check-circle"></i>' . esc_html__( 'Open Now', 'cl-hotel' ) . '</span>';
} else {
	$onoff = '<span class="onoff-status close"><i class="fas fa-times-circle"></i>' . esc_html__( 'Closed Now', 'cl-hotel' ) . '</span>';
}

$detailOption = Functions::get_option_item( 'rtcl_single_listing_settings', 'display_options_detail', [] );

$misc_settings = Functions::get_option('rtcl_general_social_share_settings');

if( class_exists( ReviewFns::class ) ){
    $rating_count   = ReviewFns::getTotalRatings( get_the_ID() );
} else {
    $rating_count   = $listing->get_rating_count();
}

$show_phone = ! empty( $mod_settings['display_options'] ) && in_array( 'phone', $mod_settings['display_options'] );

$address = get_post_meta( $listing->get_id(), 'address', true );
$phone = get_post_meta( $listing->get_id(), 'phone', true );
$phone_url = str_replace( ' ', '', $phone );

$abuse = Functions::get_option_item( 'rtcl_single_listing_settings', 'has_report_abuse', '', 'checkbox' ) ? true : false;
?>
<div class="listingDetails-header header-v1">
    <div class="row align-items-center">
        <div class="col-lg-9">
            <div class="listingDetails-header">
                <div class="listingDetails-header__fetures">
                    <ul class="ul-ol">
	                    <?php if ( Listing_Functions::can_show_ad_type() ): ?>
		                    <?php
		                    $type = Listing_Functions::get_listing_type( $listing );
		                    if ( isset( $type['label'] ) ) {
			                    ?>
                                <li class="rtin-type"><?php echo esc_html( $type['label'] ); ?></li>
		                    <?php } ?>
	                    <?php endif; ?>

                        <?php if ( $listing->has_category() && $listing->can_show_category() ){ ?>
                            <li class="product-category">
                                <?php Listing_Functions::cl_hotel_listing_categories(); ?>
                            </li> 
                        <?php }
                        if ( class_exists('RtclPro') && $listing && Fns::is_enable_mark_as_sold() && Fns::is_mark_as_sold( $listing->get_id() ) ) {
                            echo '<li class="rtcl-sold-out">' . esc_html( apply_filters( 'rtcl_sold_out_header_text', esc_html__( "Sold Out", 'cl-hotel' ) ) ) . '</li>';
                        }
                        ?>
                        <?php if ( $listing->can_show_price() ): ?>
                            <li class="product-price"><?php echo wp_kses_post( $listing->get_price_html() ); ?></li>
                        <?php endif; ?>
                        <li class="product-badges"><?php $listing->the_badges(); ?></li>
                    </ul>
                </div>
                <?php if ( !(Options::$options['show_heading_on_banner']) ) { ?>
                    <h2 class="listingDetails-header__heading">
                        <?php the_title(); ?>
                    </h2>
                <?php } ?>
                <div class="listingDetails-header__meta">
                    <ul class="info-list">
                        <?php if ( ! empty( $rating_count ) && in_array( 'rating', $detailOption ) ){ ?>
                            <li class="meta-rating">
                                <?php Listing_Functions::get_listing_reviews( $listing ); ?>
                            </li>
                        <?php } if ( $listing->has_location() && $listing->can_show_location() ){ ?>
                            <li class="meta-address">
                                <i class="demo-icon rt-custom-icon-rt18-marker"></i>
                                <?php $listing->the_locations(true, true); ?>
                            </li>
                        <?php } if ( $listing->can_show_date() ) { ?>
                            <li class="meta-date"><i class="rt-custom-icon-calendar1-1"></i> <?php $listing->the_time(); ?></li>
                        <?php } if ( $listing->can_show_views() ){ ?>
                            <li class="meta-view">
                                <span>
                                    <i class="demo-icon rt-custom-icon-d-eye"></i>
                                    <?php /* translators: %s: Number of visitors. */ ?>
                                    <?php echo esc_html( sprintf( _n( "Visitor: %s", "Visitors: %s", $listing->get_view_counts(), 'cl-hotel' ),
                                        number_format_i18n( $listing->get_view_counts() ) ) ); ?>
                                </span>
                            </li>
                        <?php } if ( Functions::is_enable_business_hours() && ! empty( BusinessHoursController::get_business_hours( $listing->get_id() ) ) ){ ?>
                            <li class="meta-status">
                                <?php echo wp_kses_post( $onoff ); ?>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-3 text-lg-end">
            <div class="listing-actions">
                <ul>
                    <?php if ( class_exists('RtclPro') && Fns::is_enable_compare() ) { ?>
                        <li class="meta-compare">
                        <?php
                            $compare_ids = ! empty( $_SESSION['rtcl_compare_ids'] ) ? array_map( 'absint', (array) $_SESSION['rtcl_compare_ids'] ) : [];
                            $selected_class = '';
                            if ( is_array( $compare_ids ) && in_array( $listing->get_id(), $compare_ids ) ) {
                                $selected_class = ' selected';
                            }
                        ?>
                        <a class="rtcl-compare <?php echo esc_attr( $selected_class ); ?>" href="#" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" title="<?php esc_attr_e( "Compare", "cl-hotel" ) ?>" data-listing_id="<?php echo absint( $listing->get_id() ) ?>">
                            <i class="rt-custom-icon-compare"></i>
                        </a>
                        </li>
                    <?php } if (Functions::is_enable_favourite()){ ?>
                    <li class="meta-favourite" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" title="<?php esc_attr_e( "Favourite", "cl-hotel" ) ?>">
                        <?php echo wp_kses_post( Listing_Functions::get_favourites_link( $listing->get_id() ) ); ?>
                    </li>
                    <?php } if ( in_array('social_share', $detailOption)){
                        if ( ! empty( $misc_settings['social_services'] ) ) {
                    ?>
                    <li class="social-share-li" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" title="<?php esc_attr_e( "Share", "cl-hotel" ) ?>"> 
                        <button class="listing-social-action" data-bs-toggle="modal" data-bs-target="#exampleModalCenter">
                            <i class="rt-custom-icon-share-icon"></i>
                        </button>   
                    </li>
                    <?php }
                    } if ( $abuse ){ ?>
                        <li class="report-abuse-li" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" title="<?php esc_attr_e( "Report", "cl-hotel" ) ?>">
                            <?php if ( is_user_logged_in() ): ?>
                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#rtcl-report-abuse-modal">
                                <i class="fa-solid fa-triangle-exclamation"></i>
                            </a>
                            <?php else: ?>
                            <a href="javascript:void(0)" class="rtcl-require-login">
                                <i class="fa-solid fa-triangle-exclamation"></i>
                            </a>
                            <?php endif; ?>
                        </li>
                    <?php } ?>
                    <li><a href="#" onclick="window.print();"  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" title="<?php esc_attr_e( "Print", "cl-hotel" ) ?>"><i class="fa-solid fa-print"></i></a></li>
                    <?php if ( function_exists( 'rtclClaimListing' ) && ClaimFunctions::claim_listing_enable() ){ ?>
                    <li class='report-abuse-li' data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" title="<?php esc_attr_e( "Claim", "cl-hotel" ) ?>">
		                <?php if ( is_user_logged_in() ): ?>
                            <span data-bs-toggle="tooltip" data-original-title="<?php echo esc_html( ClaimFunctions::get_claim_action_title() ); ?>">
                                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#rtcl-claim-listing-modal">
                                    <i class="fas fa-exclamation-circle"></i>
                                </a>
                            </span>
		                <?php else: ?>
                            <a href="javascript:void(0)" data-bs-toggle="tooltip" class="rtcl-require-login" data-original-title="<?php echo esc_html( ClaimFunctions::get_claim_action_title() ); ?>">
                                <i class="fas fa-exclamation-circle"></i>
                            </a>
		                <?php endif; ?>
                    </li>
	                <?php } ?>
                </ul>
            </div>
        </div>
    </div>

    <?php 
        $feature_img = '';
        $images = $listing->get_images();
        if (empty($images)) {
            $feature_img = 'feature-img-not-set';
        }
        if (!empty($images)) {
    ?>
        <div class="page-header">
            <?php 
                if ( $banner == 'slider' ) {
                    Listing_Functions::listing_details_slider();
                } else {
                    Listing_Functions::listing_details_gallery();
                }
            ?>
        </div>
    <?php } ?>
</div>

<?php 
    if ( in_array('social_share', $detailOption)){
        Listing_Functions::get_share_link(); 
    }
?>

<?php do_action( 'rtcl_single_listing_after_action', $listing->get_id() ); ?>
