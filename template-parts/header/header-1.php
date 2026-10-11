<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div class="header-menu mobile-menu container-custom" id="header-menu">
    <div class="container-fluid custom-padding">
        <div class="menu-full-wrap">
            <div class="site-branding">
                <?php get_template_part( 'template-parts/header/logo', 1 ); ?>
            </div>
            <?php 
                get_template_part( 'template-parts/header/menu', 1 );
                get_template_part( 'template-parts/header/menu', 'elements' );
            ?>
        </div>
    </div>
</div>