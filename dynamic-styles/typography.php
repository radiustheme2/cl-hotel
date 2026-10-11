<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

use RadiusTheme\CLHotel\Options;
use RadiusTheme\CLHotel\Customizer\Default_Data;

/*-------------------------------------
	Typography Variable
-------------------------------------*/

/* = Body Typo Area
=======================================================*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$typo_body = json_decode( Options::$options['typo_body'], true );
if ($typo_body['font'] == 'Inherit') {
	$typo_body['font'] = 'Urbanist';
} else {
	$typo_body['font'] = $typo_body['font'];
}

/* = Menu Typo Area
=======================================================*/
$typo_menu = json_decode( Options::$options['typo_menu'], true );
if ($typo_menu['font'] == 'Inherit') {
	$typo_menu['font'] = 'Urbanist';
} else {
	$typo_menu['font'] = $typo_menu['font'];
}

/* = Heading Typo Area
=======================================================*/
$typo_heading = json_decode( Options::$options['typo_heading'], true );
if ($typo_heading['font'] == 'Inherit') {
	$typo_heading['font'] = 'Urbanist';
} else {
	$typo_heading['font'] = $typo_heading['font'];
}
$typo_h1 = json_decode( Options::$options['typo_h1'], true );
if ($typo_h1['font'] == 'Inherit') {
	$typo_h1['font'] = 'Urbanist';
} else {
	$typo_h1['font'] = $typo_h1['font'];
}
$typo_h2 = json_decode( Options::$options['typo_h2'], true );
if ($typo_h2['font'] == 'Inherit') {
	$typo_h2['font'] = 'Urbanist';
} else {
	$typo_h2['font'] = $typo_h2['font'];
}
$typo_h3 = json_decode( Options::$options['typo_h3'], true );
if ($typo_h3['font'] == 'Inherit') {
	$typo_h3['font'] = 'Urbanist';
} else {
	$typo_h3['font'] = $typo_h3['font'];
}
$typo_h4 = json_decode( Options::$options['typo_h4'], true );
if ($typo_h4['font'] == 'Inherit') {
	$typo_h4['font'] = 'Urbanist';
} else {
	$typo_h4['font'] = $typo_h4['font'];
}
$typo_h5 = json_decode( Options::$options['typo_h5'], true );
if ($typo_h5['font'] == 'Inherit') {
	$typo_h5['font'] = 'Urbanist';
} else {
	$typo_h5['font'] = $typo_h5['font'];
}
$typo_h6 = json_decode( Options::$options['typo_h6'], true );
if ($typo_h6['font'] == 'Inherit') {
	$typo_h6['font'] = 'Urbanist';
} else {
	$typo_h6['font'] = $typo_h6['font'];
}

/*-------------------------------------
#. Typography
---------------------------------------*/




?>

body {
	font-family: '<?php echo esc_html( $typo_body['font'] ); ?>', sans-serif;
	font-size: <?php echo esc_html( Options::$options['typo_body_size'] ) ?>;
	line-height: <?php echo esc_html( Options::$options['typo_body_height'] ); ?>;
	font-weight : <?php echo esc_html( $typo_body['regularweight'] ) ?>;
	font-style: normal;
}

.site-header .main-navigation nav ul li a {
	font-family: '<?php echo esc_html( $typo_menu['font'] ); ?>', sans-serif !important;
	font-size: <?php echo esc_html( Options::$options['typo_menu_size'] ) ?> !important;
	line-height: <?php echo esc_html( Options::$options['typo_menu_height'] ); ?> !important;
	font-weight : <?php echo esc_html( $typo_menu['regularweight'] ) ?> !important;
	font-style: normal;
}

.site-header .main-navigation ul li ul li a {
	font-family: '<?php echo esc_html( $typo_menu['font'] ); ?>', sans-serif !important;
	font-size: <?php echo esc_html( Options::$options['typo_submenu_size'] ) ?> !important;
	line-height: <?php echo esc_html( Options::$options['typo_submenu_height'] ); ?> !important;
	font-weight : <?php echo esc_html( $typo_menu['regularweight'] ) ?> !important;
	font-style: normal;
}

h1,h2,h3,h4,h5,h6 {
	font-family: '<?php echo esc_html( $typo_heading['font'] ); ?>', sans-serif !important;
	font-weight : <?php echo esc_html( $typo_heading['regularweight'] ); ?>;
}

<?php if (!empty($typo_h1['font'])) { ?>
    h1 {
        font-family: '<?php echo esc_html( $typo_h1['font'] ); ?>', sans-serif !important;
        font-weight : <?php echo esc_html( $typo_h1['regularweight'] ); ?>;
    }
<?php } ?>

h1 {
	font-size: <?php echo esc_html( Options::$options['typo_h1_size'] ); ?>;
	line-height: <?php echo esc_html(  Options::$options['typo_h1_height'] ); ?>;
	font-style: normal;
}
@media (max-width: 767px) {
	h1 {
		font-size: 42px;
		line-height: 56px;
	}
}
<?php if (!empty($typo_h2['font'])) { ?>
h2 {
	font-family: '<?php echo esc_html( $typo_h2['font'] ); ?>', sans-serif !important;
	font-weight : <?php echo esc_html( $typo_h2['regularweight'] ); ?>;
}
<?php } ?>
h2 {
	font-size: <?php echo esc_html( Options::$options['typo_h2_size'] ); ?>;
	line-height: <?php echo esc_html( Options::$options['typo_h2_height'] ); ?>;
	font-style: normal;
}
@media (max-width: 767px) {
	h2 {
		font-size: 34px;
		line-height: 46px;
	}
}
<?php if (!empty($typo_h3['font'])) { ?>
h3 {
	font-family: '<?php echo esc_html( $typo_h3['font'] ); ?>', sans-serif !important;
	font-weight : <?php echo esc_html( $typo_h3['regularweight'] ); ?>;
}
<?php } ?>
h3 {
	font-size: <?php echo esc_html( Options::$options['typo_h3_size'] ); ?>;
	line-height: <?php echo esc_html(  Options::$options['typo_h3_height'] ); ?>;
	font-style: normal;
}
@media (max-width: 767px) {
	h3 {
		font-size: 26px;
		line-height: 34px;
	}
}
<?php if (!empty($typo_h4['font'])) { ?>
h4 {
	font-family: '<?php echo esc_html( $typo_h4['font'] ); ?>', sans-serif !important;
	font-weight : <?php echo esc_html( $typo_h4['regularweight'] ); ?>;
}
<?php } ?>
h4 {
	font-size: <?php echo esc_html( Options::$options['typo_h4_size'] ); ?>;
	line-height: <?php echo esc_html(  Options::$options['typo_h4_height'] ); ?>;
	font-style: normal;
}
@media (max-width: 767px) {
	h4 {
		font-size: 22px;
		line-height: 30px;
	}
}
<?php if (!empty($typo_h5['font'])) { ?>
h5 {
	font-family: '<?php echo esc_html( $typo_h5['font'] ); ?>', sans-serif !important;
	font-weight : <?php echo esc_html( $typo_h5['regularweight'] ); ?>;
}
<?php } ?>
h5 {
	font-size: <?php echo esc_html( Options::$options['typo_h5_size'] ); ?>;
	line-height: <?php echo esc_html(  Options::$options['typo_h5_height'] ); ?>;
	font-style: normal;
}
<?php if (!empty($typo_h6['font'])) { ?>
h6 {
	font-family: '<?php echo esc_html( $typo_h6['font'] ); ?>', sans-serif !important;
	font-weight : <?php echo esc_html( $typo_h6['regularweight'] ); ?>;
}
@media (max-width: 575px) {
	h5 {
		font-size: 18px;
	}
}
<?php } ?>
h6 {
	font-size: <?php echo esc_html( Options::$options['typo_h6_size'] ); ?>;
	line-height: <?php echo esc_html(  Options::$options['typo_h6_height'] ); ?>;
	font-style: normal;
}

<?php if (!empty($typo_sub_heading['font'])) { ?>
.subheading {
	font-family: '<?php echo esc_html( $typo_sub_heading['font'] ); ?>', sans-serif !important;
	font-weight : <?php echo esc_html( $typo_sub_heading['regularweight'] ); ?>;
}
<?php } ?>