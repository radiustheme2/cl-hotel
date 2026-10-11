<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

use RadiusTheme\CLHotel\Options;
use RadiusTheme\CLHotel\Helper;

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

/* = Heading Typo Area
=======================================================*/
$typo_heading = json_decode( Options::$options['typo_heading'], true );
if ($typo_heading['font'] == 'Inherit') {
	$typo_heading['font'] = 'Urbanist';
} else {
	$typo_heading['font'] = $typo_heading['font'];
}

/* = Colors
=======================================================*/
$colorPrimary = Options::$options['primary_color'];
$colorPrimaryDark = Options::$options['primary_dark_color'];
$colorSecondary = Options::$options['secondary_color'];
$colorSecondaryDark = Options::$options['secondary_dark_color'];

$colorBody = Options::$options['body_color'];
$colorHeading = Options::$options['heading_color'];

?>

:root {
	--body-font: <?php echo esc_html( $typo_body['font'] ? $typo_body['font'] : 'Urbanist' ); ?>;
	--heading-font: <?php echo esc_html( $typo_heading['font'] ? $typo_heading['font'] : 'Urbanist' ); ?>;
    --color-primary: <?php echo esc_html( $colorPrimary ? $colorPrimary : '#3264FF' ); ?>;
    --color-primary-dark: <?php echo esc_html( $colorPrimaryDark ? $colorPrimaryDark : '#EAEFFF' ); ?>;
    --color-secondary: <?php echo esc_html( $colorSecondary ? $colorSecondary : '#F3F6FD' ); ?>;
    --color-secondary-dark: <?php echo esc_html( $colorSecondaryDark ? $colorSecondaryDark : '#091D39' ); ?>;
    --color-body: <?php echo esc_html( $colorBody ? $colorBody : '#576982' ); ?>;
    --color-heading: <?php echo esc_html( $colorHeading ? $colorHeading : '#0F294D' ); ?>;
	--color-white: #ffffff;
}

<?php 
//Typography Settings
get_template_part( 'dynamic-styles/typography');

?>

<?php 
	$logo_width = Options::$options['logo_width'];
	$logo_m_size = Options::$options['logo_m_size'];
?>
.site-branding a {
    width: <?php echo esc_html( $logo_width ); ?>;
}

@media only screen and (max-width: 767px) {
    .site-branding a {
		width: <?php echo esc_html( $logo_m_size ); ?>;
	}
}

<?php 
	$primaryBgColor = $colorPrimary;
	$fbg = Helper::hex2rgba($primaryBgColor, 0.8);
?>
.newsletter-form .newsletter-content .fluentform .ff_submit_btn_wrapper_custom button:hover,
.blog-comment-form .single-blog-form .form-submit .submit-btn:hover,
.rtrs-review-form .rtrs-form-group .rtrs-submit-btn:hover,
.listing-sidebar .rtcl-listing-user-info.contact-form, 
.listing-sidebar .rtclbh-block.contact-form {
    background-color: <?php echo esc_attr( $fbg ); ?>;
}

.rtcl .btn-primary.focus, 
.rtcl .btn-primary:focus, 
.rtcl .btn-primary:hover {
	border-color: <?php echo esc_attr( $fbg ); ?>;
	background-color: <?php echo esc_attr( $fbg ); ?>;
}

.listingDetails-block__rating .rtrs-summary .rtrs-progress-wrap .service-preogress[value]::-webkit-progress-value {
    background: linear-gradient(270deg, <?php echo esc_attr( $fbg ); ?> 23.5%, rgba(50, 100, 255, 0) 108.2%);
}