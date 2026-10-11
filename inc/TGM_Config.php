<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace RadiusTheme\CLHotel;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class TGM_Config {
	
	public $base;
	public $path;
	public function __construct() {
		$this->base = 'cl-hotel';
		$this->path = Constants::$theme_plugins_dir;

		add_action( 'tgmpa_register', array( $this, 'register_required_plugins' ) );
	}

	public function register_required_plugins(){
		$plugins = array(
			// Repository
			[
                'name'     => esc_html__('Classified Listing','cl-hotel'),
                'slug'     => 'classified-listing',
                'required' => true,
            ],
			[
				'name'     => esc_html__('Elementor Page Builder','cl-hotel'),
				'slug'     => 'elementor',
				'required' => true,
			],
			[
				'name'     => esc_html__('Fluent Forms','cl-hotel'),
				'slug'     => 'fluentform',
				'required' => true,
			],
			[
				'name'     => esc_html__('Review Schema','cl-hotel'),
				'slug'     => 'review-schema',
				'required' => true,
			],
			[
				'name'     => esc_html__( 'Breadcrumb NavXT','cl-hotel' ),
				'slug'     => 'breadcrumb-navxt',
				'required' => true,
			],
			[
                'name'     => 'Classified Listing Toolkits',
                'slug'     => 'classified-listing-toolkits',
                'required' => true,
            ],
			[
				'name'      => 'Easy Demo Importer',
				'slug'      => 'easy-demo-importer',
				'required'  => false,
			],
		);

			// Bundled
			$plugins[] = [
				'name'         => esc_html__('CL Hotel Core','cl-hotel'),
				'slug'         => 'cl-hotel-core',
				'source'       => 'cl-hotel-core.2.2.0.zip',
				'required'     =>  true,
				'version'      => '2.2.0',
			];
			$plugins[] = [
				'name'         => esc_html__('RT Framework','cl-hotel'),
				'slug'         => 'rt-framework',
				'source'       => 'rt-framework-2.9.1.zip',
				'required'     =>  true,
				'version'      => '2.9.1',
			];
			$plugins[] = [
				'name'         => esc_html__('Classified Listing Pro', 'cl-hotel'),
				'slug'         => 'classified-listing-pro',
				'source'       => 'classified-listing-pro.4.2.5.zip',
				'required'     =>  true,
				'version'      => '4.2.5',
			];
			$plugins[] = [
				'name'         => 'Classified Listing Store',
				'slug'         => 'classified-listing-store',
				'source'       => 'classified-listing-store.3.2.1.zip',
				'required'     =>  true,
				'version'      => '3.2.1',
			];
			$plugins[] = [
				'name'     => 'Classified Listing – Real Estate Agent Addon',
				'slug'     => 'rtcl-agent',
				'source'   => 'rtcl-agent.zip',
				'required' => true,
				'version'  => '1.0.3',
			];
			$plugins[] = [
				'name'         => 'Booking',
				'slug'         => 'rtcl-booking',
				'source'       => 'rtcl-booking.3.1.1.zip',
				'required'     =>  false,
				'version'      => '3.1.1',
			];
			$plugins[] = [
				'name'         => esc_html__('Review Schema Pro', 'cl-hotel'),
				'slug'         => 'review-schema-pro',
				'source'       => 'review-schema-pro.2.0.1.zip',
				'required'     =>  false,
				'version'      => '2.0.1',
			];

		$config = array(
			'id'           => $this->base,            // Unique ID for hashing notices for multiple instances of TGMPA.
			'default_path' => $this->path,              // Default absolute path to bundled plugins.
			'menu'         => $this->base . '-install-plugins', // Menu slug.
			'has_notices'  => true,                    // Show admin notices or not.
			'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
			'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
			'is_automatic' => false,                    // Automatically activate plugins after installation or not.
			'message'      => '',                      // Message to output right before the plugins table.
		);

		tgmpa( $plugins, $config );
	}
}

new TGM_Config;