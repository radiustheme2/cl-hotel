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
use RadiusTheme\CLHotel\Helper;

$title = Options::$options['newsletter_title'];
$desc = Options::$options['newsletter_desc'];
$shortcode = Options::$options['newsletter_shortcode'];

?>

<!--=====================================-->
<!--=           Apps Download           =-->
<!--=====================================-->
<section class="footer-newsletter call-to-action primary-bg overflow-hidden">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-6">
                <div class="newsletter-block">
                    <?php if(!empty( $title )){ ?>
                        <h2 class="newsletter-block__heading text-white"><?php echo esc_html( $title ); ?></h2>
                    <?php } if(!empty( $desc )){ ?>
                        <p class="newsletter-block__text text-white text-white"><?php echo esc_html( $desc ); ?></p>
                    <?php } ?>
                </div>
            </div>
            <?php if(!empty( Options::$options['newsletter_shortcode'] )){ ?>
                <div class="col-lg-6">
                    <div class="newsletter-form" data-wow-duration="1s" data-wow-delay="0.6s">
                        <?php echo do_shortcode($shortcode); ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>
<!--=====================================-->
<!--=         Apps Download End         =-->
<!--=====================================-->    