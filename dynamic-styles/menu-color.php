<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

use RadiusTheme\CLHotel\Options;

/*-------------------------------------
#. Evacon Color Settings
---------------------------------------*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Transparent Menu Color
$menu_text_color = Options::$options['menu_text_color'];
$menu_text_hover_color = Options::$options['menu_text_hover_color'];
$menu_line_bg_color = Options::$options['menu_line_bg_color'];
// Sub Menu Color
$submenu_bg_color = Options::$options['submenu_bg_color'];
$submenu_text_color = Options::$options['submenu_text_color'];
$submenu_htext_color = Options::$options['submenu_htext_color'];
// Sticky Menu Color
$sticky_menu_bg_color = Options::$options['sticky_menu_bg_color'];
$sticky_menu_text_color = Options::$options['sticky_menu_text_color'];

// Non Transparent Menu Color
$menu2_bg_color = Options::$options['menu2_bg_color'];
$menu2_text_color = Options::$options['menu2_text_color'];
$menu2_text_hover_color = Options::$options['menu2_text_hover_color'];
$menu2_line_bg_color = Options::$options['menu2_line_bg_color'];
// Sub Menu Color
$submenu2_bg_color = Options::$options['submenu2_bg_color'];
$submenu2_text_color = Options::$options['submenu2_text_color'];
$submenu2_htext_color = Options::$options['submenu2_htext_color'];
$header3_fullbd_color = Options::$options['header3_fullbd_color'];
// Toggle BG Color
$toggle_bg_color = Options::$options['toggle_bg_color'];
$toggle_text_color = Options::$options['toggle_text_color'];

?>


<?php
/* = Transparent Menu Color
============================================================= */
?>
<?php
	/* = Evacon Menu Color
	==============================================*/
	if ( !empty( $menu_text_color )) {
?>
nav.template-main-menu>ul>li>a {
	color: <?php echo esc_html( $menu_text_color ); ?>;
}
<?php } if ( !empty( $menu_text_hover_color )) { ?>
nav.template-main-menu>ul>li>a:hover {
	color: <?php echo esc_html( $menu_text_hover_color ); ?>;
}
nav.template-main-menu>ul.main-menu>li>a:before {
	background-color: <?php echo esc_html( $menu_line_bg_color ); ?> !important;
}
<?php }
	if ( !empty( $submenu_bg_color )) {
	/* = Evacon Dropdown Menu Color
	==============================================*/
?>
	nav.template-main-menu>ul.main-menu>li>ul.sub-menu>li>ul.sub-menu,
	nav.template-main-menu>ul.main-menu>li>ul.sub-menu {
		background-color: <?php echo esc_html( $submenu_bg_color ); ?>;
	}
<?php } if ( !empty( $submenu_text_color )) { ?>
	nav.template-main-menu>ul.main-menu>li>ul.sub-menu>li>ul.sub-menu>li>a,
	nav.template-main-menu>ul.main-menu>li>ul.sub-menu>li>a {
		color: <?php echo esc_html( $submenu_text_color ); ?>;
	}
<?php } if ( !empty( $submenu_htext_color )) { ?>
	nav.template-main-menu>ul.main-menu>li>ul.sub-menu>li>ul.sub-menu>li.active>a, 
	nav.template-main-menu>ul.main-menu>li>ul.sub-menu>li>ul.sub-menu>li:hover>a, 
	nav.template-main-menu>ul.main-menu>li>ul.sub-menu>li:hover>a {
		color: <?php echo esc_html( $submenu_htext_color ); ?>;
	}
	nav.template-main-menu>ul.main-menu>li>ul.sub-menu>li>ul.sub-menu>li>a:before,
	nav.template-main-menu>ul.main-menu>li>ul.sub-menu>li>a:before {
		background-color: <?php echo esc_html( $submenu_htext_color ); ?>;
	}
<?php }
	if ( !empty( $sticky_menu_bg_color )) {
	/* = Evacon Sticky Menu Color
	==============================================*/
?>
	.header1.sticky-on.sticky-header .navbar-wrap .header-menu {
		background-color: <?php echo esc_html( $sticky_menu_bg_color ); ?>;
	}
<?php }
	if ( !empty( $sticky_menu_text_color )) {
	/* = Evacon Sticky Menu Color
	==============================================*/
?>
	.sticky-on.sticky-header nav.template-main-menu > ul.main-menu > li > a {
		color: <?php echo esc_html( $sticky_menu_text_color ); ?>;
	}
<?php } ?>


<?php
/* = Non Transparent Menu Color
============================================================= */
?>
<?php
	/* = Evacon Menu 2 Color
	==============================================*/
	if ( !empty( $menu2_bg_color )) {
?>
	.header2.trheader .navbar-wrap .header-menu .inner-wrap:before,
	.header2.trheader .navbar-wrap .header-menu .inner-wrap,
	.header3:not(.trheader) .navbar-wrap .header-menu {
		background-color: <?php echo esc_html( $menu2_bg_color ); ?>;
	}
<?php }
	/* = Evacon Menu 2 Color
	==============================================*/
	if ( !empty( $menu2_text_color )) {
?>
	.header2.trheader nav.template-main-menu ul.main-menu > li > a,
	.header3 nav.template-main-menu ul.main-menu > li > a {
		color: <?php echo esc_html( $menu2_text_color ); ?> !important;
	}
<?php } if ( !empty( $menu2_text_hover_color )) { ?>
	.header2.trheader nav.template-main-menu ul.main-menu > li > a:hover,
	.header3 nav.template-main-menu ul.main-menu > li > a:hover {
		color: <?php echo esc_html( $menu2_text_hover_color ); ?> !important;
	}
<?php } if ( !empty( $menu2_line_bg_color )) { ?>
	.header2.trheader nav.template-main-menu>ul.main-menu>li>a:before,
	.header3 nav.template-main-menu>ul.main-menu>li>a:before {
		background-color: <?php echo esc_html( $menu2_line_bg_color ); ?> !important;
	}
<?php }
	if ( !empty( $submenu2_bg_color )) {
	/* = Evacon Dropdown Menu 2 Color
	==============================================*/
?>
	.header3 nav.template-main-menu>ul.main-menu>li>ul.sub-menu>li>ul.sub-menu,
	.header3 nav.template-main-menu>ul.main-menu>li>ul.sub-menu,
	.header2 nav.template-main-menu>ul.main-menu>li>ul.sub-menu>li>ul.sub-menu,
	.header2 nav.template-main-menu>ul.main-menu>li>ul.sub-menu {
		background-color: <?php echo esc_html( $submenu2_bg_color ); ?>;
	}
<?php } if ( !empty( $submenu2_text_color )) { ?>
	.header3 nav.template-main-menu>ul.main-menu>li>ul.sub-menu>li>ul.sub-menu>li>a,
	.header3 nav.template-main-menu>ul.main-menu>li>ul.sub-menu>li>a,
	.header2 nav.template-main-menu>ul.main-menu>li>ul.sub-menu>li>ul.sub-menu>li>a,
	.header2 nav.template-main-menu>ul.main-menu>li>ul.sub-menu>li>a {
		color: <?php echo esc_html( $submenu2_text_color ); ?>;
	}
<?php } if ( !empty( $submenu2_htext_color )) { ?>
	.header3 nav.template-main-menu>ul.main-menu>li>ul.sub-menu>li>ul.sub-menu>li.active>a, 
	.header3 nav.template-main-menu>ul.main-menu>li>ul.sub-menu>li>ul.sub-menu>li:hover>a, 
	.header3 nav.template-main-menu>ul.main-menu>li>ul.sub-menu>li:hover>a,
	.header2 nav.template-main-menu>ul.main-menu>li>ul.sub-menu>li>ul.sub-menu>li.active>a, 
	.header2 nav.template-main-menu>ul.main-menu>li>ul.sub-menu>li>ul.sub-menu>li:hover>a, 
	.header2 nav.template-main-menu>ul.main-menu>li>ul.sub-menu>li:hover>a {
		color: <?php echo esc_html( $submenu2_htext_color ); ?>;
	}
	.header3 nav.template-main-menu>ul.main-menu>li>ul.sub-menu>li>ul.sub-menu>li>a:before,
	.header3 nav.template-main-menu>ul.main-menu>li>ul.sub-menu>li>a:before,
	.header2 nav.template-main-menu>ul.main-menu>li>ul.sub-menu>li>ul.sub-menu>li>a:before,
	.header2 nav.template-main-menu>ul.main-menu>li>ul.sub-menu>li>a:before {
		background-color: <?php echo esc_html( $submenu2_htext_color ); ?>;
	}

<?php } if ( !empty( $header3_fullbd_color )) { 
	/* = Header 3 full background color
	==============================================*/
	?>
	.header3 .navbar-wrap .header-menu:before,
	.header3 .navbar-wrap .site-branding {
		background-color: <?php echo esc_html( $header3_fullbd_color ); ?>;
	}
<?php } ?>

<?php
/* = Toggle Color
==============================================*/
	if ( !empty( $toggle_bg_color )) {
	/* = Toggle Color
	==============================================*/
	?>
	.offcanvas-menu-wrap {
		background-color: <?php echo esc_html( $toggle_bg_color ); ?>;
	}
<?php } if ( !empty( $toggle_bg_color )) { ?>
	.offcanvas-content .top-content .toggle-desc, 
	.offcanvas-content .top-content p,
	.offcanvas-header .header-text,
	.offcanvas-content .sub-title,
	.offcanvas-content .info li,
	.offcanvas-footer ul li a,
	.offcanvas-content h2 {
		color: <?php echo esc_html( $toggle_text_color ); ?>;
	}
	button.offcanvas-menu-btn.menu-status-close .menu-btn-icon span {
		background-color: <?php echo esc_html( $toggle_text_color ); ?>;
	}
<?php } ?>