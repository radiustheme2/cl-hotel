<?php
/**
 * Agent Single Content
 *
 * @author     RadiusTheme
 * @package    rtcl-agent/templates
 * @version    1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Rtcl\Helpers\Functions;
use RtclStore\Models\Store;

$user_id = get_post_meta( get_the_ID(), '_rtcl_user_id', true );
if ( ! $user = get_user_by( 'id', $user_id ) ) {
	return;
}
$store_id = get_user_meta( $user_id, '_rtcl_store_id', true );
$phone    = get_user_meta( $user_id, '_rtcl_phone', true );
$whatsApp = get_user_meta( $user_id, '_rtcl_whatsapp_number', true );
$website  = get_user_meta( $user_id, '_rtcl_website', true );
$pp_id    = absint( get_user_meta( $user_id, '_rtcl_pp_id', true ) );
$store    = new Store( $store_id );

$services    = get_post_meta( get_the_ID(), 'rtcl_agent_services', true );
$specialties = get_post_meta( get_the_ID(), 'rtcl_agent_specialties', true );

?>
<div class="rtcl-agent-single-wrapper rtcl">
    <div class="container">
        <div class="row">
            <div class="col-xl-8 order-xl-2">
                <?php Functions::get_template( 'agent/ad-listing', compact( 'user_id', 'store_id' ), '', rtclAgent()->get_plugin_template_path() ); ?>
            </div>
            <div class="col-xl-4 order-xl-1">
                
                <div class="rtcl-agent-profile">
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
                            <h2 class="agent-name"><a href="<?php echo esc_url( get_the_permalink() ); ?>"><?php echo esc_html(get_the_title()); ?></a></h2>
                            <h3 class="agency-name">
                                <a href="<?php echo esc_url( get_the_permalink( $store_id ) ); ?>"><?php echo esc_html( get_the_title( $store_id ) ); ?></a>
                            </h3>
                        </div>
                        <?php
                            $social_list = Functions::get_user_social_profile($user_id);
                                if (!empty( $social_list )) { 
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
                </div>

                <div class="rtcl-agent-info">
                    <div class="rtcl-listing-side-title">
                        <h3><?php esc_html_e( 'General Information', 'cl-hotel' ); ?></h3>
                    </div>
                    <?php the_content(); ?>
                    <div class="rtcl-agent-meta">
                        <ul class="ul-ol">
                            <?php if ( $services ): ?>
                                <li class="item-services">
                                    <strong><?php esc_html_e( 'Service Areas', 'cl-hotel' ); ?>:</strong>
                                    <?php echo esc_html( $services ); ?>
                                </li>
                            <?php endif; ?>
                            <?php if ( $specialties ): ?>
                                <li class="item-services">
                                    <strong><?php esc_html_e( 'Specialties', 'cl-hotel' ); ?>:</strong>
                                    <?php echo esc_html( $specialties ); ?>
                                </li>
                            <?php endif; ?>
                            <?php if ( $phone ): ?>
                                <li class="item-phone">
                                    <i class="demo-icon rt-custom-icon-phone"></i>
                                    <a href="tel:<?php echo esc_attr( $phone ); ?>"><?php echo esc_html( $phone ); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php if ( $whatsApp ): ?>
                                <li class="item-whatsapp">
                                    <i class="rtcl-icon rtcl-icon-whatsapp"></i>
                                    <a target="_blank"
                                    href="https://wa.me/<?php echo esc_attr( $whatsApp ); ?>"><?php echo esc_html( $whatsApp ); ?></a>
                                </li>
                            <?php endif; ?>
                            <li class="item-contact">
                                <i class="demo-icon rt-custom-icon-email-icon"></i>
                                <a href="mailto:<?php echo esc_attr( $user->user_email ); ?>"><?php echo esc_html( $user->user_email ); ?></a>
                            </li>
                            <?php if ( $website ): ?>
                                <li class="item-whatsapp">
                                    <i class="demo-icon rt-custom-icon-glob"></i>
                                    <a target="_blank"
                                    href="<?php echo esc_url( $website ); ?>"><?php echo esc_url( $website ); ?></a>
                                </li>
                            <?php endif; ?>

                            <li class="listing-count">
                                <i class="demo-icon rt-custom-icon-list"></i>
                                <?php /* translators: %s: Number of listings. */ ?>
                                <?php echo esc_html( sprintf( _n( '%s Listing', '%s Listings', count( $store->get_manager_listing_ids( $user_id ) ), 'cl-hotel' ), count( $store->get_manager_listing_ids( $user_id ) ) ) ); ?>
                            </li>
                        </ul>
                    </div>
                </div>

                <?php do_action( 'rtcl_agent_contact_form' ); ?>
            </div>
        </div>
    </div>	
</div>