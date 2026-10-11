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
use \Rtcl\Helpers\Functions;

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="profile" href="https://gmpg.org/xfn/11" />
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <?php 
        if (Options::$options['preloader']) {
            do_action('site_prealoader');
        }
    ?>
    <?php
        $sticky_header = '';
        $header_style = Options::$header_style ? Options::$header_style : 1;
        $header_sticky = Options::$options['sticky_header'];
        if ($header_sticky) {
            $sticky = 'sticky-on';
        } else {
            $sticky = 'sticky-off';
        }

        if ( Options::$options['sticky_header'] == 1 ) {
            $sticky_header = 'headroom-sticky-header';
        }
    ?>

    <div id="wrapper" class="wrapper">
        
        <?php 
            if ( Options::$header_top == '1' || Options::$header_top === "on" ) {
                get_template_part( 'template-parts/header/header', 'top' );
            }
            if ( Options::$header_area == '1' || Options::$header_area === "on" ) { 
        ?>
            <header id="masthead" class="site-header <?php // echo esc_attr( $sticky_header ); ?> headroom-sticky-header header--fixed headroom">
                <div id="header-<?php echo esc_attr( $header_style ); ?>" class="header-area">
                    <?php get_template_part('template-parts/header/header', $header_style ); ?>
                </div>
            </header>
            
            <?php get_template_part('template-parts/header/mobile', 'menu'); ?>
        <?php }
            if ( Options::$has_banner == '1' || Options::$has_banner === "on" ) {
                get_template_part( 'template-parts/content', 'banner' );
            }
        ?>