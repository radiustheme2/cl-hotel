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

$rt_logo_two = empty( Helper::rt_logo_two() ) ? get_bloginfo( 'name' ) : Helper::rt_logo_two();

?>
<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo-two">
	<?php if ( !empty( Helper::rt_logo_two() ) ){
		echo wp_kses_post( Helper::rt_logo_two() );
	} else {
		echo wp_kses_post( $rt_logo_two );
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