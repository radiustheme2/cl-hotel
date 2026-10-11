<?php
/**
 *
 * @author     RadiusTheme
 * @package    cl-hotel/templates
 * @version    1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Rtcl\Helpers\Functions;
use Rtcl\Helpers\Pagination;
use Rtcl\Models\Listing;
use RadiusTheme\CLHotel\Listing_Functions;
use RtclPro\Controllers\Hooks\TemplateHooks;
use RtclPro\Helpers\Fns;
?>

<div class="rtcl rtcl-listings-sc-wrapper rtcl-elementor-widget ">
	<div class="rtcl-listings-wrapper">
		<?php
			$class  = '';
			$class .= ! empty( $view ) ? 'rtcl-' . $view . '-view ' : 'rtcl-list-view ';
			$class .= ! empty( $style ) ? 'rtcl-' . $style . '-view ' : 'rtcl-style-1-view ';
		?>
		<div class="rtcl-listings <?php echo esc_attr( $class ); ?> ">
			<?php

			while ( $the_loops->have_posts() ) :
				$the_loops->the_post();
				$_id                    = get_the_ID();
				$post_meta              = get_post_meta( $_id );
				$listing                = new Listing( $_id );
				$listing_gallery        = null;
				$listing_rating        	= null;
				$listing_title          = null;
				$listing_meta           = null;
				$listing_description    = null;
				$img                    = null;
				$labels                 = null;
				$u_info                 = null;
				$time                   = null;
				$location               = null;
				$category               = null;
				$price                  = null;
				$types                  = null;
				$img_position_class     = '';
				$item_details_page_link = null;
				$item_content_right     = null;
				$button                 = null;
				$custom_field			= null ;
				?>

			<div <?php Functions::listing_class( [ 'rtcl-widget-listing-item', 'listing-item', $img_position_class ] ); ?>>
				<div class="product-box">
					<?php
						
					?>

					<?php  ?>
					<?php ?>

					<!-- Thumbnail Image Wrapper -->
					<?php
						if ( $instance['rtcl_show_gallery'] ) {
							ob_start();
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
							<?php }
							$listing_gallery = ob_get_clean();
						}

						if ( $instance['rtcl_show_image'] ) {
							$image_size    = $instance['rtcl_thumb_image_size'];
							$the_thumbnail = $listing->get_the_thumbnail( $image_size );
							if ( $the_thumbnail ) {
								$img = sprintf(
									"<div class='image-meta-wrap'><div class='item-img'>%s<div class='listing-thumb'><div class='listing-thumb-inner'><a href='%s'>%s</a> </div> </div> </div> </div>",
									$listing_gallery,
									get_the_permalink(),
									$the_thumbnail
								);
							}
						}
						?>

						<!-- Content Wrapper -->
						<?php 
							// No 1 Categories
							if ( $instance['rtcl_show_category'] ) {
								$category = sprintf(
									'<div class="rt-categories category">%s</div>',
									$listing->the_categories( false, true )
								);
							}

							// No 2 Badges
							if ( $instance['rtcl_show_labels'] ) {
								$labels = $listing->badges();
							}

							// No 3 Title
							if ( $instance['rtcl_show_title'] ) {
								$listing_title = sprintf(
									'<h3 class="listing-title rtcl-listing-title"><a href="%1$s">%2$s</a> </h3>',
									get_the_permalink(),
									esc_html( get_the_title() )
								);
							}

							// No 4 Rating
							if ( $instance['rtcl_show_review'] ) {
								ob_start();
								Listing_Functions::get_listing_reviews( $listing );
								$listing_rating = ob_get_clean();
							}

							// Meta Tags price, favourite, quick view, compare
							// Price
							if ( $instance['rtcl_show_price'] ) {
								$price_html = $listing->get_price_html();
								$price      = sprintf( '<div class="item-price meta-price">%s</div>', $price_html );
							}

							// Favourite
							$button_icon = 0;
							ob_start();
							if ( $instance['rtcl_show_favourites'] ) {
								$button_icon++;
								?>
								<?php if ( is_user_logged_in() ) { ?>
									<li class="tooltip-item meta-favourite">
										<div class="rtcl-fav rtcl-text-el-button">
											<?php echo wp_kses_post( Listing_Functions::get_favourites_link( $listing->get_id() ) ); ?>
										</div>
									</li>
								<?php } else { ?>
									<li class="tooltip-item meta-favourite" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" title="<?php esc_attr_e( 'Favourite', 'cl-hotel' ); ?>">
										<div class="rtcl-fav rtcl-text-el-button">	
											<?php echo wp_kses_post( Listing_Functions::get_favourites_link( $listing->get_id() ) ); ?>
										</div>
									</li>
								<?php } ?>
							<?php } ?>
							<?php
							$dispaly_favourites = ob_get_clean();

							// Quick View
							ob_start();
							if ( rtcl()->has_pro() ) {
								if ( ! empty( $instance['rtcl_show_quick_view'] ) ) :
									?>
									<li class="meta-quick-view">
										<div class="rtcl-text-el-button">
											<a class="rtcl-quick-view" href="#" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" title="<?php esc_attr_e( 'Quick View', 'cl-hotel' ); ?>" data-listing_id="<?php echo absint( $_id ); ?>">
												<i class="rtcl-icon rt-custom-icon-d-eye"></i>
											</a>
										</div>
									</li>
									<?php
									$button_icon++;
								endif;
							}
							$dispaly_quick_view = ob_get_clean();

							// Compare
							ob_start();
							if ( rtcl()->has_pro() ) {
								if ( ! empty( $instance['rtcl_show_compare'] ) ) :
									?>
									<li class="meta-compare">
										<div class="rtcl-text-el-button">
											<?php
												$compare_ids    = ! empty( $_SESSION['rtcl_compare_ids'] ) ? array_map( 'absint', (array) $_SESSION['rtcl_compare_ids'] ) : [];
												$selected_class = '';
											if ( is_array( $compare_ids ) && in_array( $_id, $compare_ids ) ) {
												$selected_class = ' selected';
											}
											?>
											<a class="rtcl-compare <?php echo esc_attr( $selected_class ); ?>" href="#" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" title="<?php esc_attr_e( 'Compare', 'cl-hotel' ); ?>" data-listing_id="<?php echo absint( $_id ); ?>">
												<i class="demo-icon rt-custom-icon-compare"></i>
											</a>
										</div>
									</li>
									<?php
									$button_icon++;
								endif;
							}
							$dispaly_compare = ob_get_clean();

							// meta-tags ul-ol
							if ( $dispaly_favourites || $dispaly_quick_view || $dispaly_compare ) {
								$action_meta = sprintf( '<ul class="meta-tags ul-ol meta-button-count-%s">%s %s %s</ul>', $button_icon, $dispaly_favourites, $dispaly_quick_view, $dispaly_compare );
							}

							if ( $button_icon ) {
								$price_actionmeta = sprintf( '<div class="meta-wrap">%s %s</div>', 
									$price, 
									$action_meta 
								);
							}


						// Meta list
						// Date
						if ( $instance['rtcl_show_date'] ) {
							$time = sprintf(
								'<li class="date"><i class="rtcl-icon rtcl-icon-clock" aria-hidden="true"></i>%s</li>',
								$listing->get_the_time()
							);
						}
						// Location
						if ( $instance['rtcl_show_location'] ) {
							if ( wp_strip_all_tags( $listing->the_locations( false ) ) ) {
								$location = sprintf(
									'<li class="location"><i class="demo-icon rt-custom-icon-rt18-marker" aria-hidden="true"></i>%s</li>',
									$listing->the_locations(false)
								);
							}
						}
						// User
						$author_html = '';
						if ( $instance['rtcl_show_user'] ) {
							$author_html = sprintf( '<li class="author" ><i class="rtcl-icon rtcl-icon-user" aria-hidden="true"></i>%s</li>', get_the_author() );
						}
						// Views
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
						// Types
						if ( $instance['rtcl_show_types'] && $listing->get_ad_type() ) {
							$listing_types = Functions::get_listing_types();
							$types         = ! empty( $listing_types ) && isset( $listing_types[ $listing->get_ad_type() ] ) ? $listing_types[ $listing->get_ad_type() ] : '';
							if ( $types ) {
								$types = sprintf(
									'<li class="rtin-type"><i class="rtcl-icon-tags" aria-hidden="true"></i>%s</li>',
									$types
								);
							}
						}

						if ( $types || $author_html || $time || $location || $views_html ) {
							$listing_meta = sprintf( '<ul class="rtcl-listing-meta-data ul-ol">%s %s %s %s %s</ul>', $types, $author_html, $time, $location, $views_html );
						}



						if ( $instance['rtcl_show_description'] ) {
							$excerpt = get_the_excerpt( $_id );

							$listing_description = sprintf(
								'<div class="rtcl-short-description"> %s </div>',
								wpautop( $excerpt )
							);
						}
						if ( rtcl()->has_pro() ) {
							if ( !empty( $instance['rtcl_show_custom_fields'] ) ) {
								ob_start();
								TemplateHooks::loop_item_listable_fields();
								$custom_field = ob_get_clean();
							}
						}
						$item_content   = sprintf(
							'<div class="item-content">%s %s %s %s %s %s %s %s </div>',
							$category,
							$labels,
							$listing_title,
							$listing_rating,
							$custom_field,
							$listing_description,
							$price_actionmeta,
							$listing_meta

						);
						$final_contents = sprintf( '%s <div class="rtin-content-area">%s</div>', $img, $item_content );
						echo wp_kses_post( $final_contents );
					?>
				</div>
			</div>

			<?php endwhile; ?>
			<?php wp_reset_postdata(); ?>

		</div>
		<?php if ( ! empty( $instance['rtcl_listing_pagination'] ) ) { ?>
			<?php Pagination::pagination( $the_loops ); ?>
		<?php } ?>
	</div>
</div>
