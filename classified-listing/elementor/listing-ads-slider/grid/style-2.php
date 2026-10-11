<?php
/**
 *
 * @author     RadiusTheme
 * @package    cl-hotel/templates
 * @version    1.0.0
 * @var $view string
 * @var $style string
 * @var $instance array
 * @var $the_loops WP_Query
 * @var $default_template_path string
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Rtcl\Models\Listing;
use Rtcl\Helpers\Functions;
use RadiusTheme\CLHotel\Helper;
use RtclPro\Controllers\Hooks\TemplateHooks;
use Rtcl\Controllers\BusinessHoursController;
use Rtcl\Controllers\BusinessHoursController as BHS;

$data = [
	'template'              => 'elementor/listing-ads-slider/slider-header',
	'view'                  => $view,
	'style'                 => $style,
	'instance'              => $instance,
	'the_loops'             => $the_loops,
	'default_template_path' => $default_template_path,
];
$data = apply_filters( 'rtcl_el_listing_slider_filter_data', $data );
Functions::get_template( $data['template'], $data, '', $data['default_template_path'] );

while ( $the_loops->have_posts() ) :

	$the_loops->the_post();
	$_id                 = get_the_ID();
	$post_meta           = get_post_meta( $_id );
	$listing             = new Listing( $_id );
	$listing_title       = null;
	$listing_rating      = null;
	$listing_meta        = null;
	$listing_description = null;
	$img                 = null;
	$labels              = null;
	$u_info              = null;
	$time                = null;
	$location            = null;
	$category            = null;
	$price               = null;
	$img_position_class  = '';
	$types               = null;
	$custom_field		 = null;
	
	?>

	<div <?php Functions::listing_class( [ 'rtcl-widget-listing-item', 'listing-item product-box swiper-slide-customize', $img_position_class ] ); ?> style="" >

		<?php
		$button_icon = 0;
		ob_start();
		if ( $instance['rtcl_show_favourites'] ) {
			$button_icon++;
			?>
			<div class="rtcl-fav rtcl-el-button">
				<?php echo wp_kses_post( Functions::get_favourites_link( $_id ) ); ?>
			</div>
		<?php } ?>
		<?php
		$dispaly_favourites = ob_get_clean();
		?>

		<?php
		ob_start();
		if ( rtcl()->has_pro() ) {
			if ( ! empty( $instance['rtcl_show_quick_view'] ) ) :
				?>
				<div class="rtcl-el-button">
					<a class="rtcl-quick-view" href="#" title="<?php esc_attr_e( 'Quick View', 'cl-hotel' ); ?>" data-listing_id="<?php echo absint( $_id ); ?>">
						<i class="demo-icon rt-custom-icon-d-eye"></i> 
					</a>
				</div>
				<?php
				$button_icon++;
			endif;
		}
		$dispaly_quick_view = ob_get_clean();
		?>

		<?php ob_start(); ?>

		<?php
		if ( rtcl()->has_pro() ) {
			if ( ! empty( $instance['rtcl_show_compare'] ) ) :
				?>
				<div class="rtcl-el-button">
					<?php
					$compare_ids    = ! empty( $_SESSION['rtcl_compare_ids'] ) ? array_map( 'absint', (array) $_SESSION['rtcl_compare_ids'] ) : [];
					$selected_class = '';
					if ( is_array( $compare_ids ) && in_array( $_id, $compare_ids ) ) {
						$selected_class = ' selected';
					}
					?>
					<a class="rtcl-compare <?php echo esc_attr( $selected_class ); ?>" href="#" title="<?php esc_attr_e( 'Compare', 'cl-hotel' ); ?>" data-listing_id="<?php echo absint( $_id ); ?>">
						<i class="fa-solid fa-code-compare"></i>
					</a>
				</div>
				<?php
				$button_icon++;
			endif;
		}
		?>
		
		<?php
		$dispaly_compare = ob_get_clean();

		$action_button_layout = $instance['rtcl_action_button_layout'];
		$button               = sprintf( '<div class="rtcl-meta-buttons-wrap %s-layout meta-button-count-%s">%s %s %s</div>', $action_button_layout, $button_icon, $dispaly_favourites, $dispaly_quick_view, $dispaly_compare );

		if ( $instance['rtcl_show_image'] ) {
			ob_start();
			if ( rtcl()->has_pro() ) {
				TemplateHooks::sold_out_banner();
			}
			$mark_as_sold = ob_get_clean();

			$image_size    = $instance['rtcl_thumb_image_size'];
			$the_thumbnail = $listing->get_the_thumbnail( $image_size );

			$discount = get_post_meta( $listing->get_id(), 'listing_discount', true );

			$business_hours = BHS::get_business_hours($listing->get_id());
			if (BHS::openStatus($business_hours)) {
				$onoff = '<div class="item-status status-open active">'. esc_html__( 'Open Now', 'cl-hotel' ).'</div>';
			} else {
				$onoff = '<div class="item-status status-close">'. esc_html__( 'Close Now', 'cl-hotel' ).'</div>';
			}

			if ( $instance['rtcl_show_user'] ) {
				$userShow = 'user-show';
			} else {
				$userShow = 'user-not-show';
			}

			if ( $the_thumbnail ) { ?>
				<div class="item-img <?php echo esc_attr( $userShow ); ?>">
					<?php if ( $instance['rtcl_show_onoff'] ) { ?>
						<div class="open-close-location-status">
							<?php if ( Functions::is_enable_business_hours() && ! empty( BusinessHoursController::get_business_hours( $listing->get_id() ) ) ){
									echo wp_kses_post( $onoff );
								}
							?>
						</div>
					<?php } 
						echo wp_kses_post( $button );
					?>

					<div class='listing-thumb'>
						<a href="<?php the_permalink(); ?>" class="rtcl-media grid-view-img">
							<?php echo wp_kses_post( $listing->get_the_thumbnail( 'cl-hotel-size1' ) ); ?>
						</a>
					</div>

					<?php 
						if ( $instance['rtcl_show_user'] ) {
							ob_start();
							Helper::get_listing_author_image( $listing );
							$author_thumbnail = ob_get_clean();
						}
						if ( $instance['rtcl_show_title'] ) {
							$listing_title = sprintf(
								'<h3 class="listing-title rtcl-listing-title"><a href="%1$s">%2$s</a></h3>',
								get_the_permalink(),
								esc_html( get_the_title() )
							);
						}
						if ( $instance['rtcl_show_review'] ) {
							ob_start();
							Helper::get_listing_rating( $listing ); 
							$listing_rating = ob_get_clean();
						}
						$listing_info = sprintf(
							"<div class='item-info-box'>%s %s %s</div>",
							$author_thumbnail,
							$listing_title,
							$listing_rating
						);
						echo wp_kses_post( $listing_info ); 
					?>
				</div>
			<?php }
		}

		// Meta Information
		if ( $instance['rtcl_show_labels'] ) {
			$labels = $listing->badges();
		}
		if ( $instance['rtcl_show_date'] ) {
			$time = sprintf(
				'<li class="date"><i class="rtcl-icon rtcl-icon-clock" aria-hidden="true"></i>%s</li>',
				$listing->get_the_time()
			);
		}
		if ($instance['rtcl_show_location']) {
			if ( wp_strip_all_tags( $listing->the_locations( false ) ) ) {
				$location = sprintf(
					'<li class="location"><i class="clr-icon-rt18-marker"></i>%s</li>',
					$listing->the_locations(false)
				);
			}
		}

		if ($instance['rtcl_show_phone']) {
			$phone_no = get_post_meta( $listing->get_id(), 'phone', true );
			$phone_url = str_replace(' ', '', $phone_no);
				$phone = sprintf(
					'<li class="meta-phone"><a href="tel:%s"><i class="clr-icon-rt18-phone2"></i>%s</a></li>',
					$phone_url,
					$phone_no
				);
		}
		if ($instance['rtcl_show_website']) {
			$website_url = str_replace(['https://', 'http://'], '', get_post_meta( $listing->get_id(), 'website', true ));

			$website = sprintf(
				'<li class="meta-website"><a href="tel:%s"><i class="clr-icon-vector-22"></i>%s</a></li>',
				$website_url,
				$website_url,
			);
		}

		if ( $instance['rtcl_show_price'] ) {
			$price_html = $listing->get_price_html();
			$price      = sprintf( '<div class="item-price">%s</div>', $price_html );
		}
		$author_html = '';
		if ( $instance['rtcl_show_user'] ) {
			$author_html = sprintf( '<li class="author" ><i class="rtcl-icon rtcl-icon-user" aria-hidden="true"></i>%s</li>', get_the_author() );
		}
		$views_html = '';
		if ( $instance['rtcl_show_views'] ) {
			$views      = absint( get_post_meta( get_the_ID(), '_views', true ) );
			$views_html = sprintf(
				'<li class="view"><i class="rtcl-icon rtcl-icon-eye" aria-hidden="true"></i>%s</li>',
				sprintf(
				/* translators: %s: views count */
					_n( '%s view', '%s views', $views, 'cl-hotel' ),
					number_format_i18n( $views )
				)
			);
		}

		if ( $instance['rtcl_show_types'] && $listing->get_ad_type() ) {
			$listing_types = Functions::get_listing_types();
			$types         = ! empty( $listing_types ) ? $listing_types[ $listing->get_ad_type() ] : '';
			if ( $types ) {
				$types = sprintf(
					'<li class="rtin-type"><i class="rtcl-icon-tags" aria-hidden="true"></i>%s</li>',
					$types
				);
			}
		}
		if ( $types || $time || $location || $phone || $website || $views_html ) {
			$listing_meta = sprintf( '<ul class="rtcl-listing-meta-data">%s %s %s %s %s %s</ul>', $types, $time, $location, $phone, $website, $views_html );
		}

		// CLR_listing_categories
		if ( $instance['rtcl_show_category'] ) {
			$listing_category = Helper::CLR_listing_rgba_categories( $listing->get_id());
		}

		// Content Information
		if ( $instance['rtcl_show_category'] ) {
			$category = sprintf(
				'<div class="category">%s</div>',
				$listing_category
			);
		}

		if ( $instance['rtcl_show_description'] ) {
			$excerpt = get_the_excerpt( $_id );

			$listing_description = sprintf(
				'<div class="rtcl-short-description"> %s </div>',
				wpautop( $excerpt )
			);
		}

		if (!empty($instance['rtcl_show_custom_fields'])) {
			ob_start();
			TemplateHooks::loop_item_listable_fields();
			$custom_field = ob_get_clean();
		}

		$item_content   = sprintf(
			'<div class="item-content">%s %s %s %s %s %s</div>',
			$labels,
			$category,
			$listing_description,
			$custom_field,
			$listing_meta
		);
		$final_contents = sprintf( '%s <div class="rtin-content-area">%s</div>', $img, $item_content );
		echo wp_kses_post( $final_contents );
		?>

	</div>

<?php endwhile; ?>
<?php wp_reset_postdata(); ?>


<?php

$data = [
	'template'              => 'elementor/listing-ads-slider/slider-footer',
	'view'                  => $view,
	'style'                 => $style,
	'instance'              => $instance,
	'the_loops'             => $the_loops,
	'default_template_path' => $default_template_path,
];
$data = apply_filters( 'rtcl_el_listing_slider_filter_data', $data );
Functions::get_template( $data['template'], $data, '', $data['default_template_path'] );
