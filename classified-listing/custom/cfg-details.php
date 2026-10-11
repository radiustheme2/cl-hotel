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

$group_ids = isset( Options::$options['custom_fields_list_types'] ) ? Options::$options['custom_fields_list_types'] : [];


$field_ids = [];

if ( ! empty( $group_ids ) ) {
	$group_ids = explode(',', $group_ids);
	foreach ( $group_ids as $group_id ) {
		$temp_ids  = Functions::get_cf_ids_by_cfg_id( $group_id );
		$field_ids = array_merge( $field_ids, $temp_ids );
	}
}

?>

<?php
$fieldExist = false;
if ( ! empty( $field_ids ) ) {
	$count = 1;
	
	foreach ( $field_ids as $single_field ) {
		$field = new RtclCFGField( $single_field );
		$value = $field->getFormattedCustomFieldValue( $listing->get_id() );
		$icon  = $field->getIconClass() ? $field->getIconClass() : '';
		if ( ! $value || empty( $value ) ) {
			continue;
		}
		
		if ( $field->getType() !== 'checkbox' && $count==1 ) {
			$fieldExist = true;
			?>
			<div class="listingDetails-block mb-30">
				<ul class="features-list">
		<?php
		}
		if ( $field->getType() !== 'checkbox' ) {
			$count ++;
		?>
        <li class="groups-without-checkbox id-<?php echo esc_attr( $single_field ); ?>">
            <?php if (!empty($icon)){ ?>
                <div class="features-icon">
                    <i class="rtcl-icon rtcl-icon-<?php echo esc_attr( $icon ); ?>"></i>
                </div>
            <?php } ?>
            <div class="features-content">
				<?php if ( $field->getLabel() ): ?>
                    <h3 class="heading-title rtcl-field-<?php echo esc_attr( $field->getType() ) ?>">
						<?php echo esc_html( $field->getLabel() ); ?>
                    </h3>
				<?php endif; ?>
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
						<?php endif;
                    ?>
                </span>
            </div>
        </li>
		<?php }
	}
}

if ( $fieldExist ) {
	?>
		</ul>
	</div>
	<?php
}
?>