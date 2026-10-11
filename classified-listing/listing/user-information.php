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

use Rtcl\Helpers\Functions;
use Rtcl\Helpers\Link;
use RtclPro\Helpers\Fns;
use Rtcl\Helpers\Text;
use RadiusTheme\CLHotel\Helper;
use RadiusTheme\CLHotel\Options;
use RtclMarketplace\Hooks\ActionHooks;
use RtclStore\Helpers\Functions as StoreFunctions;

global $listing;

$store = StoreFunctions::get_user_store($listing->get_owner_id());

?>

<?php
	if ( class_exists('RtclMarketplace') ) {
		ActionHooks::add_buy_button();
	}
?>

<?php
	if ( class_exists('RtclPro') && Fns::is_enable_chat() && ((is_user_logged_in() && $listing->get_author_id() !== get_current_user_id()) || !is_user_logged_in())):
		$chat_btn_class = [ 'rtcl-chat-link' ];
		$chat_url = Link::get_my_account_page_link();
		$chat_label = esc_html__( "Quick Chat", 'cl-hotel');
		$chant_enable_class = "rtcl-contact-seller";
		if ( is_user_logged_in() ) {
			$chat_url = '#';
			array_push( $chat_btn_class, 'rtcl-contact-seller' );
		} else {
			array_push( $chat_btn_class, 'rtcl-no-contact-seller' );
			$chat_label = "Login for Chat";
			$chant_enable_class = 'need-to-logedin';
		}
	?>
	<div class="rtcl-listing-user-info chat-form">
		<div class=<?php echo esc_attr( $chant_enable_class ); ?>>
			<a class="<?php echo esc_attr( implode( ' ', $chat_btn_class ) ) ?>" href="<?php echo esc_url( $chat_url ) ?>" data-listing_id="<?php the_ID() ?>">
				<i class="fa-brands fa-rocketchat"></i>
				<?php echo esc_html( $chat_label ); ?>
			</a>
		</div>
	</div>
<?php endif; ?>

<?php if ($has_contact_form && $email) : ?>
	<div class="rtcl-listing-user-info contact-form">
		<div class='rtcl-do-email list-group-item'>
			<div class='media'>
				<span class='rtcl-icon rtcl-icon-mail'></span>
				<div class='media-body'>
					<a class="rtcl-do-email-link" href='#'>
						<?php echo esc_html( Text::get_single_listing_email_button_text() ); ?>
					</a>
				</div>
			</div>
			<?php Functions::print_html($email_to_seller_form, true); ?>
		</div>
	</div>
<?php endif; ?>

<?php do_action( 'rtcl_after_single_listing_sidebar', $listing->get_id() ); ?>

<?php Helper::get_custom_listing_template( 'general-info' ); ?>

<?php if ( $store ) { ?>
    <div class="rtcl-listing-user-info">
        <?php if (class_exists('RtclPro') && Fns::registered_user_only('listing_seller_information') && !is_user_logged_in()) { ?>
            <p class="login-message">
                <?php /* translators: %s: Login page URL. */ echo wp_kses(sprintf(__("Please <a href='%s'>login</a> to view the seller information.", "cl-hotel"), esc_url(Link::get_my_account_page_link())), ['a' => ['href' => []]]); ?>
            </p>
        <?php } else {
            if ( Options::$options['single_listing_stor_info'] == 'listing_manager' ){
                Helper::get_custom_listing_template( 'listing-manager-info');
            } elseif ( Options::$options['single_listing_stor_info'] == 'listing_owner' ){
                Helper::get_custom_listing_template( 'listing-owner-info');
            } else {
                $args = [
                    'listing_id' => $listing_id
                ];
                Helper::get_custom_listing_template( 'listing-store-info', true, $args);
            }
        }
        ?>
    </div>
<?php } ?>


