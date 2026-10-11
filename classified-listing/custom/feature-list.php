<?php
/**
 * This file is for showing listing header
 *
 * @version 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Rtcl\Helpers\Functions;

global $listing;
$foodList = get_post_meta( $listing->get_id(), "listing_food_list", true );
$generalSettings = Functions::get_option( 'rtcl_general_settings' );
$sectionLabel = !empty( $generalSettings['listing_feature_list_section_label'] ) ? $generalSettings['listing_feature_list_section_label'] : '';

?>
<?php if ( ! empty( $foodList && $foodList['0']['gtitle'] !='' ) ) { ?>
<div class="features-list widget">
	<div class="item-heading">
		<div class="align-items-center">
			<h3 class="listingDetails-block__heading"><?php echo esc_html( $sectionLabel ); ?></h3>
		</div>
	</div>
	<div class="accordion" id="accordionExample">
		<?php
		$count = 0;
		?>
		<?php foreach ( $foodList as $food ):
			$count ++;
			$gtitle   = $food['gtitle'] ?? '';
			$food_list   = $food['food_list'] ?? '';
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

				<?php if ( ! empty( $gtitle ) ): ?>
				<div class="group-title">
					<?php if ( ! empty( $gtitle ) ): ?>
					<h5><?php echo esc_html( $gtitle ); ?></h5>
					<?php endif; ?>
				</div>
				<?php endif; ?>
			</div>
			<div id="collapse<?php echo esc_attr( $count ); ?>"
				class="collapse <?php echo esc_attr( $show ); ?> tab-content" data-bs-parent="#accordionExample">
				<div class="card-body">
					<?php if ( ! empty( $food_list ) ){ ?>
					<div class="single-listing-food-menu food-item">
						<?php foreach ($food_list as $key => $value) { 
							$imgID = $title = $foodprice = $desc = '';
							if (isset($value['attachment_id'] )) {
								$imgID = $value['attachment_id'];
							}
							if (isset($value['title'] )) {
								$title = $value['title'];
							}
							if (isset($value['foodprice'] )) {
								$foodprice = $value['foodprice'];
							}
							if (isset($value['description'] )) {
								$desc = $value['description'];
							}
							$has_attachment = ! empty( $imgID ) && !empty(wp_get_attachment_image( $imgID ));
						?>
						<figure>
							<?php if ( ! empty( $has_attachment ) ): ?>
							<a href="<?php echo esc_url( wp_get_attachment_image_url( $imgID, 'full' ) ); ?>"
								class="food-img" data-size="600x600">
								<img src="<?php echo esc_url( wp_get_attachment_image_url( $imgID, 'full' ) ); ?>"
									alt="Image description" />
							</a>
							<?php endif; ?>
							<div class="food-info">
								<div class="title-price">
									<?php if ( ! empty( $title ) ): ?>
									<h5><?php echo esc_html( $title ); ?></h5>
									<?php endif; ?>
									<?php if ( ! empty( $foodprice ) ): ?>
									<h6><?php echo esc_html( $foodprice ); ?></h6>
									<?php endif; ?>
								</div>
								<?php if ( ! empty( $desc ) ): ?>
								<p><?php echo esc_html( $desc ); ?></p>
								<?php endif; ?>
							</div>
						</figure>
						<?php } ?>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
		<?php endforeach; ?>
	</div>
</div>
<?php } ?>