<?php
/**
 * Listing meta
 *
 * @author     RadiusTheme
 * @package    cl-hotel/templates
 * @version    1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use RtclPro\Helpers\Fns;
use Rtcl\Helpers\Functions;
use RadiusTheme\CLHotel\Listing_Functions;
global $listing;

if (!class_exists('RtclPro')) return;

$archive_settings = Functions::get_option( 'rtcl_archive_listing_settings' );
$rating = ! empty( $archive_settings['display_options'] ) && in_array( 'rating', $archive_settings['display_options'] );
$phone   = ! empty( $archive_settings['display_options'] ) && in_array( 'phone', $archive_settings['display_options'] );

$address = get_post_meta( $listing->get_id(), 'address', true );
$phoneNum = get_post_meta( $listing->get_id(), 'phone', true );
$phone_url = str_replace(' ', '', $phoneNum);

?>

<?php
    if ( !empty( $rating )){ 
        Listing_Functions::get_listing_reviews( $listing ); 
    }
?>

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
                <div class="rtcl-quick-view rtcl-btn" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" title="<?php esc_attr_e( 'Quick View', 'cl-hotel' ); ?>" data-listing_id="<?php echo absint($listing->get_id()) ?>"><i class="rtcl-icon rt-custom-icon-d-eye"></i></div>
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

<ul class="meta-list ul-ol">
    <?php if( $listing->can_show_user() ) { ?>
        <li class="meta-author">
            <i class="rt-custom-icon-rt18-user2"></i>
            <?php if ( $listing->can_add_user_link() && ! is_author() ) : ?>
                <a class="author-link" href="<?php echo esc_url( get_author_posts_url($listing->get_author_id()) ); ?>">
                    <?php the_author() ?>
                </a>
            <?php else: ?>
                <?php the_author(); ?>
            <?php endif; ?>
            <?php do_action('rtcl_after_author_meta', $listing->get_owner_id() ); ?>
        </li>
    <?php } ?>

    <?php if ( $listing->has_location() && $listing->can_show_location() ){ ?>
        <li class="meta-address">
            <i class="rt-custom-icon-rt18-marker"></i>
            <?php $listing->the_locations(true, true); ?>
        </li>
	<?php } ?>

    <?php if ( !empty( $phoneNum && $phone )){
        $phone = sprintf(
            '<li class="meta-phone"><i class="rt-custom-icon-phone"></i><a href="tel:%s"> %s </a></li>',
            $phone_url,
            $phoneNum
        );
        echo wp_kses_post( $phone );
    }
    ?>

    <?php if ( $listing->can_show_date() ) { ?>
        <li class="meta-time">
            <i class="rt-custom-icon-calendar"></i> 
            <?php $listing->the_time(); ?>
        </li>
    <?php } ?> 
    
    <?php if ( $listing->can_show_views() ) { ?>
    <li class="meta-view">
        <i class="rt-custom-icon-d-eye"></i>
        <?php /* translators: %s: Number of views. */ ?>
        <?php echo esc_html( sprintf( _n( "View: %s", "Views: %s", $listing->get_view_counts(), 'cl-hotel' ), number_format_i18n( $listing->get_view_counts() ) ) ); ?>
    </li>
    <?php } ?>
</ul>