<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use RadiusTheme\CLHotel\Options;
$widget_areas = Options::$options['f1_widgets_area'];

?>

<!--=====================================-->
<!--=         Footer Area Start         =-->
<!--=====================================-->
<footer class="footer footer-2">
    <?php if ( is_active_sidebar( 'footer-widget-1-1' ) || is_active_sidebar( 'footer-widget-1-2' ) || is_active_sidebar( 'footer-widget-1-3' ) || is_active_sidebar( 'footer-widget-1-4' ) ) { ?>
    <div class="footer-top">
        <div class="container">
            <div class="row justify-content-between footer-widget-area">
                <?php for ( $i = 1; $i <= $widget_areas; $i++ ) { ?>
                <div class="col-lg-<?php echo esc_attr(Options::$options['f1_area'.$i.'_column']); ?> col-md-6">
                    <?php dynamic_sidebar( 'footer-widget-1-'.esc_attr($i) ); ?>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <?php } ?>
    <div class="footer-bottom">
        <div class="container">
            <div class="copyright-area">
                <?php if ( Options::$options['back_to_top'] ) { ?>
                    <div class="scroll-top-top">
                        <a href="#" class="scrollup"><i class="clr-icon-rt18-arrow-right"></i></a>
                    </div>
                <?php } ?>
                <p class="footer-copyright mb-0"><?php echo wp_kses_post( Options::$options['copyright_text'] ); ?></p>
            </div>
        </div>
    </div>
</footer>
<!--=====================================-->
<!--=          Footer Area End          =-->
<!--=====================================-->    