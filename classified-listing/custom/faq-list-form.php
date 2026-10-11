<?php
/**
 * This file is for adding extra feature list in listing form
 *
 * @version 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Rtcl\Helpers\Functions;

	global $listing;
    $listing_id = $listing->get_id();
	$generalSettings = Functions::get_option( 'rtcl_general_settings' );
    $sectionLabel = !empty( $generalSettings['listing_feature_list_section_label'] ) ? $generalSettings['listing_feature_list_section_label'] : '';
?>

<div class="additional-input-wrap">
	<div class="rtcl-post-section-title">
		<h3><?php echo esc_html( $sectionLabel ); ?>:</h3>
	</div>

	<div class="listing-feature-wrapper">
		<div class="additional-input-wrap group-bottom">
			<div class="form-group row">
				<div class="col-md-12">
					<div class="listing-feature-wrapper">
						<div class="listing-feature-wrap">
							<?php
								$features_list = get_post_meta( $listing_id, "listing_feature_list", true );
								if (!empty($features_list && $features_list['0']['faqtitle'] !='')) {
									foreach ($features_list as $key => $feature) {
									?>
										<div class="listing-feature-item">
											<span class="rt-remove"><i class="fa fa-times" aria-hidden="true"></i></span>
											<div class="listing-feature-title">
											<input type="text"
											name="listing_feature_list[<?php echo absint($key); ?>][faqtitle]"
											class="form-control"
											value="<?php echo isset($feature['faqtitle']) ? esc_attr($feature['faqtitle']) : '' ?>"
											placeholder="<?php esc_attr_e( 'Faq Title', 'cl-hotel' ); ?>">
											</div>
											<div class="rn-ingredient-wrap">
												<textarea type="text"
													name="listing_feature_list[<?php echo absint($key); ?>][faqdesc]"
													class="form-control"
													placeholder="<?php esc_attr_e( 'Faq Description', 'cl-hotel' ); ?>">
													<?php echo isset($feature['faqdesc']) ? esc_attr($feature['faqdesc']) : '' ?>
												</textarea>
											</div>
										</div>
									<?php
									}
								}
							?>
						</div>
						<div class="listing-feature-actions">
							<a href="javascript:void()"
							class="btn-upload add-feature btn-sm btn-primary"><?php esc_html_e('Add New Faq', 'cl-hotel'); ?></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>