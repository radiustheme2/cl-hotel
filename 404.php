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
use RadiusTheme\CLHotel\Options;

?>

<?php get_header(); ?>
<!--=====================================-->
<!--=           404 Area Start          =-->
<!--=====================================-->
<section class="error-wrap-layout section-padding bg-image text-center">
	<div class="container">
		<div class="row">
			<div class="col-lg-10 mx-auto">
				<div class="item-logo">
					<?php echo wp_get_attachment_image(  Options::$options['error_bg_img'], 'full' ); ?>
				</div>
				<h2 class="main-title"><?php echo esc_html( Options::$options['error_page_title'] ); ?></h2>
				<p class="desc"><?php echo esc_html( Options::$options['error_page_desc'] ); ?></p>	
				<div class="btn-wrap btn-v2">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="item-btn">
						<?php echo esc_html( Options::$options['error_buttontext'] ); ?>
						<i class="demo-icon rt-custom-icon-rt18-arrow3-left"></i>
					</a>
				</div>
			</div>
		</div>
	</div>	
</section>
<!--=====================================-->
<!--=           404 Area End            =-->
<!--=====================================-->
<?php get_footer(); ?>