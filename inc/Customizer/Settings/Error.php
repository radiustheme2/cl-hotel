<?php
/**
 * @author  RadiusTheme
 * @since   1.0.0
 * @version 1.0.0
 */

namespace RadiusTheme\CLHotel\Customizer\Settings;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use RadiusTheme\CLHotel\Customizer\Customizer;
use WP_Customize_Media_Control;

/**
 * Adds the individual sections, settings, and controls to the theme customizer
 */
class Error extends Customizer {

	public function __construct() {
		parent::instance();
		$this->populated_default_data();
		// Add Controls
		add_action( 'customize_register', [ $this, 'register_error_controls' ] );
	}

	public function register_error_controls( $wp_customize ) {
		$wp_customize->add_setting( 'error_bg_img',
			[
				'default'           => $this->defaults['error_bg_img'],
				'transport'         => 'refresh',
				'sanitize_callback' => 'absint',
			]
		);
		$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'error_bg_img',
			[
				'label'         => esc_html__( 'Featured Image', 'cl-hotel' ),
				'section'       => 'error_section',
				'mime_type'     => 'image',
				'button_labels' => [
					'select'       => esc_html__( 'Select File', 'cl-hotel' ),
					'change'       => esc_html__( 'Change File', 'cl-hotel' ),
					'default'      => esc_html__( 'Default', 'cl-hotel' ),
					'remove'       => esc_html__( 'Remove', 'cl-hotel' ),
					'placeholder'  => esc_html__( 'No file selected', 'cl-hotel' ),
					'frame_title'  => esc_html__( 'Select File', 'cl-hotel' ),
					'frame_button' => esc_html__( 'Choose File', 'cl-hotel' ),
				],
			]
		) );

		// Error Page Breadcrumb Title
		$wp_customize->add_setting( 'error_page_breadcrumb_title',
			[
				'default'           => $this->defaults['error_page_breadcrumb_title'],
				'transport'         => 'refresh',
				'sanitize_callback' => 'wp_kses_post',
			]
		);
		$wp_customize->add_control( 'error_page_breadcrumb_title',
			[
				'label'   => esc_html__( 'Error page breadcrumb title', 'cl-hotel' ),
				'section' => 'error_section',
				'type'    => 'text',
			]
		);

		// Error Page
		$wp_customize->add_setting( 'error_page_title',
			[
				'default'           => $this->defaults['error_page_title'],
				'transport'         => 'refresh',
				'sanitize_callback' => 'wp_kses_post',
			]
		);
		$wp_customize->add_control( 'error_page_title',
			[
				'label'   => esc_html__( 'Error page title', 'cl-hotel' ),
				'section' => 'error_section',
				'type'    => 'text',
			]
		);

		// Error Sub-title
		$wp_customize->add_setting( 'error_page_desc',
			[
				'default'           => $this->defaults['error_page_desc'],
				'transport'         => 'refresh',
				'sanitize_callback' => 'wp_kses_post',
			]
		);
		$wp_customize->add_control( 'error_page_desc',
			[
				'label'   => esc_html__( 'Error description', 'cl-hotel' ),
				'section' => 'error_section',
				'type'    => 'textarea',
			]
		);

		// Button Text
		$wp_customize->add_setting( 'error_buttontext',
			[
				'default'           => $this->defaults['error_buttontext'],
				'transport'         => 'refresh',
				'sanitize_callback' => 'rttheme_text_sanitization',
			]
		);
		$wp_customize->add_control( 'error_buttontext',
			[
				'label'   => esc_html__( 'Button Text', 'cl-hotel' ),
				'section' => 'error_section',
				'type'    => 'text',
			]
		);
	}
}