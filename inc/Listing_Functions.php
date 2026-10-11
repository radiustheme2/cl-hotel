<?php
/**
 * @author  RadiusTheme
 * @since   1.0.0
 * @version 1.0.0
 */

namespace RadiusTheme\CLHotel;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Rtcl\Helpers\Functions;
use Rtcl\Models\RtclCFGField;
use Rtcl\Controllers\Hooks\Filters;
use Rtcl\Services\FormBuilder\FBField;
use Rtcl\Services\FormBuilder\FBHelper;
use Rtcl\Controllers\Hooks\TemplateHooks;
use RadiusTheme\CLHotel\Traits\StoreTrait;
use Rtrs\Modules\Review\Helpers\ReviewFns;
use Rtcl\Controllers\BusinessHoursController as BHS;
use RtclStore\Controllers\Hooks\TemplateHooks as StoreHooks;


class Listing_Functions {

	use StoreTrait;

	protected static $instance = null;

	public function __construct() {
		add_action( 'after_setup_theme', [ $this, 'theme_support' ] );
		add_action( 'init', [ $this, 'rtcl_filter_hook' ] );
		add_action( 'init', [ $this, 'rtcl_action_hook' ] );
		add_filter( 'rtcl_get_icon_list', [ $this, 'rtcl_get_icon_list_modify' ] );
		add_filter( 'rtcl_get_icon_class_list', [ $this, 'rtcl_get_icon_list_modify' ] );

		add_action( 'template_redirect', function () {
			if ( isset( $_GET['cl-migration'] ) && '1' == $_GET['cl-migration'] ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
				global $wpdb;

				$meta_key = '_rtcl_form_id';

				// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
				$deleted = $wpdb->query(
					$wpdb->prepare( "DELETE FROM {$wpdb->postmeta} WHERE meta_key = %s", $meta_key ) // phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
				);

				if ( $deleted ) {
					echo esc_html( "$deleted meta entries with the key '_rtcl_form_id' were deleted." );
				} else {
					echo "No meta entries found with the key '_rtcl_form_id'.";
				}
			}
		} );

		//Add Action Hooks
		add_action( 'rtcl_listing_form_after_save_or_update', [
			$this,
			'listing_form_save'
		], 12, 5 ); // save extra listing form fields

		// Store
		// Store Archive Hooks
		if ( class_exists( 'RtclStore' ) ) {
			remove_action( 'rtcl_before_store_loop_item', [ StoreHooks::class, 'open_store_link' ], 10 );
			remove_action( 'rtcl_after_store_loop_item', [ StoreHooks::class, 'close_store_link' ], 5 );
			remove_action( 'rtcl_after_store_loop_item', [ StoreHooks::class, 'rtcl_after_store_loop_item' ], 5 );
			remove_action( 'rtcl_store_loop_item', [ StoreHooks::class, 'loop_item_store_title' ], 10 );
			remove_action( 'rtcl_store_loop_item', [ StoreHooks::class, 'store_meta' ], 20 );

			add_action( 'rtcl_store_loop_item', [ $this, 'store_top_content_start' ], 5 );
			add_action( 'rtcl_store_loop_item', [ $this, 'loop_item_store_title' ], 10 );
			add_action( 'rtcl_store_loop_item', [ $this, 'store_meta' ], 20 );
			add_action( 'rtcl_store_loop_item', [ $this, 'store_top_content_end' ], 25 );
			add_action( 'rtcl_store_loop_item', [ $this, 'store_bottom_content' ], 40 );
		}

		add_filter( 'rtcl_register_store_category_args', [$this, 'store_category_name_change' ]);
		add_filter( 'rtcl_store_register_post_type_args', [ $this, 'modify_store_post_breadcrumb_args' ] );
		add_filter( 'rtcl_store_category_label', [ $this, 'store_category_label' ] );
		add_filter( 'rtcl_agents_grid_columns_class', [ $this, 'agents_grid_columns_class' ] );
		add_filter( 'rtcl_store_get_ad_count_html', [ $this, 'agency_grid_columns_class' ], 10, 3 );
		add_filter( 'rtcl_bootstrap_dequeue', '__return_false' );

		//CF Form Migration
		add_action( 'rtcl_fb_cf_data_migration', [ $this, 'rtcl_fb_cf_data_migration' ] );
        add_filter( 'rtcl_force_classic_style', '__return_true' );
	}

	public static function instance() {
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	public function theme_support() {
		add_theme_support( 'rtcl' );
	}

	public function rtcl_action_hook() {

		/* = Listing Archive & Single Hooks
		=====================================================================================================*/
		remove_action( 'rtcl_before_main_content', [ TemplateHooks::class, 'output_main_wrapper_start' ], 8 );
		remove_action( 'rtcl_sidebar', [ TemplateHooks::class, 'output_main_wrapper_end' ], 15 );

		remove_action( 'rtcl_before_main_content', [ TemplateHooks::class, 'output_main_wrapper_start' ], 8 );
		remove_action( 'rtcl_before_main_content', [ TemplateHooks::class, 'output_main_wrapper_end' ], 15 );
		

		/* = Listing Archive Hooks
		=====================================================================================================*/
		//Remove Action Hooks
		remove_action( 'rtcl_before_main_content', [ TemplateHooks::class, 'breadcrumb' ], 6 );
		remove_action( 'rtcl_listing_loop_item', [ TemplateHooks::class, 'loop_item_listing_title' ], 20 );
		remove_action( 'rtcl_listing_loop_item', [ TemplateHooks::class, 'loop_item_badges' ], 30 );
		remove_action( 'rtcl_listing_loop_item', [ TemplateHooks::class, 'loop_item_excerpt' ], 70 );
		remove_action( 'rtcl_listing_loop_item', [ TemplateHooks::class, 'listing_price' ], 80 );

		//Add Action Hooks
		add_action( 'rtcl_listing_loop_item', [ $this, 'cl_hotel_listing_title' ], 20 );
		add_action( 'rtcl_listing_loop_item', [ $this, 'cl_hotel_listing_excerpt' ], 30 );
		add_filter( 'rtcl_get_listing_display_options', [ $this, 'listing_archive_extra_options' ] );

		/**
		 * Notice
		 */
		remove_action( 'rtcl_before_listing_loop', [ TemplateHooks::class, 'output_all_notices' ], 10 );
		add_action( 'rtcl_before_listing_loop', [ $this, 'cl_hotel_output_all_notices' ], 10 );

		/* = Listing Details Hooks
		=====================================================================================================*/
		//Add Action Hooks
		add_action( 'wp_ajax_delete_feature_list', [ $this, 'delete_feature_list' ] );

		// Filter Hook
		add_filter( 'rtcl_get_listing_detail_page_display_options', [ $this, 'listing_details_fields_options' ] );

		/**Added Rtcl category color field meta meta */
		add_action( 'rtcl_category_add_form_fields', array($this,'cl_hotel_colorpicker_field_add_new_category' ));
		add_action( 'rtcl_category_edit_form_fields', array($this,'cl_hotel_colorpicker_field_edit_category') ); 

		add_action( 'created_rtcl_category', array($this,'cl_hotel_save_termmeta'));
		add_action( 'edited_rtcl_category', array($this,'cl_hotel_save_termmeta'));

		/* = My Account Dashboard
		=====================================================================================================*/
		remove_action( 'rtcl_edit_account_form_end', [ TemplateHooks::class, 'edit_account_form_submit_button' ], 10 );
		add_action( 'rtcl_edit_account_form_end', [ $this, 'edit_account_form_submit_button' ], 10 );
	}

	public function rtcl_filter_hook() {

		remove_action( 'rtcl_listing_meta_buttons', [ TemplateHooks::class, 'add_favourite_button' ], 10 );

		// Change Grid Column for listing
		// add_filter( 'rtcl_listings_grid_columns_class', function () {
		// 	$columns = 'columns-' . Options::$options['listing_grid_cols'];

		// 	return $columns;
		// } );

		// Change add to favorite text
		add_filter( 'rtcl_text_add_to_favourite', function ( $text ) {
			$text = esc_html__( 'Favourite', 'cl-hotel' );

			return $text;
		} );

		// Pagination
		add_filter( 'rtcl_pagination_args', function ( $args ) {
			$args['prev_text'] = '<i class="demo-icon rt-custom-icon-long-arrow-right left-angle"></i> Previous';
			$args['next_text'] = 'Next <i class="demo-icon rt-custom-icon-long-arrow-right"></i>';

			return $args;
		} );

		// Override Related Listing Item Number
		add_filter( 'rtcl_related_slider_options', function ( $options ) {
			$rpc                     = Options::$options['related_post_slider_cols'];
			$options['breakpoints']  = [
				0    => [
					"slidesPerView" => 1
				],
				576  => [
					"slidesPerView" => 2
				],
				992  => [
					"slidesPerView" => 3
				],
				1400 => [
					"slidesPerView" => $rpc
				]
			];
			$options['spaceBetween'] = 24;

			return $options;
		} );

		// Change Unit Text
		add_filter(
			'rtcl_get_price_unit_list',
			function ( $unitList ) {
				$unitList['year']['short']  = esc_html__( "yr", 'cl-hotel' );
				$unitList['month']['short'] = esc_html__( "mo", 'cl-hotel' );
				$unitList['week']['short']  = esc_html__( "week", 'cl-hotel' );
				$unitList['day']['short']   = esc_html__( "day", 'cl-hotel' );
				$unitList['hour']['short']  = esc_html__( "hr", 'cl-hotel' );

				$unitList['sqft']['short']  = esc_html__( "sqft", 'cl-hotel' );
				$unitList['total']['short'] = esc_html__( "total", 'cl-hotel' );

				$unitList['night']['short'] = esc_html__( "night", 'cl-hotel' );
				$unitList['night']['title'] = esc_html__( "Night", 'cl-hotel' );
				return $unitList;
			}
		);

		// Listing/Directory Settings
		add_filter( 'rtcl_general_settings_options', [ $this, 'listing_custom_listing_options' ] );

		add_filter( 'rtcl_sv_verified_icon_class', function($user_id){
			return 'clr-icon-rt18-subtract-01';
		});

		add_filter( 'rtrs_review_form_string_list', function($string_text){
			return $string_text = [
				'title_reply'               => esc_html__( 'Add a Review', 'cl-hotel' ),
				// translators: %s: Author name.
			'title_reply_to'            => wp_kses( __( 'Leave feedback about this to %s', 'cl-hotel' ), [ 'allow_tag_list' ] ),
				'cancel_reply_link'         => esc_html__( 'Cancel Reply', 'cl-hotel' ),
				'label_submit'              => esc_html__( 'Submit Your Review', 'cl-hotel' ),
				'comment_notes_before'      => '',
				'comment_notes_after'       => '',
				'name_field_placeholder'    => esc_html__( 'Name', 'cl-hotel' ),
				'email_field_placeholder'   => esc_html__( 'Email', 'cl-hotel' ),
				'website_field_placeholder' => esc_html__( 'Website', 'cl-hotel' ),
				'title_field_placeholder'   => esc_html__( 'Title', 'cl-hotel' ),
				'comment_field_placeholder' => esc_html__( 'Write your review', 'cl-hotel' )

			];
		});
	}

	public static function cl_hotel_output_all_notices() {
		if (Functions::print_notices()) {
			echo '<div class="rtcl-notices-wrapper">';
			Functions::print_notices();
			echo '</div>';
		}
	}

	public static function cl_hotel_listing_categories() {
		global $listing;
		if ( $listing->has_category() && $listing->can_show_category() ){
			$categories = $listing->get_categories();
			foreach ( $categories as $category ) {
		?>
		<a href="<?php echo esc_url( get_term_link( $category ) ); ?>" class="category-list">
			<?php echo wp_kses_post( Helper::listing_cat_icon( $category->term_id, 'icon' ) ); ?>
			<?php echo esc_html( $category->name ); ?>
		</a>
		<?php }
        }
	}

	public static function cl_hotel_listing_title() {
		global $listing;
		?>

		<div class="rt-categories">
			<?php 
				self::cl_hotel_listing_categories(); 
				$listing->the_badges();
			?>
		</div>

		<?php
		echo '<h3 class="' . esc_attr( apply_filters( 'rtcl_listing_loop_title_classes', 'listing-title rtcl-listing-title' ) ) . '"><a href="' . esc_url( $listing->get_the_permalink() ) . '">' . esc_html( $listing->get_the_title() ) . '</a></h3>';
	}

	public function listing_custom_listing_options( $options ) {

		$options['cl_hotel_listing_section']             = [
			'title' => esc_html__( 'Listing Settings', 'cl-hotel' ),
			'type'  => 'title',
		];
		$options['listing_feature_list_section_label'] = [
			'title'   => esc_html__( 'Faq List Section Label', 'cl-hotel' ),
			'type'    => 'text',
			'default' => 'Questions & Answers',
		];

		return $options;
	}

	public function listing_archive_extra_options( $options ) {
		$options['rating'] = esc_html__( 'Rating', 'cl-hotel' );
		$options['phone'] = esc_html__( 'Phone', 'cl-hotel' );

		return $options;
	}

	public function listing_details_fields_options( $options ) {
		$options['rating']       = esc_html__( 'Review Rating', 'cl-hotel' );
		$options['phone']        = esc_html__( 'Phone', 'cl-hotel' );
		$options['printing']     = esc_html__( 'Printing', 'cl-hotel' );
		$options['social_share'] = esc_html__( 'Social Share', 'cl-hotel' );
		$options['video_url']    = esc_html__( 'Video', 'cl-hotel' );
		
		return $options;
	}

	public static function listing_single_style() {
		$opt_layout = ! empty( Options::$options['single_listing_style'] ) ? Options::$options['single_listing_style'] : '1';

		return $opt_layout;
	}

	public static function listing_single_banner_option() {
		$opt_layout = ! empty( Options::$options['single_listing_header_banner'] ) ? Options::$options['single_listing_header_banner'] : '1';

		return $opt_layout;
	}

	public static function listing_selected_category( $category_id ){
		$to_get_slug = get_term(  $category_id, 'rtcl_category' );
		$parent_id = $to_get_slug->parent;

		if (!empty($parent_id)) {
			$to_get_slug = get_term( $parent_id, 'rtcl_category' );
		} else {
			$to_get_slug = get_term( $category_id, 'rtcl_category' );
		}
		$cat_slug = $to_get_slug->slug;
		return $cat_slug;
	}

	public static function get_favourites_link( $post_id ) {
		$has_favourites = get_option( 'rtcl_general_settings' );
		if ( isset( $has_favourites['has_favourites'] ) && 'yes' !== $has_favourites['has_favourites'] ) {
			return;
		}
		if ( is_user_logged_in() ) {
			if ( $post_id == 0 ) {
				global $post;
				$post_id = $post->ID;
			}

			$favourites = (array) get_user_meta( get_current_user_id(), 'rtcl_favourites', true );

			if ( in_array( $post_id, $favourites ) ) {
				return '<a href="javascript:void(0)" class="rtcl-favourites" data-bs-toggle="tooltip" data-bs-placement="top" title="' . esc_html__( "Favourite", 'cl-hotel' )
				       . '" class="rtcl-favourites rtcl-active" data-id="' . $post_id . '"><span class="rtcl-icon rtcl-icon-heart"></span><span class="favourite-label">'
				       . \Rtcl\Helpers\Text::remove_from_favourite() . '</span></a>';
			} else {
				return '<a href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-placement="top" title="' . esc_html__( "Favourite", 'cl-hotel' )
				       . '" class="rtcl-favourites" data-id="' . $post_id . '"><i class="rtcl-icon rtcl-icon-heart-empty"></i><span class="favourite-label">'
				       . \Rtcl\Helpers\Text::add_to_favourite() . '</span></a>';
			}
		} else {
			return '<a href="#" class="rtcl-favourites" data-bs-toggle="modal" data-bs-target="#logoutModalCenter" title="' . esc_html__( "Favourites", 'cl-hotel' )
			       . '"><i class="rtcl-icon rtcl-icon-heart-empty"></i><span class="favourite-label">' . \Rtcl\Helpers\Text::add_to_favourite()
			       . '</span></a>';
		}
	}

	public static function logout_user_favourite() {
		global $listing;
		?>
        <!-- Modal -->
        <div class="modal fade" id="logoutModalCenter" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog vertical-align-center" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="logoutModalTitle"><?php esc_html_e( 'Login', 'cl-hotel' ); ?></h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="demo-icon rt-custom-icon-rt18-cross"></i></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="share-icon">
                            <form id="rtcl-login-form" class="form-horizontal" method="post">
								<?php do_action( 'rtcl_login_form_start' ); ?>
                                <div class="form-group">
                                    <label for="rtcl-user-login" class="control-label">
										<?php esc_html_e( 'Username or E-mail', 'cl-hotel' ); ?>
                                        <strong class="rtcl-required">*</strong>
                                    </label>
                                    <input type="text" name="username" autocomplete="username"
                                           value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( sanitize_text_field( wp_unslash( $_POST['username'] ) ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Missing ?>"
                                           id="rtcl-user-login" class="form-control" required/>
                                </div>

                                <div class="form-group">
                                    <label for="rtcl-user-pass" class="control-label">
										<?php esc_html_e( 'Password', 'cl-hotel' ); ?>
                                        <strong class="rtcl-required">*</strong>
                                    </label>
                                    <input type="password" name="password" id="rtcl-user-pass"
                                           autocomplete="current-password"
                                           class="form-control" required/>
                                </div>

								<?php do_action( 'rtcl_login_form' ); ?>

                                <div class="form-group">
                                    <div id="rtcl-login-g-recaptcha" class="mb-2"></div>
                                    <div id="rtcl-login-g-recaptcha-message"></div>
                                </div>

                                <div class="form-group d-flex align-items-center">
                                    <button type="submit" name="rtcl-login" class="btn btn-primary" value="login">
										<?php esc_html_e( 'Login', 'cl-hotel' ); ?>
                                    </button>
                                    <div class="form-check">
                                        <input type="checkbox" name="rememberme" id="rtcl-rememberme" value="forever">
                                        <label class="form-check-label" for="rtcl-rememberme">
											<?php esc_html_e( 'Remember Me', 'cl-hotel' ); ?>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <p class="rtcl-forgot-password">
                                        <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Forgot your password?', 'cl-hotel' ); ?></a>
                                    </p>
                                </div>
								<?php do_action( 'rtcl_login_form_end' ); ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<?php
	}

	public static function get_share_link() {
		global $listing;
		?>
        <!-- Modal -->
        <div class="modal fade social-share" id="exampleModalCenter" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="socialShareModalTitle"><?php esc_html_e( 'Share This Link Via', 'cl-hotel' ); ?></h5>
						<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i class="rt-custom-icon-rt18-cross"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="share-icon">
							<?php $listing->the_social_share(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<?php
	}

	public static function listing_details_banner() {
		global $listing;
		$imgUrl = get_the_post_thumbnail_url( $listing->get_id(), 'full' );
		if ( empty( $imgUrl ) ) {
			$images = $listing->get_images();
			if ( ! empty( $images ) ) {
				$total_gallery_image = count( $images );
				$total_gallery_item  = $total_gallery_image;
				if ( $total_gallery_item ) {
					foreach ( $images as $index => $image ) {
						$img_url = wp_get_attachment_image_url( $image->ID, 'full' );
					}
				}
			} else {
				$img_url = '';
			}
		} elseif ( ! empty( $imgUrl ) ) {
			$img_url = $imgUrl;
		} else {
			$img_url = '';
		}

		//Inner Page Banner Area Start Here
		echo '<section class="inner-page-banner bg-common inner-page-top-margin" data-bg-image="' . esc_url( $img_url ) . '"></section>';
		
	}

	public static function listing_details_gallery() {
		global $listing;

		$detailOption = Functions::get_option_item( 'rtcl_single_listing_settings', 'display_options_detail', [] );

		$video_urls = [];
		if ( ! Functions::is_video_urls_disabled() ) {
			$video_urls = get_post_meta( $listing->get_id(), '_rtcl_video_urls', true );
			$video_urls = ! empty( $video_urls ) && is_array( $video_urls ) ? $video_urls : [];
		}
		// Image Gallery
		$images              = $listing->get_images();
		$total_gallery_image = count( $images );

		$number = $total_gallery_image - 5;

		if ( $total_gallery_image ) {

		?>

            <div class="photo-swip-gallery-wrap">
				<?php
					if ( !in_array('video_url', $detailOption) ){
						if ( ! empty( $video_urls ) ) { ?>
						<div class="listing-gallery-item">
							<div class="video-info rtcl-slider-video-item ratio-16x9">
								<iframe class="rtcl-lightbox-iframe"
										src="<?php echo esc_url( Functions::get_sanitized_embed_url( $video_urls[0] ) ) ?>"
										style="height: 404px"
										frameborder="0" webkitAllowFullScreen
										mozallowfullscreen allowFullScreen></iframe>
							</div>
						</div>
					<?php }
					}
					$counter = 1;
					foreach ( $images as $image ) {
						++$counter;

						if ($total_gallery_image < 2) {
							$img_size = 'rtcl-thumbnail';
						} else {
							$img_size = 'rtcl-thumbnail';
						}					
						?>
						<div class="listing-gallery-item photoswip-item image-size-<?php echo esc_attr($img_size); ?>">
						<?php
							$image_url = wp_get_attachment_image_url( $image->ID, 'full' );
							// Use file_get_contents to get the image data and temporarily save it as a string
							$image_data = @file_get_contents($image_url);

							if ($image_data !== false) {
								// Create a temporary file in memory from the image data
								$temp_image = tmpfile();

								// Write the image data to the temporary file
								fwrite($temp_image, $image_data); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_fwrite

								// Get the temporary file's meta data (including its file path)
								$meta_data = stream_get_meta_data($temp_image);
								$temp_image_path = $meta_data['uri'];

								// Use getimagesize to get the image dimensions
								$image_size = getimagesize($temp_image_path);

								if ($image_size !== false) {
									$width = $image_size[0];
									$height = $image_size[1];
								} else {
									$width = 'auto';
									$height = 'auto';
								}
							?>
							<a class="listing-popup-btn" href="<?php echo esc_url( $image_url ); ?>" data-width="<?php echo esc_attr($width); ?>" data-height="<?php echo esc_attr($height); ?>">
								<?php 
									if ( $counter <= 6 ) {
										echo wp_get_attachment_image( $image->ID, $img_size ); 
									}
									if($counter > 5 ){
										echo '<span>+'.esc_html($number).'</span>';
									}
								?>
							</a>
							<?php
								fclose($temp_image); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_fclose
							}
                            ?>
						</div>
					<?php
					}
				?>
            </div>
		<?php }
	}

	public static function listing_details_slider() { 
		global $listing;
		?>
            <div class="listingDetails-gallery-slider">
                <div class="productDetailsGallery">
                    <?php $listing->the_gallery(); ?>
                </div>
            </div>
	<?php }

	public function get_listing_attachment_id( $post_id, $file ) {
		if ( $file['error'] !== UPLOAD_ERR_OK ) {
			__return_false();
		}

		if ( ! function_exists( 'wp_generate_attachment_metadata' ) ) {
			get_template_part( ABSPATH . "/wp-admin" . '/includes/image.php' );
			get_template_part( ABSPATH . "/wp-admin" . '/includes/file.php' );
			get_template_part( ABSPATH . "/wp-admin" . '/includes/media.php' );
		}

		Filters::beforeUpload();
		// you can use WP's wp_handle_upload() function:
		$status = wp_handle_upload(
			$file,
			[
				'test_form' => false,
			]
		);
		Filters::afterUpload();

		if ( $status && ! isset( $status['error'] ) ) {
			// $filename should be the path to a file in the upload directory.
			$filename = $status['file'];

			// Check the type of tile. We'll use this as the 'post_mime_type'.
			$filetype = wp_check_filetype( basename( $filename ), null );

			// Get the path to the upload directory.
			$wp_upload_dir = wp_upload_dir();

			// Prepare an array of post data for the attachment.
			$attachment = [
				'guid'           => $wp_upload_dir['url'] . '/' . basename( $filename ),
				'post_mime_type' => $filetype['type'],
				'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
				'post_content'   => '',
				'post_status'    => 'inherit',
			];
			// Insert the attachment.
			$attach_id = wp_insert_attachment( $attachment, $filename );
		}

		return isset( $attach_id ) ? $attach_id : 0;
	}

	public function listing_form_save( $post_id, $type, $cat_id, $new_listing_status, $data ) {
		// Feature List
		if ( isset( $_POST['listing_feature_list'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
			$raw_data = isset( $_POST['listing_feature_list'] ) ? wp_unslash( $_POST['listing_feature_list'] ) : []; // phpcs:ignore WordPress.Security.NonceVerification.Missing, WordPress.Security.ValidatedSanitizedInput

			$sanitized_data = [];
			$count          = 0;

			foreach ( $raw_data as $group_no => $features_group ) {
				$feature_menu = [];

				foreach ( $features_group as $key => $value ) {
					if ( $key === 'faqtitle' ) {
						$feature_menu[ $key ] = sanitize_text_field( $features_group['faqtitle'] );
					}
					if ( $key === 'faqdesc' ) {
						$feature_menu[ $key ] = sanitize_textarea_field( $features_group['faqdesc'] );
					}
				}

				if ( ! empty( $feature_menu ) ) {
					$sanitized_data[] = $feature_menu;
				}
			}

			if ( ! empty( $sanitized_data ) ) {
				update_post_meta( $post_id->get_id(), 'listing_feature_list', $sanitized_data );
			}
		}
	}

	public function delete_feature_list() {
		if ( ! empty( $_POST['post_id'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
			delete_post_meta( absint( wp_unslash( $_POST['post_id'] ) ), 'listing_feature_list' ); // phpcs:ignore WordPress.Security.NonceVerification.Missing
			echo 'success';
		} else {
			echo 'error';
		}
		wp_die();
	}

	public function cl_hotel_listing_excerpt() {
		global $listing;
		$excerpt_length = Options::$options['cl_hotel_listing_excerpt'];

		if ( $listing->can_show_excerpt() ) {
			?>
            <p><?php echo esc_html( Helper::cl_hotel_excerpt( $excerpt_length ) ); ?></p>
		<?php }
	}

	public static function listingHourStatus( $listing_id ) {
	}

	public static function get_advanced_search_field_html( $field_id ) {
		$field      = new RtclCFGField( $field_id );
		$field_html = null;

		if ( $field_id && $field ) {
			$id = "rtcl_{$field->getType()}_{$field->getFieldId()}";

			switch ( $field->getType() ) {
				case 'text':
					$field_html = sprintf(
						'<input type="text" class="rtcl-text form-control rtcl-cf-field" id="%s" name="filters[_field_%d]" placeholder="%s" value="" />',
						$id,
						absint( $field->getFieldId() ),
						esc_attr( $field->getPlaceholder() )
					);
					break;
				case 'textarea':
					$field_html = sprintf(
						'<textarea class="rtcl-textarea form-control rtcl-cf-field" id="%s" name="filters[_field_%d]" rows="%d" placeholder="%s"></textarea>',
						$id,
						absint( $field->getFieldId() ),
						absint( $field->getRows() ),
						esc_attr( $field->getPlaceholder() )
					);
					break;
				case 'select':
					$options      = $field->getOptions();
					$choices      = ! empty( $options['choices'] ) && is_array( $options['choices'] ) ? $options['choices'] : [];
					$options_html = '<option value="">' . esc_html( $field->getLabel() ) . '</option>';

					if ( ! empty( $choices ) ) {
						foreach ( $choices as $key => $choice ) {
							$_attr = '';
							if ( isset( $_GET['filters'][ '_field_' . $field->getFieldId() ] ) && $_GET['filters'][ '_field_' . $field->getFieldId() ] == $choice ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended, WordPress.Security.ValidatedSanitizedInput
								$_attr .= ' selected';
							}
							$options_html .= sprintf( '<option value="%s"%s>%s</option>', $key, $_attr, $choice );
						}
					}

					$field_html
						= sprintf(
						'<div class="search-item search-select"><select name="filters[_field_%d]" id="%s" data-placeholder="%s" class="select2">%s</select></div>',
						absint( $field->getFieldId() ),
						$id,
						$field->getLabel(),
						$options_html
					);
					break;
				case 'checkbox':
					$options       = $field->getOptions();
					$value         = isset( $_GET['filters'][ '_field_' . $field->getFieldId() ] ) ? $_GET['filters'][ '_field_' . $field->getFieldId() ] : []; // phpcs:ignore WordPress.Security.NonceVerification.Recommended, WordPress.Security.ValidatedSanitizedInput
					$choices       = ! empty( $options['choices'] ) && is_array( $options['choices'] ) ? $options['choices'] : [];
					$check_options = null;
					if ( ! empty( $choices ) ) {
						foreach ( $choices as $key => $choice ) {
							$_attr = '';
							if ( in_array( $key, $value ) ) {
								$_attr .= ' checked="checked"';
							}
							$check_options .= sprintf(
								'<div class="form-check"><input class="form-check-input" id="%s" type="checkbox" name="filters[_field_%d][]" value="%s"%s><label class="form-check-label" for="%s">%s</label></div>',
								$id . $key,
								absint( $field->getFieldId() ),
								$key,
								$_attr,
								$id . $key,
								$choice
							);
						}
					}
					$field_html = sprintf( '<div class="search-item checkbox-wrapper">%s</div>', $check_options );
					break;
				case 'radio':
					$options       = $field->getOptions();
					$choices       = ! empty( $options['choices'] ) && is_array( $options['choices'] ) ? $options['choices'] : [];
					$check_options = null;
					if ( ! empty( $choices ) ) {
						foreach ( $choices as $key => $choice ) {
							$check_options .= sprintf(
								'<div class="form-check"><input class="form-check-input" id="%s" type="radio" name="filters[_field_%d]" value="%s"><label class="form-check-label" for="%s">%s</label></div>',
								$id . $key,
								absint( $field->getFieldId() ),
								$key,
								$id . $key,
								$choice
							);
						}
					}
					$field_html = sprintf( '<div class="search-item search-type"><div class="search-check-box">%s</div></div>', $check_options );
					break;
				case 'number':
					$hidden_field = sprintf(
						'<input type="hidden" class="min-volumn" name="filters[_field_%d][min]" value="%s">',
						absint( $field->getFieldId() ),
						isset( $_GET['filters'][ '_field_' . $field->getFieldId() ]['min'] ) ? absint( $_GET['filters'][ '_field_' . $field->getFieldId() ]['min'] ) : '' // phpcs:ignore WordPress.Security.NonceVerification.Recommended
					);
					$hidden_field .= sprintf(
						'<input type="hidden" class="max-volumn" name="filters[_field_%d][max]" value="%s">',
						absint( $field->getFieldId() ),
						isset( $_GET['filters'][ '_field_' . $field->getFieldId() ]['max'] ) ? absint( $_GET['filters'][ '_field_' . $field->getFieldId() ]['max'] ) : '' // phpcs:ignore WordPress.Security.NonceVerification.Recommended
					);

					$field_html = sprintf(
						'<div class="search-item">
							<div class="price-range">
								<label>%s</label>
								<input type="number" class="ion-rangeslider" id="%s" data-step="%s" %s %s data-min="%d" data-max="%s" />
								%s
							</div>
						</div>',
						esc_attr( $field->getLabel() ),
						$id,
						$field->getStepSize() ? esc_attr( $field->getStepSize() ) : 'any',
						isset( $_GET['filters'][ '_field_' . $field->getFieldId() ]['min'] ) ? sprintf( // phpcs:ignore WordPress.Security.NonceVerification.Recommended
							'data-from="%s"', // phpcs:ignore WordPress.Security.NonceVerification.Recommended
							absint( $_GET['filters'][ '_field_' . $field->getFieldId() ]['min'] ) // phpcs:ignore WordPress.Security.NonceVerification.Recommended
						) : '',
						isset( $_GET['filters'][ '_field_' . $field->getFieldId() ]['max'] ) && ! empty( $_GET['filters'][ '_field_' . $field->getFieldId() ]['max'] ) ? sprintf( // phpcs:ignore WordPress.Security.NonceVerification.Recommended
							'data-to="%s"', // phpcs:ignore WordPress.Security.NonceVerification.Recommended
							absint( $_GET['filters'][ '_field_' . $field->getFieldId() ]['max'] ) // phpcs:ignore WordPress.Security.NonceVerification.Recommended
						) : '',
						$field->getMin() !== '' ? absint( $field->getMin() ) : '',
						! empty( $field->getMax() ) ? absint( $field->getMax() ) : absint( $field->getMin() ) + 100,
						$hidden_field
					);
					break;
				case 'url':
					$field_html = sprintf(
						'<input type="url" class="rtcl-url form-control rtcl-cf-field" id="%s" name="filters[_field_%d]" placeholder="%s" value="" />',
						$id,
						absint( $field->getFieldId() ),
						esc_attr( $field->getPlaceholder() )
					);
					break;
			}
		}

		return $field_html;
	}

	public function widget_filter_custom_fields_item() {
		$group_id = '';
		$group_id = isset( Options::$options['custom_fields_search_items'] ) ? Options::$options['custom_fields_search_items'] : 0;
		if ( is_array( $group_id ) && count( $group_id ) < 2 ) {
			$group_id = end( $group_id );
		}
		if ( ! empty( $group_id ) ) {
		?>
		<div class="rtcl-cfg-filter ui-accordion-item is-open">
			<?php
				$field_ids = Functions::get_cf_ids_by_cfg_id( $group_id );
				if ( ! empty( $field_ids ) ) {
					?>
						<?php
							$args      = [
								'is_searchable'     => true,
								'exclude_group_ids' => $group_id,
							];
							$fields_id = Functions::get_cf_ids( $args );
							$html      = '';
							foreach ( $field_ids as $field ) {
								$field_label = new RtclCFGField( $field );
								if ( $field_label->getLabel() ) {
									$html .= '<a class="ui-accordion-title"><span>' . $field_label->getLabel() . '</span><span class="ui-accordion-icon rtcl-icon rtcl-icon-anchor"></span></a>';
								}
								$html .= '<div class="ui-accordion-content" style="display: block;">' . self::get_advanced_search_field_html( $field ) . '</div>';
							}
							Functions::print_html( $html, true );
						?>
			<?php } ?>
		</div>
	<?php }
	}

	public function cl_hotel_colorpicker_field_add_new_category( $taxonomy ) { ?>
		<div class="form-field term-colorpicker-wrap">
			<label for="term-colorpicker"><?php esc_html_e( 'Category Color', 'cl-hotel' ); ?></label>
			<input name="rt_category_color" value="#f22929" class="colorpicker" id="term-colorpicker" />
			<p><?php esc_html_e( 'This is category background color.', 'cl-hotel' ); ?></p>
		</div>
		<?php
	}

	public function cl_hotel_colorpicker_field_edit_category($term){
		$color = get_term_meta( $term->term_id, 'rt_category_color', true );
		$color = ( ! empty( $color ) ) ? "#{$color}" : '#f22929';
		?>
		<tr class="form-field term-colorpicker-wrap">
			<th scope="row"><label for="term-colorpicker"><?php esc_html_e( 'Category Color', 'cl-hotel' ); ?></label></th>
			<td>
				<input name="rt_category_color" value="<?php echo esc_attr( $color ); ?>" class="colorpicker" id="term-colorpicker" />
				<p class="description"><?php esc_html_e( 'This is category background color.', 'cl-hotel' ); ?></p>
			</td>
		</tr>
		<?php
	}

	public function cl_hotel_save_termmeta( $term_id ) {
		// Save term color if possible
		if( isset( $_POST['rt_category_color'] ) && ! empty( $_POST['rt_category_color'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
			update_term_meta( $term_id, 'rt_category_color', sanitize_hex_color_no_hash( wp_unslash( $_POST['rt_category_color'] ) ) ); // phpcs:ignore WordPress.Security.NonceVerification.Missing
		} else {
			delete_term_meta( $term_id, 'rt_category_color' );
		}

		if( isset( $_POST['rt_category_image'] ) && ! empty( $_POST['rt_category_image'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
			update_term_meta( $term_id, 'rt_category_image', absint( $_POST['rt_category_image'] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Missing
		} else {
			delete_term_meta( $term_id, 'rt_category_image' );
		}
	}

	static public function get_listing_reviews( $listing ) {
		if( class_exists( ReviewFns::class ) ){
		  $average_rating = ReviewFns::getAvgRatings( get_the_ID() );
		  $rating_count   = ReviewFns::getTotalRatings( get_the_ID() );
		} else {
			$average_rating = $listing->get_average_rating();
			$rating_count   = $listing->get_rating_count();
		} 

		if ( $rating_count > 1 ) {
            $rating_count_text = esc_html__( ' Reviews', 'cl-hotel' );
        } else {
            $rating_count_text = esc_html__( ' Review', 'cl-hotel' );
        }
		if ( ! empty( $rating_count )) { ?>
			<div class="product-rating">
			  	<div class="item-icon">
			  		<i class="fa-solid fa-star"></i>
					<?php echo wp_kses_post( $average_rating ); ?>
			  	</div>
			  	<div class="item-text"><?php echo wp_kses_post( apply_filters( 'cl_hotel_rating_count_format', sprintf( '<span>%s %s</span>', esc_html( $rating_count ), esc_html( $rating_count_text ) ) ) ); ?></div>
		  	</div>
		<?php }
	}

	public function clh_agents_grid_columns_class($columns) {
		return 'row row-cols-lg-3 row-cols-sm-2 row-cols-1 justify-content-center';
	}

	public function edit_account_form_submit_button() { ?>
		<div class="form-group row">
			<div class="offset-sm-3 col-sm-9">
				<input type="submit" name="submit" class="btn btn-primary" value="<?php esc_attr_e( 'Update Account', 'cl-hotel' ); ?>"/>
			</div>
		</div>
		<?php
	}

	public static function form_builder_custom_group_field_check() {
        global $listing;
		$form = $listing->getForm();
		if($form){
			$fields = $form->getFieldAsGroup( FBField::CUSTOM );
			$fields_available = false;
			if ( count( $fields ) ) {
				foreach ( $fields as $fieldName => $field ) {
					$field = new FBField( $field );
					$value = $field->getFormattedCustomFieldValue( $listing->get_id() );
					if (!empty($value)){
						return true;
					}
				}
				return $fields_available;
			}
		}
    }

	public static function can_show_ad_type() {
		$display_option_page = is_singular( rtcl()->post_type ) ? 'rtcl_single_listing_settings' : 'rtcl_archive_listing_settings';
		$display_option = is_singular( rtcl()->post_type ) ? 'display_options_detail' : 'display_options';
		$can_show_type = Functions::get_option_item( $display_option_page, $display_option, 'ad_type', 'multi_checkbox' );
		return apply_filters( 'rtcl_listing_can_show_ad_type', $can_show_type );
	}

	public static function get_listing_type( $listing ) {

		$listing_types = Functions::get_listing_types();
		$listing_types = empty( $listing_types ) ? [] : $listing_types;

		$type = $listing->get_ad_type();

		if ( $type && ! empty( $listing_types[ $type ] ) ) {
			$result = [
				'label' => $listing_types[ $type ],
				'icon'  => 'fa-tags'
			];
		} else {
			$result = false;
		}

		return $result;
	}

	public static function is_enable_form_builder( $listing ){
		$form = null;
		if ( FBHelper::isEnabled() ) {
			$_form = $listing->getForm();
			if ( $_form ) {
				$form = $_form;
			}
		}

		if ( FBHelper::isEnabled() && $form ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Check if a URL is external to the current site.
	 *
	 * @param string|null $url The URL to check.
	 *
	 * @return bool
	 */
	public static function is_external( $url ) {
		if ( empty( $url ) ) {
			return false;
		}

		$site_url = str_replace( 'www.', '', (string) wp_parse_url( site_url(), PHP_URL_HOST ) );
		$url      = str_replace( 'www.', '', (string) wp_parse_url( $url, PHP_URL_HOST ) );

		if ( empty( $url ) ) {
			return false;
		}

		if ( strcasecmp( $url, $site_url ) === 0 ) {
			return false;
		}

		return true;
	}

	public function rtcl_fb_cf_data_migration( $postId ) {
		$old_faq = get_post_meta( $postId, 'listing_feature_list', true );

		if ( ! empty( $old_faq ) && is_array( $old_faq ) ) {
			$newFaq = [];
			foreach ( $old_faq as $index => $faq ) {
				$newFaq[ $index ] = $faq;
			}
			if ( ! empty( $newFaq ) ) {
				delete_post_meta( $postId, 'faq_list' );
				add_post_meta( $postId, 'faq_list', $newFaq );
			}
		}
	}

	public static function business_open_close_status( $listing ){
		$form = null;
		if ( FBHelper::isEnabled() ) {
			$_form = $listing->getForm();
			if ( $_form && $_form->getFieldByElement( 'business_hours' ) ) {
				$form = $_form;
			}
		}

		if ( FBHelper::isEnabled() && $form ) {
			$business_hours = BHS::get_business_hours( $listing->get_id() );
			if ( ! empty( $business_hours['bhs'] ) ) {
				$business_hours = $business_hours['bhs'];
			}
		} else {
			$business_hours = BHS::get_old_business_hours( $listing->get_id() );
		}

		return BHS::openStatus( $business_hours );
	}

	public function rtcl_get_icon_list_modify( $icons_lists ) {
		$new_icons = [
			" rt-custom-icon-check-icon",
			" rt-custom-icon-email-icon",
			" rt-custom-icon-rt18-arrow2-left",
			" rt-custom-icon-long-arrow-right",
			" rt-custom-icon-button-arrow-icon-right",
			" rt-custom-icon-icon-cafe",
			" rt-custom-icon-arrow-right-circle",
			" rt-custom-icon-r-cat7",
			" rt-custom-icon-arrow-right3",
			" rt-custom-icon-cafe-small-icon",
			" rt-custom-icon-phone-icon",
			" rt-custom-icon-museum",
			" rt-custom-icon-rt18-arrow3-left",
			" rt-custom-icon-reply",
			" rt-custom-icon-list_2",
			" rt-custom-icon-d-book",
			" rt-custom-icon-share-icon",
			" rt-custom-icon-check",
			" rt-custom-icon-d-brain",
			" rt-custom-icon-rt18-arrow-left",
			" rt-custom-icon-rt18-arrow-right",
			" rt-custom-icon-like",
			" rt-custom-icon-vector-22",
			" rt-custom-icon-element8",
			" rt-custom-icon-search-normal",
			" rt-custom-icon-gym",
			" rt-custom-icon-shop",
			" rt-custom-icon-d-calendar",
			" rt-custom-icon-01-map-1",
			" rt-custom-icon-02-star-2",
			" rt-custom-icon-calendar-check",
			" rt-custom-icon-rt18-berger",
			" rt-custom-icon-d-eye",
			" rt-custom-icon-vector-25",
			" rt-custom-icon-vector-3",
			" rt-custom-icon-vector-4",
			" rt-custom-icon-vector-5",
			" rt-custom-icon-vector-17",
			" rt-custom-icon-user-2",
			" rt-custom-icon-vector-20",
			" rt-custom-icon-vector-21",
			" rt-custom-icon-r-cat8",
			" rt-custom-icon-r-cat9",
			" rt-custom-icon-star_2",
			" rt-custom-icon-icon-restaurant",
			" rt-custom-icon-phone",
			" rt-custom-icon-d-heart",
			" rt-custom-icon-d-heart1",
			" rt-custom-icon-d-teeth",
			" rt-custom-icon-logn-arrow-left",
			" rt-custom-icon-d-user1",
			" rt-custom-icon-rt8-user3",
			" rt-custom-icon-d-user3",
			" rt-custom-icon-d-clock",
			" rt-custom-icon-arrow-left",
			" rt-custom-icon-arrow-right2",
			" rt-custom-icon-berger",
			" rt-custom-icon-berger2",
			" rt-custom-icon-calendar1-1",
			" rt-custom-icon-grid",
			" rt-custom-icon-rt18-checck",
			" rt-custom-icon-glob",
			" rt-custom-icon-rt18-comments",
			" rt-custom-icon-rt18-cross",
			" rt-custom-icon-gallery",
			" rt-custom-icon-rt18-drinks",
			" rt-custom-icon-commemts",
			" rt-custom-icon-add-user",
			" rt-custom-icon-rt18-faluda",
			" rt-custom-icon-rt18-gamecard",
			" rt-custom-icon-rt18-grid",
			" rt-custom-icon-rt18-heart",
			" rt-custom-icon-rt18-icecream",
			" rt-custom-icon-rt18-list",
			" rt-custom-icon-rt18-lock",
			" rt-custom-icon-rt18-marker",
			" rt-custom-icon-rt18-phone2",
			" rt-custom-icon-rt18-plus",
			" rt-custom-icon-rt18-quote",
			" rt-custom-icon-list",
			" rt-custom-icon-rt18-search",
			" rt-custom-icon-rt18-select",
			" rt-custom-icon-rt18-share",
			" rt-custom-icon-rt18-smoke",
			" rt-custom-icon-quote",
			" rt-custom-icon-printer",
			" rt-custom-icon-rt18-tea",
			" rt-custom-icon-love",
			" rt-custom-icon-rt18-user",
			" rt-custom-icon-rt18-user2",
			" rt-custom-icon-rt18-users",
			" rt-custom-icon-compare",
			" rt-custom-icon-camera",
			" rt-custom-icon-calendar",
			" rt-custom-icon-rt18-eye-01",
			" rt-custom-icon-rt18-papper2-01",
			" rt-custom-icon-rt18-papper-01",
			" rt-custom-icon-rt18-star-01",
			" rt-custom-icon-rt18-subtract-01"
		];
		return array_merge( $icons_lists, $new_icons );
	}

}