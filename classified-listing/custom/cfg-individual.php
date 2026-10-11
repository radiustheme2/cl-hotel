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
use Rtcl\Models\RtclCFGField;
use RadiusTheme\CLHotel\Options;

global $listing;

$groups_id = isset( Options::$options['custom_fields_group_types'] ) ? Options::$options['custom_fields_group_types'] : [];

$groups_id = array_filter( $groups_id );

?>

<?php
	if ( ! empty( $groups_id ) ) {
		$count = 1;
		foreach ( $groups_id as $group_id ) { 
			
			?>
				<?php 

				$fieldExist = false;

				$atts = [
					'group_ids' => $group_id
				];

				if ( $group_id ) {
					$field_ids   = Functions::get_cf_ids( $atts );
				}

				foreach ( $field_ids as $single_field ) {
					$field = new RtclCFGField( $single_field );
					$value = $field->getFormattedCustomFieldValue( $listing->get_id() );
					if ( ! $value || empty( $value ) ) {
						continue;
					}

					if ( $field->getType() == 'checkbox' ) {
						$fieldExist = true;
						?>
						<div class="listingDetails-block mb-30">
							<div class="listingDetails-amenities">
					<?php
					}
				?>
				<div class="cl-hotel-cfg-content">
					<?php if ( $field->getLabel() ): ?>
						<h3 class="rtcl-field-<?php echo esc_attr( $field->getType() ) ?> listingDetails-block__heading mb-25">
							<?php echo esc_html( $field->getLabel() ); ?>
						</h3>
					<?php endif; ?>
					<?php if ( $field->getType() === 'checkbox' ) { $count ++; ?>
						<div class="cfp-value">
							<?php
								$icon = $field->getIconClass();
								if ($icon) {
									$icon = '<i class="'.$icon.'"></i>';
								}	
								$iconClass = $icon ? 'icon-have' : 'icon-none';							
								$facilities = Functions::get_cf_data( $single_field );
								$data      = $facilities['value'];
								$options   = $facilities['options']['choices'];
								echo "<ul>";
								foreach ( $options as $key => $value ) {
									if ( in_array( $key, $data ) === true ) {
										echo '<li class="' . esc_attr( $iconClass ) . '">' . wp_kses_post( $icon ) . ' ' . esc_html( $value ) . '</li>';
									}
								}
								echo "</ul>";
								?>
								<?php
							?>
						</div>
					<?php } else { $count ++; ?>
						<span class="cfp-value">
							<?php 
							if ( ! empty( $value ) ): ?>
								<?php if ( $field->getType() === 'url' ):
									$nofollow = ! empty( $field->getNofollow() ) ? ' rel="nofollow"' : ''; ?>
									<a href="<?php echo esc_url( $value ); ?>"
									target="<?php echo esc_attr( $field->getTarget() ) ?>"
												<?php echo esc_html( $nofollow ) ?>><?php echo esc_html( $field->getLabel() ) ?></a>
								<?php else: ?>
									<?php Functions::print_html( $value ); ?>
								<?php endif; ?>
							<?php endif; ?>
						</span>		
					<?php } ?>
				</div>
				<?php } if ( $fieldExist ) { ?>

				</div>
			</div>
			
			<?php }
		}
	}
?>