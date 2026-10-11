<?php
/**
 * @author  RadiusTheme
 * @since   1.0.1
 * @version 1.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Includes the files needed for the theme updater
if ( !class_exists( 'EDD_Theme_Updater_Admin' ) ) {
	include( dirname( __FILE__ ) . '/theme-updater-admin.php' );
}

add_action( 'after_setup_theme', 'rdtheme_edd_theme_updater', 20 );

function rdtheme_edd_theme_updater(){
	$theme_data = wp_get_theme( get_template() );

	// Config settings 199375 
	$config = array(
		'remote_api_url' => 'https://www.radiustheme.com', // Site where EDD is hosted
		'item_id'        => 229721, // ID of item in site where EDD is hosted
		'theme_slug'     => '_rt_cl-hotel', // Theme slug
		'version'        => $theme_data->get( 'Version' ), // The current version of this theme
		'author'         => $theme_data->get( 'Author' ), // The author of this theme
		'download_id'    => '', // Optional, used for generating a license renewal link
		'renew_url'      => '' // Optional, allows for a custom license renewal link
	);

	// Strings
	$strings = array(
		'theme-license'             => __( 'Theme License', 'cl-hotel' ),
		'enter-key'                 => __( 'Enter your theme license key.', 'cl-hotel' ),
		'license-key'               => __( 'License Key', 'cl-hotel' ),
		'license-action'            => __( 'License Action', 'cl-hotel' ),
		'deactivate-license'        => __( 'Deactivate License', 'cl-hotel' ),
		'activate-license'          => __( 'Activate License', 'cl-hotel' ),
		'status-unknown'            => __( 'License status is unknown.', 'cl-hotel' ),
		'renew'                     => __( 'Renew?', 'cl-hotel' ),
		'unlimited'                 => __( 'unlimited', 'cl-hotel' ),
		'license-key-is-active'     => __( 'License key is active.', 'cl-hotel' ),
		/* translators: %s: expiration date */
	'expires%s'                 => __( 'Expires %s.', 'cl-hotel' ),
		/* translators: 1: number of active sites, 2: total allowed sites */
	'%1$s/%2$-sites'            => __( 'You have %1$s / %2$s sites activated.', 'cl-hotel' ),
		/* translators: %s: expiration date */
	'license-key-expired-%s'    => __( 'License key expired %s.', 'cl-hotel' ),
		'license-key-expired'       => __( 'License key has expired.', 'cl-hotel' ),
		'license-keys-do-not-match' => __( 'License keys do not match.', 'cl-hotel' ),
		'license-is-inactive'       => __( 'License is inactive.', 'cl-hotel' ),
		'license-key-is-disabled'   => __( 'License key is disabled.', 'cl-hotel' ),
		'site-is-inactive'          => __( 'Site is inactive.', 'cl-hotel' ),
		'license-status-unknown'    => __( 'License status is unknown.', 'cl-hotel' ),
		'update-notice'             => __( "Updating this theme will lose any customizations you have made. 'Cancel' to stop, 'OK' to update.", 'cl-hotel' ),
		/* translators: 1: Theme name, 2: Version, 3: Changelog URL, 4: Changelog title, 5: Update URL, 6: Update onclick */
	'update-available'          => __('<strong>%1$s %2$s</strong> is available. <a href="%3$s" class="thickbox" title="%4$s">Check out what\'s new</a> or <a href="%5$s"%6$s>update now</a>.', 'cl-hotel' )
	);

	// Loads the updater classes
	global $obitore_edd_updater;
	$obitore_edd_updater = new EDD_Theme_Updater_Admin( $config, $strings );
}
