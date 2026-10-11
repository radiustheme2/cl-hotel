<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Rtcl\Helpers\Functions;
use RadiusTheme\CLHotel\Helper;
use RadiusTheme\CLHotel\Options;
use RadiusTheme\CLHotel\Listing_Functions;

global $listing;

$sidebar_position = Functions::get_option_item('rtcl_single_listing_settings', 'detail_page_sidebar_position', 'right');
$sidebar_class = array(
    'col-lg-3',
    'order-2'
);
$content_class = array(
    'col-lg-9',
    'order-1',
    'listing-content'
);
if ($sidebar_position == "left") {
    $sidebar_class = array_diff($sidebar_class, array('order-2'));
    $sidebar_class[] = 'order-1';
    $content_class = array_diff($content_class, array('order-1'));
    $content_class[] = 'order-2';
} else if ($sidebar_position == "bottom") {
    $content_class = array_diff($content_class, array('col-lg-9'));
    $sidebar_class = array_diff($sidebar_class, array('col-lg-3'));
    $content_class[] = 'col-sm-12';
    $sidebar_class[] = 'rtcl-listing-bottom-sidebar';
}

$field_ids = '';
$can_report_abuse = Functions::get_option_item( 'rtcl_single_listing_settings', 'has_report_abuse', '', 'checkbox' ) ? true : false;

$detailOption = Functions::get_option_item( 'rtcl_single_listing_settings', 'display_options_detail', [] );

$des_title = Options::$options['listing_desc_title'];
$video_title = Options::$options['listing_video_title'];
$map_title = Options::$options['listing_map_title'];
$rating_title = Options::$options['listing_rating_title'];

$group_id = isset( Options::$options['custom_group_individual'] ) ? Options::$options['custom_group_individual'] : 0;
if ( $group_id ) {
    $field_ids = Functions::get_cf_ids_by_cfg_id( $group_id );
    $group_title = get_the_title( $group_id );
}

$hide_listing_map = get_post_meta( get_the_ID(), 'hide_map', true );

$video_urls = [];
if ( ! Functions::is_video_urls_disabled() ) {
    $video_urls = get_post_meta( $listing->get_id(), '_rtcl_video_urls', true );
    $video_urls = ! empty( $video_urls ) && is_array( $video_urls ) ? $video_urls : [];
}

?>

<div class="listingDetails-content-top mb-30">
    <div class="container">
        <div class="listing-header-info">
            <div class="listingDetails-block__header">
                <?php Helper::get_custom_listing_template( 'single/listing-single-header-1' ); ?>
            </div>
        </div>
    </div>
</div>

<div class="listingDetails-content">
    <div class="container">
        <div class="row g-30">
            <div class="<?php echo esc_attr(implode(' ', $content_class)); ?>">
                <div class="listingDetails-block mb-30">
                    <?php if (!empty( $des_title )) { ?>
                    <h3 class="listingDetails-block__heading mb-30"><?php echo esc_html( $des_title ); ?></h3>
                    <?php } ?>
                    <div class="listingDetails-block__des__text">
                        <?php $listing->the_content(); ?>
                    </div>
                </div>

                <!-- Custom Fields -->
                <?php 
                    if (  Functions::isEnableFb() && Listing_Functions::form_builder_custom_group_field_check()){
                        Helper::get_custom_listing_template( 'form-builder-cfg' );
                        Helper::get_custom_listing_template( 'faq-list' );
                    } else {
                        Helper::get_custom_listing_template( 'cfg-individual' );
                        Helper::get_custom_listing_template( 'cfg-details' );
                        Helper::get_custom_listing_template( 'faq-list' );
                    }
                ?>

                <?php if ( in_array('video_url', $detailOption) && ! empty( $video_urls ) ){ ?>
                    <div class="listingDetails-block mb-30">
                        <h3 class="listingDetails-block__heading mb-30"><?php echo esc_html( $video_title ); ?></h3>
                        <div class="video-info ratio-16x9">
                            <iframe class="rtcl-lightbox-iframe" src="<?php echo esc_url( Functions::get_sanitized_embed_url( $video_urls[0] ) ) ?>"></iframe>
                        </div>
                    </div>
                <?php } if ( method_exists( 'Rtcl\Helpers\Functions', 'has_map' ) && Functions::has_map() && ! $hide_listing_map ){ ?>
                    <div class="listingDetails-block mb-30">
                        <?php if(!empty($map_title)){ ?>
                            <h3 class="listingDetails-block__heading mb-10"><?php echo esc_html( $map_title ); ?></h3>
                        <?php } ?>
                        <figure class="listingDetails-map">
                            <!-- Map -->
                            <div class="product-map" id="map">
                                <?php do_action( 'rtcl_single_listing_content_end', $listing ); ?>
                            </div>
                        </figure>
                    </div>
                <?php } if (Functions::get_option_item('rtcl_single_listing_settings', 'enable_review_rating', false, 'checkbox')) { ?>
                    <?php do_action( 'rtcl_single_listing_review' ); ?>
                <?php } ?>
            </div>
            <?php if ( in_array( $sidebar_position, array( 'left', 'right' ) ) ) : ?>
                <?php do_action('rtcl_single_listing_sidebar'); ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php if ( $can_report_abuse ){ ?>

<div class="modal fade rtcl-bs-modal" id="rtcl-report-abuse-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="rtcl-report-abuse-form" class="form-vertical">
                <div class="modal-header">
                    <h5 class="modal-title" id="rtcl-report-abuse-modal-label"><?php esc_html_e('Report Abuse', 'cl-hotel'); ?></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="rt-custom-icon-rt18-cross"></span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="rtcl-report-abuse-message"><?php esc_html_e('Your Complaint', 'cl-hotel'); ?>
                            <span class="rtcl-star">*</span></label>
                        <textarea class="form-control" name="message" id="rtcl-report-abuse-message" rows="3" placeholder="<?php esc_attr_e('Message... ', 'cl-hotel'); ?>" required></textarea>
                    </div>
                    <div id="rtcl-report-abuse-g-recaptcha"></div>
                    <div id="rtcl-report-abuse-message-display"></div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><?php esc_html_e('Submit', 'cl-hotel'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php } ?>