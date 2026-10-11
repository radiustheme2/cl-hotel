<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use RtclPro\Helpers\Fns;
use Rtcl\Helpers\Functions;
use RadiusTheme\CLHotel\Listing_Functions;

global $listing;

?>
<div class="image-meta-wrap">
    <div class="item-img">
        <div class="rt-categories">
	        <?php if ( Listing_Functions::can_show_ad_type() ): ?>
		        <?php
		        $type = Listing_Functions::get_listing_type( $listing );
		        if ( isset( $type['label'] ) ) {
			        ?>
                    <span class="rtin-type"><?php echo esc_html( $type['label'] ); ?></span>
		        <?php } ?>
	        <?php endif; ?>
            <?php Listing_Functions::cl_hotel_listing_categories(); ?>
            <?php $listing->the_badges(); ?>
        </div>
        <?php
            $images = $listing->get_images();
            $total_gallery_image = count($images);
            $total_gallery_item = $total_gallery_image;
            if ($total_gallery_image) {
            ?>
            <div class="archive-gallery-pswp meta-gallery">
                <a href="#" class="rtcl-archive-gallery-trigger"><i class="demo-icon rt-custom-icon-gallery"></i> <?php esc_html_e( 'Gallery', 'cl-hotel' ); ?></a>
                <?php 
                    foreach ($images as $index => $image) :
                    $img_url = wp_get_attachment_image_url( $image->ID, $size = 'full' );
                ?>
                <div class="rtcl-pswp-item">
                    <a href="<?php echo esc_url($img_url); ?>">
                        <?php echo wp_get_attachment_image($image->ID, 'rtcl-gallery'); ?>
                    </a>    
                </div>
                <?php endforeach; ?>
            </div>
        <?php } ?>
        <div class="listing-thumb">
            <a href="<?php the_permalink(); ?>" class="rtcl-media grid-view-img">
                <?php echo wp_kses_post( $listing->get_the_thumbnail( 'cl-hotel-size1' ) ); ?>
            </a>
            <a href="<?php the_permalink(); ?>" class="rtcl-media list-view-img">
                <?php echo wp_kses_post( $listing->get_the_thumbnail( 'cl-hotel-size2' ) ); ?>
            </a>
        </div>
    </div>

    <div class="meta-wrap">
        <?php 
            if ( $listing->can_show_price() ){ 
        ?>
        <div class="meta-price">
            <?php echo wp_kses_post( $listing->get_price_html() ); ?>
        </div>
        <?php } ?>
        <ul class="meta-tags ul-ol">
            <?php if ( Functions::is_enable_favourite() ) { ?>
                <?php if ( is_user_logged_in() ) { ?>
                <li class="tooltip-item meta-favourite">
                    <?php echo wp_kses_post( Listing_Functions::get_favourites_link( $listing->get_id() ) ); ?>
                </li>
                <?php } else { ?>
                    <li class="tooltip-item meta-favourite" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" title="<?php esc_attr_e( 'Favourite', 'cl-hotel' ); ?>">
                        <?php echo wp_kses_post( Listing_Functions::get_favourites_link( $listing->get_id() ) ); ?>
                    </li>
                <?php } ?>
            <?php } ?>

            <?php if ( class_exists('RtclPro') && Fns::is_enable_quick_view() ) { ?>
                <li class="meta-quick-view">
                    <div class="rtcl-quick-view" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" title="<?php esc_attr_e( 'Quick View', 'cl-hotel' ); ?>" data-listing_id="<?php echo absint($listing->get_id()) ?>"><i class="rtcl-icon rt-custom-icon-d-eye"></i></div>
                </li>
            <?php } ?>

            <?php if ( class_exists('RtclPro') && Fns::is_enable_compare() ) { ?>
                <li class="meta-compare">
                    <?php
                    $compare_ids    = ! empty( $_SESSION['rtcl_compare_ids'] ) ? array_map( 'absint', (array) $_SESSION['rtcl_compare_ids'] ) : [];
                    $selected_class = '';
                    if ( is_array( $compare_ids ) && in_array( $listing->get_id(), $compare_ids ) ) {
                        $selected_class = ' selected';
                    }
                    ?>
                    <a class="rtcl-compare <?php echo esc_attr( $selected_class ); ?>" href="#" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" title="<?php esc_attr_e( 'Compare', 'cl-hotel' ); ?>" data-listing_id="<?php echo absint( $listing->get_id() ) ?>">
                        <i class="demo-icon rt-custom-icon-compare"></i>
                    </a>
                </li>
            <?php } ?>

        </ul>
    </div>
</div>