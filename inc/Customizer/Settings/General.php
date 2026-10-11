<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace RadiusTheme\CLHotel\Customizer\Settings;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use RadiusTheme\CLHotel\Customizer\Controls\Separator;
use RadiusTheme\CLHotel\Customizer\Controls\Switcher;
use RadiusTheme\CLHotel\Customizer\Controls\Heading;
use RadiusTheme\CLHotel\Customizer\Customizer;
use RadiusTheme\CLHotel\Helper;
use WP_Customize_Media_Control;

/**
 * Adds the individual sections, settings, and controls to the theme customizer
 */
class General extends Customizer {

	public function __construct() {
		parent::instance();
		$this->populated_default_data();
		// Add Controls
		add_action( 'customize_register', [ $this, 'register_general_controls' ] );
	}

	public function register_general_controls( $wp_customize ) {
		// Main Logo
		$wp_customize->add_setting( 'logo_one',
			[
				'default'           => $this->defaults['logo_one'],
				'transport'         => 'refresh',
				'sanitize_callback' => 'absint',
			]
		);
		$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'logo_one',
			[
				'label'         => esc_html__( 'Logo', 'cl-hotel' ),
				'description'   => esc_html__( 'Add site main logo', 'cl-hotel' ),
				'section'       => 'general_logo',
				'mime_type'     => 'image',
				'button_labels' => [
					'select'       => esc_html__( 'Select Logo', 'cl-hotel' ),
					'change'       => esc_html__( 'Change Logo', 'cl-hotel' ),
					'default'      => esc_html__( 'Default', 'cl-hotel' ),
					'remove'       => esc_html__( 'Remove', 'cl-hotel' ),
					'placeholder'  => esc_html__( 'No file selected', 'cl-hotel' ),
					'frame_title'  => esc_html__( 'Select File', 'cl-hotel' ),
					'frame_button' => esc_html__( 'Choose File', 'cl-hotel' ),
				],
			]
		) );

		$wp_customize->selective_refresh->add_partial( 'logo_one', [
			'selector'        => '.site-logo',
			'render_callback' => '__return_false',
		] );

		// Logo Width
		$wp_customize->add_setting( 'logo_width',
			[
				'default'           => $this->defaults['logo_width'],
				'transport'         => 'refresh',
				'sanitize_callback' => 'rttheme_text_sanitization',
			]
		);
		$wp_customize->add_control( 'logo_width',
			[
				'label'           => esc_html__( 'Logo max width', 'cl-hotel' ),
				'section'         => 'general_logo',
				'type'            => 'text',
				'description'     => esc_html__( 'Enter logo width. Eg: 200px', 'cl-hotel' ),
				'input_attrs'     => [
					'placeholder' => esc_html__( '200px', 'cl-hotel' ),
				],
			]
		);
		// Logo Mobile Width
		$wp_customize->add_setting( 'logo_m_size',
			[
				'default'           => $this->defaults['logo_m_size'],
				'transport'         => 'refresh',
				'sanitize_callback' => 'rttheme_text_sanitization',
			]
		);
		$wp_customize->add_control( 'logo_m_size',
			[
				'label'           => esc_html__( 'Logo max width', 'cl-hotel' ),
				'section'         => 'general_logo',
				'type'            => 'text',
				'description'     => esc_html__( 'Enter logo mobile width. Eg: 120px', 'cl-hotel' ),
				'input_attrs'     => [
					'placeholder' => esc_html__( '120px', 'cl-hotel' ),
				],
			]
		);

		// Separator
		$wp_customize->add_setting( 'separator_general1', [
			'default'           => '',
			'sanitize_callback' => 'esc_html',
		] );
		$wp_customize->add_control( new Separator( $wp_customize, 'separator_general1', [
			'settings' => 'separator_general1',
			'section'  => 'general_section',
		] ) );

		// Banner Image
		$wp_customize->add_setting( 'banner_image',
			[
				'default'           => $this->defaults['banner_image'],
				'transport'         => 'refresh',
				'sanitize_callback' => 'absint',
			]
		);
		$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'banner_image',
			[
				'label'         => esc_html__( 'Banner Image', 'cl-hotel' ),
				'description'   => esc_html__( 'Add banner image to change default image', 'cl-hotel' ),
				'section'       => 'general_section',
				'mime_type'     => 'image',
				'button_labels' => [
					'select'       => esc_html__( 'Select Image', 'cl-hotel' ),
					'change'       => esc_html__( 'Change Image', 'cl-hotel' ),
					'default'      => esc_html__( 'Default', 'cl-hotel' ),
					'remove'       => esc_html__( 'Remove', 'cl-hotel' ),
					'placeholder'  => esc_html__( 'No file selected', 'cl-hotel' ),
					'frame_title'  => esc_html__( 'Select File', 'cl-hotel' ),
					'frame_button' => esc_html__( 'Choose File', 'cl-hotel' ),
				],
			]
		) );

		/**
         * Heading
         */
        $wp_customize->add_setting('site_switching', array(
            'default' => '',
            'sanitize_callback' => 'esc_html',
        ));
        $wp_customize->add_control(new Heading($wp_customize, 'site_switching', array(
            'label' => esc_html__( 'Site Switch Control', 'cl-hotel' ),
            'section' => 'general_switcher',
        )));
		// Back to top
		$wp_customize->add_setting( 'preloader',
			[
				'default'           => $this->defaults['preloader'],
				'transport'         => 'refresh',
				'sanitize_callback' => 'rttheme_switch_sanitization',
			]
		);
		$wp_customize->add_control( new Switcher( $wp_customize, 'preloader',
			[
				'label'   => esc_html__( 'Preloader', 'cl-hotel' ),
				'section' => 'general_switcher',
			]
		) );

		// 1. Add setting preloader image
		$wp_customize->add_setting( 'preloader_image', [
			'default'           => '',
			'transport'         => 'refresh',
			'sanitize_callback' => 'esc_url_raw',
		] );

		$wp_customize->add_control(
			new \WP_Customize_Image_Control( // note the leading backslash (global class)
				$wp_customize,
				'preloader_image',
				[
					'label'    => esc_html__( 'Preloader Image', 'cl-hotel' ),
					'section'  => 'general_switcher',
					'settings' => 'preloader_image',
				]
			)
		);

		// Header login button text
        $wp_customize->add_setting( 'page_loader_text',
			[
				'default'           => $this->defaults['page_loader_text'],
				'transport'         => 'refresh',
				'sanitize_callback' => 'sanitize_text_field',
			]
		);
		$wp_customize->add_control( 'page_loader_text',
			[
				'label'   => __( 'Page Loader Text', 'cl-hotel' ),
				'section' => 'general_switcher',
				'type'    => 'text',
			]
		);

		// Back to top
		$wp_customize->add_setting( 'back_to_top',
			[
				'default'           => $this->defaults['back_to_top'],
				'transport'         => 'refresh',
				'sanitize_callback' => 'rttheme_switch_sanitization',
			]
		);
		$wp_customize->add_control( new Switcher( $wp_customize, 'back_to_top',
			[
				'label'   => esc_html__( 'Back to Top', 'cl-hotel' ),
				'section' => 'general_switcher',
			]
		) );
		
		// Switch for custom cursor
        $wp_customize->add_setting( 'sticky_header',
            [
                'default' => $this->defaults['sticky_header'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_switch_sanitization',
            ]
        );
        $wp_customize->add_control( new Switcher( $wp_customize, 'sticky_header',
            [
                'label' => esc_html__( 'Sticky Header', 'cl-hotel' ),
                'section' => 'general_switcher',
			]
        ) );

	}

}
