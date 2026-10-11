<?php 
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use RadiusTheme\CLHotel\Helper;

$rt_logo_one = empty( Helper::rt_logo_one() ) ? get_bloginfo( 'name' ) : Helper::rt_logo_one();
?>

<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo-one">
	<?php if ( !empty( Helper::rt_logo_one() ) ){
		echo wp_kses_post( Helper::rt_logo_one() );
	} else {
		echo wp_kses_post( $rt_logo_one );
	} ?>
</a>
<?php 
	if ( display_header_text() == true ) {
		$description = get_bloginfo( 'description', 'display' );
	if ( $description || is_customize_preview() ) : ?>
		<div class="site-description"><?php echo esc_html( $description ); ?></div>
	<?php endif; 
	}
?>