<?php
/**
 * Login Form Information
 *
 * @author        RadiusTheme
 * @package       cl-hotel/templates
 * @version       1.0.0
 *
 * @var Listing $listing
 * @var int     $title_limit
 * @var array   $hidden_fields
 * @var string  $selected_type
 * @var string  $title
 * @var string  $listing_pricing
 * @var string  $price_type
 * @var string  $price
 * @var string  $post_content
 * @var string  $editor
 * @var int     $category_id
 * @var int     $post_id
 * @var int     $description_limit
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Rtcl\Helpers\Functions;
use Rtcl\Resources\Options;
use RadiusTheme\CLHotel\Helper;
use RadiusTheme\CLHotel\Listing_Functions;

?>
<div class="rtcl-post-details rtcl-post-section">
  <div class="rtcl-post-section-title">
    <h3><?php esc_html_e("Listing Title", "cl-hotel"); ?></h3>
  </div>
  <div class="form-group">
    <label for="rtcl-title"><?php esc_html_e('Title', 'cl-hotel'); ?><span class="require-star">*</span></label>
    <input type="text" <?php echo esc_attr( $title_limit ? 'data-max-length="3" maxlength="' . $title_limit . '"' : '' ); ?> class="form-control" value="<?php echo esc_attr($title); ?>" id="rtcl-title" name="title" required/>
    <?php
      if ($title_limit) {
        echo wp_kses_post( sprintf( '<div class="rtcl-hints">%s</div>',
            apply_filters( 'rtcl_listing_title_character_limit_hints', /* translators: %s: Character limit number. */ sprintf( __( "Character limit <span class='target-limit'>%s</span>", 'cl-hotel' ), absint( $title_limit ) )
            ) ) );
      }
    ?>
  </div>

  <?php if (!in_array('price', $hidden_fields)):
    $listingPricingTypes = Options::get_listing_pricing_types(); ?>
    <div id="rtcl-pricing-wrap">
      <?php if (!Functions::is_pricing_disabled()) { ?>
        <div class="rtcl-post-section-title">
          <h3><?php esc_html_e("Listing Information:", "cl-hotel"); ?></h3>
        </div>
        <div class="rtcl-from-group rtcl-checkbox-list rtcl-checkbox-inline rtcl-listing-pricing-types">
          <?php
          foreach ($listingPricingTypes as $type_id => $type) { ?>
            <div class="rtcl-checkbox rtcl-listing-pricing-type">
              <input type="radio" name="_rtcl_listing_pricing" id="_rtcl_listing_pricing_<?php echo esc_attr($type_id) ?>"
              <?php echo esc_attr( $listing_pricing === $type_id ? 'checked' : '' ); ?> value="<?php echo esc_attr($type_id) ?>">
              <label for="_rtcl_listing_pricing_<?php echo esc_attr($type_id) ?>">
                <?php echo esc_html($type); ?>
              </label>
            </div>
          <?php } ?>
        </div>
      <?php } ?>
      <?php do_action( 'rtcl_listing_form_price_items', $listing ); ?>
      <div id="rtcl-pricing-items" class="rtcl-pricing-price">
          <?php if (!Functions::is_price_type_disabled()): ?>
              <div id="rtcl-form-price-wrap" class="form-group rtcl-pricing-item rtcl-from-group">
                  <label for="rtcl-price-type">
                      <?php esc_html_e('Price Type', 'cl-hotel'); ?>
                      <span class="require-star">*</span>
                  </label>
                  <select class="form-control" id="rtcl-price-type" name="price_type">
                      <?php
                      $price_types = Options::get_price_types();
                      foreach ($price_types as $key => $type) {
                          $slt = $price_type == $key ? " selected" : null;
                          echo '<option value="' . esc_attr( $key ) . '"' . ( $slt ? ' selected' : '' ) . '>' . esc_html( $type ) . '</option>';
                      }
                      ?>
                  </select>
              </div>
          <?php endif; ?>
          <div id="rtcl-price-items" class="rtcl-pricing-item<?php echo ! Functions::is_price_type_disabled() ? ( ' rtcl-price-type-' . esc_attr( $price_type ) ) : '' ?>">
            <div class="form-group rtcl-price-item" id="rtcl-price-wrap">
                  <div class="price-wrap">
                      <label for="rtcl-price"><?php echo wp_kses_post( sprintf( '<span class="price-label">%s [%s]</span>',
                              esc_html__( "Price", 'cl-hotel' ), esc_html( Functions::get_currency_symbol() ) ) ); ?><span
                                  class="require-star">*</span></label>
                      <input type="text"
                            class="form-control rtcl-price"
                            value="<?php echo esc_attr( $listing ? $listing->get_price() : '' ); ?>"
                            name="price"
                            id="rtcl-price"<?php echo esc_attr(!$price_type || $price_type == 'fixed' ? " required" : ''); ?>>
                  </div>
                  <div class="price-wrap rtcl-max-price rtcl-hide">
                      <label for="rtcl-max-price"><?php echo wp_kses_post( sprintf( '<span class="price-label">%s [%s]</span>',
                              esc_html__( "Max Price", 'cl-hotel' ),
                              esc_html( Functions::get_currency_symbol() )
                          ) ); ?><span
                                  class="require-star">*</span></label>
                      <input type="text"
                            class="form-control rtcl-price"
                            value="<?php echo esc_attr( $listing ? $listing->get_max_price() : '' ); ?>"
                            name="_rtcl_max_price"
                            id="rtcl-max-price"<?php echo esc_attr(!$price_type || $price_type == 'fixed' ? " required" : ''); ?>>
                  </div>
              </div>
            <?php do_action( 'rtcl_listing_form_price_unit', $listing, $category_id ); ?>
          </div>
      </div>
    </div>
  <?php endif; ?>

    <div id="rtcl-custom-fields-list" data-post_id="<?php echo esc_attr($post_id); ?>">
      <?php do_action('wp_ajax_rtcl_custom_fields_listings', $post_id, $category_id); ?>
    </div>

    <?php if (!in_array('description', $hidden_fields)): ?>
    <div class="form-group">
      <label for="description"><?php esc_html_e('Description', 'cl-hotel'); ?></label>
      <?php
        if ('textarea' == $editor) { ?>
          <textarea id="description" name="description" class="form-control" <?php echo esc_attr( $description_limit ? 'maxlength="' . $description_limit . '"' : '' ); ?> rows="8"><?php Functions::print_html($post_content); ?></textarea>
        <?php } else {
          wp_editor(
            $post_content,
            'description',
            array(
              'media_buttons' => false,
              'editor_height' => 200
            )
          );
        }
        if ($description_limit) {
          echo wp_kses_post( sprintf( '<div class="rtcl-hints">%s</div>',
            apply_filters( 'rtcl_listing_description_character_limit_hints',
            /* translators: %s: Character limit number. */ sprintf( __( "Character limit <span class='target-limit'>%s</span>", 'cl-hotel' ), absint( $description_limit ) )
          ) ) );
        }
      ?>
    </div>
    <?php endif; ?>

    <!-- Feature List -->
    <?php
        if (Listing_Functions::is_enable_form_builder($listing)) {
            $arg = [
                'listing_id' => $post_id
            ];
            Helper::get_custom_listing_template( 'faq-list-form', true, $arg );
        }
    ?>
</div>