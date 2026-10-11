<?php
/**
 * jetpack.
 *
 * @link https://jetpack.com/
 */

namespace RadiusTheme\CLHotel;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Rtcl\Helpers\Functions;

/**
 * ThemeJetpack Class
 */
class Shortcode {

	protected static $instance = null;

	public static $shortcode_list = [
		'header'    => [
			'tag'      => 'clhotel_listing_header',
			'callback' => 'render_listing_header',
		],
		'sidebar'    => [
			'tag'      => 'clhotel_listing_sidebar',
			'callback' => 'render_listing_sidebar',
		],
		'description'    => [
			'tag'      => 'clhotel_listing_description',
			'callback' => 'render_listing_description',
		],
        'custom_fields'    => [
			'tag'      => 'clhotel_listing_custom_fields',
			'callback' => 'render_listing_custom_fields',
		],
		'video'    => [
			'tag'      => 'clhotel_listing_video',
			'callback' => 'render_listing_video',
		],
        'map'    => [
			'tag'      => 'clhotel_listing_map',
			'callback' => 'render_listing_map',
		],
        'review'    => [
			'tag'      => 'clhotel_listing_review',
			'callback' => 'render_listing_review',
		],
	];

	/**
	 * register default hooks and actions for WordPress
	 *
	 * @return
	 */
	public function __construct() {
		add_filter(
			'rtcl/fb/single_layout/fields',
			function ( $fields ) {
				$shortcode_hints = '';
				foreach ( self::$shortcode_list as $label => $shortcode ) {
					$display = isset( $shortcode['hint'] ) ? $shortcode['hint'] : $shortcode['tag'];
				    $shortcode_hints .= '<br><b>' . ucfirst( $label ) . ":</b> [{$display}]";
				}

				$fields['shortcode']['editor']['hints']['value'] = 'Available Shortcodes: ' . $shortcode_hints;

				return $fields;
			}
		);

		foreach ( self::$shortcode_list as $shortcode ) {
			add_shortcode( $shortcode['tag'], [ $this, $shortcode['callback'] ] );
		}
	}

	public static function instance() {
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	/**
	 * @return false|string
	 */
	public function render_listing_header() {
		global $listing;

		if ( ! $listing ) {
			return '';
		}

		if ( is_singular( 'rtcl_listing' ) ) {
			ob_start();
			?>

            <!--Listing Heading-->
            <div class="listingDetails-content-top mb-30">
                <div class="listing-header-info">
                    <div class="listingDetails-block__header">
                        <?php Helper::get_custom_listing_template( 'single/listing-single-header-1' ); ?>
                    </div>
                </div>
            </div>
            <!--End Listing Heading-->

			<?php
			return ob_get_clean();
		}

		return '';
	}

    /**
	 * Listing sidebar
	 *
	 * @return false|string
	 */
	public function render_listing_sidebar() {
		global $listing;

		if ( ! $listing ) {
			return '';
		}

		if ( is_singular( 'rtcl_listing' ) ) {

			ob_start();
			?>

            <div class="listing-sidebar">
				<?php
				if (Options::$options['listing_list_information']) {
					$listing->the_user_info();
				}
				if (Options::$options['listing_list_timing']) {
					do_action('rtcl_single_listing_business_hours');
				}
				?>
				<?php if ( is_active_sidebar( 'rtcl-single-sidebar' ) ): ?>
                    <aside class="sidebar-widget">
						<?php dynamic_sidebar( 'rtcl-single-sidebar' ); ?>
                    </aside>
				<?php endif; ?>

            </div>

            <?php
			return ob_get_clean();
		}

		return '';
	}

	/**
	 * Listing sidebar
	 *
	 * @return false|string
	 */
    public function render_listing_description() {
		global $listing;

		if ( ! $listing ) {
			return '';
		}

		if ( is_singular( 'rtcl_listing' ) ) {

			$des_title = Options::$options['listing_desc_title'];

			ob_start();
			?>

            <div class="listingDetails-content">
                <div class="listingDetails-block">
                    <?php if (!empty( $des_title )) { ?>
                        <h3 class="listingDetails-block__heading mb-30"><?php echo esc_html( $des_title ); ?></h3>
                    <?php } ?>
                    <div class="listingDetails-block__des__text">
                        <?php $listing->the_content(); ?>
                    </div>
                </div>
            </div>

            <?php
			return ob_get_clean();
		}

		return '';
	}

	/**
	 * Listing sidebar
	 *
	 * @return false|string
	 */
	public function render_listing_custom_fields() {
		global $listing;

		if ( ! $listing ) {
			return '';
		}

		if ( is_singular( 'rtcl_listing' ) ) {

			ob_start();
        ?>
        <div class="listingDetails-main">
            <?php
                if ( Functions::isEnableFb() && Listing_Functions::form_builder_custom_group_field_check() ) {
                    Helper::get_custom_listing_template( 'form-builder-cfg' );
                    Helper::get_custom_listing_template( 'faq-list' );
                } else {
                    Helper::get_custom_listing_template( 'cfg-individual' );
                    Helper::get_custom_listing_template( 'cfg-details' );
                    Helper::get_custom_listing_template( 'faq-list' );
                }
            ?>
        </div>
        <?php
			return ob_get_clean();
		}

		return '';
	}

	/**
	 * @return false|string
	 */
	public function render_listing_video() {
		global $listing;

		if ( ! $listing ) {
			return '';
		}

		if ( is_singular( 'rtcl_listing' ) ) {
			ob_start();

			$detailOption = Functions::get_option_item( 'rtcl_single_listing_settings', 'display_options_detail', [] );
			$video_title = Options::$options['listing_video_title'];
			$video_urls = [];
			if ( ! Functions::is_video_urls_disabled() ) {
				$video_urls = get_post_meta( $listing->get_id(), '_rtcl_video_urls', true );
				$video_urls = ! empty( $video_urls ) && is_array( $video_urls ) ? $video_urls : [];
			}
			?>

            <!-- Map -->
			<?php if ( in_array('video_url', $detailOption) && ! empty( $video_urls ) ){ ?>
                <div class="listingDetails-content">
                    <div class="listingDetails-block">
                        <h3 class="listingDetails-block__heading mb-30"><?php echo esc_html( $video_title ); ?></h3>
                        <div class="video-info ratio-16x9">
                            <iframe class="rtcl-lightbox-iframe" src="<?php echo esc_url( Functions::get_sanitized_embed_url( $video_urls[0] ) ) ?>"></iframe>
                        </div>
                    </div>
                </div>
			<?php } ?>

			<?php
			return ob_get_clean();
		}

		return '';
	}

	/**
	 * @return false|string
	 */
	public function render_listing_map() {
		global $listing;

		if ( ! $listing ) {
			return '';
		}

		if ( is_singular( 'rtcl_listing' ) ) {
			ob_start();

			$hide_listing_map   = get_post_meta( get_the_ID(), 'hide_map', true );
			$map_title = Options::$options['listing_map_title'];

			?>

            <!-- Map -->
			<?php if ( method_exists( 'Rtcl\Helpers\Functions', 'has_map' ) && Functions::has_map() && ! $hide_listing_map ){ ?>
                <div class="listingDetails-content">
                    <div class="listingDetails-block">
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
                </div>
			<?php } ?>

			<?php
			return ob_get_clean();
		}

		return '';
	}

	/**
	 * @return false|string
	 */
	public function render_listing_review() {
		global $listing;

		if ( ! $listing ) {
			return '';
		}

		if ( is_singular( 'rtcl_listing' ) ) {
			ob_start();
        ?>
            <div class="listingDetails-content">
                <?php do_action( 'rtcl_single_listing_review' ); ?>
            </div>
        <?php
			return ob_get_clean();
		}

		return '';
	}

}

Shortcode::instance();
