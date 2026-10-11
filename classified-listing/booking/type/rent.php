<?php
/**
 * Listing pre order Form
 *
 * @author        RadiusTheme
 * @package       cl-hotel/templates
 * @version       1.1.1
 *
 * @var int $listing_id
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Rtcl\Helpers\Functions;
use Rtcl\Helpers\Link;
use RtclBooking\Helpers\Functions as BookingFunctions;

$booking_fee      = BookingFunctions::get_booking_meta( $listing_id, '_rtcl_booking_fee' );
$max_guest        = BookingFunctions::get_booking_meta( $listing_id, '_rtcl_booking_max_guest' );
$unavailable_date = maybe_unserialize( BookingFunctions::get_booking_meta( $listing_id, '_rtcl_booking_rent_unavailable_date' ) );
$booked_date      = BookingFunctions::get_rent_booked_date( $listing_id );
$pending_date     = BookingFunctions::get_rent_booked_date( $listing_id, 'pending' );
// merge unavailable date with already booked date
$unavailable_date = array_merge( (array) $unavailable_date, (array) $booked_date );

$date_options = [
	'minDate'          => gmdate( 'Y/m/d H:i:s' ),
	'timePicker'       => false,
	'timePicker24Hour' => false,
	'locale'           => [
		'format' => 'YYYY-MM-DD'
	],
	'invalidDateList'  => $unavailable_date,
	'bookedDateList'   => $booked_date,
	'pendingDateList'  => $pending_date
];

?>

<div class="form-group booking-date">
    <div class="title-box">
        <label for="booking_rent_date">
            <i class="demo-icon rt-custom-icon-calendar"></i>
            <?php esc_html_e( 'Check Available Day', 'cl-hotel' ); ?>
        </label>
    </div>
    <div class="bottom-box">
        <input type="text" id="booking_rent_date" class="rtcl-date form-control"
            data-options="<?php echo esc_attr( wp_json_encode( $date_options ) ); ?>"/>
    </div>
</div>
<div class="form-group count-number">
    <div class="title-box">
        <label for="guest_number">
            <i class="demo-icon rt-custom-icon-add-user"></i>
            <?php esc_html_e( 'Number Of Guest', 'cl-hotel' ); ?>
        </label>
    </div>
    <div class="bottom-box">
        <div class="rent-guest-quantity">
            <span class="minus-sign">−</span>
            <input type="text" id="guest_number" data-max="<?php echo intval( $max_guest ); ?>" value="1" readonly/>
            <span class="plus-sign">+</span>
        </div>
    </div>
</div>

<div class="rtcl-booking-info">
	<?php if ( $booking_fee ): ?>
        <div class="rtcl-booking-cost">
            <strong><?php echo esc_html( apply_filters( 'rtcl_booking_fee_label', BookingFunctions::get_booking_fee_label() ) ); ?></strong>
            <span><?php echo esc_html( Functions::get_currency_symbol() ); ?><span><?php echo esc_html( $booking_fee ); ?></span></span>
        </div>
	<?php endif; ?>
</div>

<input type="hidden" id="post_id" name="post_id"
       value="<?php echo esc_attr( $listing_id ); ?>"/>

<?php if ( is_user_logged_in() ): ?>
    <button type="submit" id="rtcl-booking-submit-btn" class="btn btn-primary">
		<?php echo esc_html( apply_filters( 'rtcl_booking_order_buton_text', BookingFunctions::get_booking_button_text() ) ); ?>
        <i class="demo-icon rt-custom-icon-long-arrow-right"></i>
    </button>
<?php else: ?>
    <a href="<?php echo esc_url( Link::get_my_account_page_link() ); ?>"
       class="btn btn-primary"><?php esc_html_e( 'Login to Book', 'cl-hotel' ); ?></a>
<?php endif; ?>