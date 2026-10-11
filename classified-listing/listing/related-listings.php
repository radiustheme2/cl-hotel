<?php
/**
 * @author        RadiusTheme
 * @package       cl-hotel/templates
 * @version       1.0.0
 *
 * @var WP_Query $rtcl_related_query
 * @var array    $slider_options
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


use RadiusTheme\CLHotel\Helper;
use RadiusTheme\CLHotel\Options;

if (!$rtcl_related_query->have_posts()) {
    return;
}
global $listing;

?>
<div class="container">
    <div class="row">
        <div class="col-12 related-listing-main-wrap">  
            <div class="related-listing-header">
                <div class="rtcl-related-title">
                    <span class="subheading"><?php echo esc_html( Options::$options['related_post_subheading'] ); ?></span>
                    <h2><?php echo esc_html( Options::$options['related_post_heading'] ); ?></h2>
                    <p><?php echo esc_html( Options::$options['related_post_desc'] ); ?></p>
                </div>
            </div>
            <div class="rtcl rtcl-related-listing rtcl-listings">
                <div class="rtcl-related-listings">
                    <div class="rtcl-related-slider-wrap">
                        <div class="rtcl-related-slider rtcl-carousel-slider rtcl-grid-view" id="rtcl-related-slider" data-options="<?php echo esc_attr( wp_json_encode( $slider_options ) ); ?>">
                            <div class="swiper-wrapper">
                                <?php
                                global $post;
                                while ($rtcl_related_query->have_posts()):
                                    $rtcl_related_query->the_post();
                                    $listing = rtcl()->factory->get_listing(get_the_ID());
                                    ?>
                                    <div class="swiper-slide rtcl-related-slider-item listing-item rtcl-listing-item">
                                        <div class="related-item-inner grid-item">
                                            <?php Helper::get_custom_listing_template( 'archive/grid/grid-1'); ?>
                                        </div>
                                    </div>
                                <?php endwhile;
                                wp_reset_postdata();
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>