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
	$feature_list = get_post_meta( $listing->get_id(), "listing_feature_list", true );
	$faq_list = get_post_meta( $listing->get_id(), "faq_list", true );
    if (!empty($faq_list)) {
	    $faqList = $faq_list;
    } else {
	    $faqList = $feature_list;
    }

	$generalSettings = Functions::get_option( 'rtcl_general_settings' );
	$sectionLabel = !empty( $generalSettings['listing_feature_list_section_label'] ) ? $generalSettings['listing_feature_list_section_label'] : '';
?>
<?php if ( ! empty( $faqList && $faqList['0']['faqtitle'] !='' ) ) { ?>
	<div class="listing-features-list widget">
		<div class="item-heading">
			<div class="align-items-center">
				<h3 class="listingDetails-block__heading"><?php echo esc_html( $sectionLabel ); ?></h3>
			</div>
		</div>
		<div class="accordion" id="accordionExample">
			<?php $count = 0; ?>
			<?php foreach ( $faqList as $faq ):
				$count ++;
				$faqTitle   = $faq['faqtitle'] ? $faq['faqtitle'] : '';
				$faqDesc   = $faq['faqdesc'] ? $faq['faqdesc'] : '';
				if ( $count === 1 ) {
					$show      = 'show';
					$expand    = 'true';
					$collapsed = '';
				} else {
					$show      = '';
					$expand    = 'false';
					$collapsed = ' collapsed';
				}
				?>
				<div class="card">
					<div class="card-header<?php echo esc_attr( $collapsed ); ?>" data-bs-toggle="collapse"
						data-bs-target="#collapse<?php echo esc_attr( $count ); ?>"
						aria-expanded="<?php echo esc_attr( $expand ); ?>" role="tabpanel">

						<?php if ( ! empty( $faqTitle ) ): ?>
						<div class="group-title">
							<?php if ( ! empty( $faqTitle ) ): ?>
							<h4><?php echo esc_html( $faqTitle ); ?></h4>
							<?php endif; ?>
						</div>
						<?php endif; ?>
					</div>
					<div id="collapse<?php echo esc_attr( $count ); ?>"
						class="collapse <?php echo esc_attr( $show ); ?> tab-content" data-bs-parent="#accordionExample">
						<div class="card-body">
							<?php if ( ! empty( $faqDesc ) ){ ?> 
							<p><?php echo esc_html( $faqDesc ); ?></p>
							<?php } ?>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
<?php } ?>