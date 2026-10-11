<?php
/**
 * Agent Archive Content
 *
 * @author     RadiusTheme
 * @package    rtcl-agent/templates
 * @version    1.0.0
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Rtcl\Helpers\Functions;
use RtclStore\Models\Store;

$user_id = get_post_meta( get_the_ID(), '_rtcl_user_id', true );
if (!$user = get_user_by('id', $user_id)) {
    return;
}
$store_id  = get_user_meta( $user_id, '_rtcl_store_id', true );
$name = trim(implode(' ', [$user->first_name, $user->last_name]));
$name = $name ? $name : $user->display_name;
$phone = get_user_meta( $user_id, '_rtcl_phone', true );
$pp_id     = absint( get_user_meta( $user_id, '_rtcl_pp_id', true ) );
$store = new Store($store_id);

?>
<div class="agent-holder">
    <div class="item-img">
        <?php 
            if ($pp_id) {
                echo  wp_get_attachment_image( $pp_id, 'full' );
            } else {
                echo get_avatar( $user_id );
            }
        ?>
    </div>
    <div class="item-title">
        <h2 class="agent-name"><a href="<?php echo esc_url( get_the_permalink() ); ?>"><?php echo esc_html($name); ?></a></h2>
        <h3 class="agency-name"><a href="<?php echo esc_url( get_the_permalink( $store_id ) ); ?>"><?php echo esc_html( get_the_title( $store_id ) ); ?></a></h3>
    </div>
    <div class="listing-count">
        <i class="demo-icon rt-custom-icon-list"></i>
        <?php /* translators: %s: Number of listings. */ ?>
        <?php echo esc_html( sprintf( _n( '%s Listing', '%s Listings', count( $store->get_manager_listing_ids( $user_id ) ), 'cl-hotel' ), count( $store->get_manager_listing_ids( $user_id ) ) ) ); ?>
    </div>
    <?php
        $social_list = Functions::get_user_social_profile($user_id);
            if (!empty($social_list)) { 
        ?>
        <div class="item-socials">
            <span><i class="demo-icon rt-custom-icon-share-icon"></i></span>
            <?php
                echo '<ul>';
                    foreach ($social_list as $item => $value) {
                        ?>
                        <li>
                            <a href="<?php echo esc_url( $value ) ?>" class="<?php echo esc_attr( $item ) ?>" target="_blank">
		                        <?php if ( 'twitter' == $item ) { ?>
                                    <i class="rtcl-icon fa-brands fa-x-twitter"></i>
		                        <?php } else { ?>
                                    <i class="rtcl-icon rtcl-icon-<?php echo esc_attr( $item ) ?>"></i>
		                        <?php } ?>
                            </a>
                        </li>
                        <?php
                    }
                echo '</ul>';
            ?>
        </div>
    <?php } ?>
    <span class="shape1"></span>
    <span class="shape2"></span>
</div>