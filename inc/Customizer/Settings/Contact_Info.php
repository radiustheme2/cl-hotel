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

use RadiusTheme\CLHotel\Customizer\Controls\Separator;
use RadiusTheme\CLHotel\Customizer\Customizer;

/**
 * Adds the individual sections, settings, and controls to the theme customizer
 */
class Contact_Info extends Customizer {

	public function __construct() {
		parent::instance();
		$this->populated_default_data();
		// Add Controls
		add_action( 'customize_register', [ $this, 'register_contact_controls' ] );
	}

	public function register_contact_controls( $wp_customize ) {
		// Phone Label
		$wp_customize->add_setting( 'contact_phone_label',
			[
				'default'           => $this->defaults['contact_phone_label'],
				'transport'         => 'refresh',
				'sanitize_callback' => 'sanitize_text_field',
			]
		);
		$wp_customize->add_control( 'contact_phone_label',
			[
				'label'   => __( 'Phone Label', 'cl-hotel' ),
				'section' => 'contact_info_section',
				'type'    => 'text',
			]
		);
		// Phone
		$wp_customize->add_setting( 'contact_phone',
			[
				'default'           => $this->defaults['contact_phone'],
				'transport'         => 'refresh',
				'sanitize_callback' => 'sanitize_text_field',
			]
		);
		$wp_customize->add_control( 'contact_phone',
			[
				'label'   => __( 'Phone Number', 'cl-hotel' ),
				'section' => 'contact_info_section',
				'type'    => 'text',
			]
		);
		// Email Label
		$wp_customize->add_setting( 'contact_email_label',
			[
				'default'           => $this->defaults['contact_email_label'],
				'transport'         => 'refresh',
				'sanitize_callback' => 'sanitize_text_field',
			]
		);
		$wp_customize->add_control( 'contact_email_label',
			[
				'label'   => __( 'Email Label', 'cl-hotel' ),
				'section' => 'contact_info_section',
				'type'    => 'text',
			]
		);
		// Email
		$wp_customize->add_setting( 'contact_email',
			[
				'default'           => $this->defaults['contact_email'],
				'transport'         => 'refresh',
				'sanitize_callback' => 'sanitize_email',
			]
		);
		$wp_customize->add_control( 'contact_email',
			[
				'label'   => __( 'Email Number', 'cl-hotel' ),
				'section' => 'contact_info_section',
				'type'    => 'email',
			]
		);
		/**
		 * Separator
		 */
		$wp_customize->add_setting( 'social_separator',
			[
				'default'           => '',
				'sanitize_callback' => 'esc_html',
			] );
		$wp_customize->add_control( new Separator( $wp_customize, 'social_separator', [
			'settings' => 'social_separator',
			'section'  => 'contact_info_section',
		] ) );
		// Social Label
		$wp_customize->add_setting( 'social_label',
			[
				'default'           => $this->defaults['social_label'],
				'transport'         => 'refresh',
				'sanitize_callback' => 'sanitize_text_field',
			]
		);
		$wp_customize->add_control( 'social_label',
			[
				'label'   => __( 'Social Lable', 'cl-hotel' ),
				'section' => 'contact_info_section',
				'type'    => 'text',
			]
		);
		// Facebook
		$wp_customize->add_setting( 'rt_facebook',
			[
				'default'           => $this->defaults['rt_facebook'],
				'transport'         => 'refresh',
				'sanitize_callback' => 'esc_url',
			]
		);
		$wp_customize->add_control( 'rt_facebook',
			[
				'label'   => __( 'Facebook Url', 'cl-hotel' ),
				'section' => 'contact_info_section',
				'type'    => 'url',
			]
		);
		// Twitter
		$wp_customize->add_setting( 'rt_twitter',
			[
				'default'           => $this->defaults['rt_twitter'],
				'transport'         => 'refresh',
				'sanitize_callback' => 'esc_url',
			]
		);
		$wp_customize->add_control( 'rt_twitter',
			[
				'label'   => __( 'Twitter Url', 'cl-hotel' ),
				'section' => 'contact_info_section',
				'type'    => 'url',
			]
		);
		// Linkedin
		$wp_customize->add_setting( 'rt_linkedin',
			[
				'default'           => $this->defaults['rt_linkedin'],
				'transport'         => 'refresh',
				'sanitize_callback' => 'esc_url',
			]
		);
		$wp_customize->add_control( 'rt_linkedin',
			[
				'label'   => __( 'Linkedin Url', 'cl-hotel' ),
				'section' => 'contact_info_section',
				'type'    => 'url',
			]
		);
		// Instagram
		$wp_customize->add_setting( 'rt_instagram',
			[
				'default'           => $this->defaults['rt_instagram'],
				'transport'         => 'refresh',
				'sanitize_callback' => 'esc_url',
			]
		);
		$wp_customize->add_control( 'rt_instagram',
			[
				'label'   => __( 'Instagram Url', 'cl-hotel' ),
				'section' => 'contact_info_section',
				'type'    => 'url',
			]
		);
		// Pinterest
		$wp_customize->add_setting( 'rt_pinterest',
			[
				'default'           => $this->defaults['rt_pinterest'],
				'transport'         => 'refresh',
				'sanitize_callback' => 'esc_url',
			]
		);
		$wp_customize->add_control( 'rt_pinterest',
			[
				'label'   => __( 'Pinterest Url', 'cl-hotel' ),
				'section' => 'contact_info_section',
				'type'    => 'url',
			]
		);
		// Youtube
		$wp_customize->add_setting( 'rt_youtube',
			[
				'default'           => $this->defaults['rt_youtube'],
				'transport'         => 'refresh',
				'sanitize_callback' => 'esc_url',
			]
		);
		$wp_customize->add_control( 'rt_youtube',
			[
				'label'   => __( 'Youtube Url', 'cl-hotel' ),
				'section' => 'contact_info_section',
				'type'    => 'url',
			]
		);
		// Tiktok 
		$wp_customize->add_setting( 'rt_tiktok',
			[
				'default'           => $this->defaults['rt_tiktok'],
				'transport'         => 'refresh',
				'sanitize_callback' => 'esc_url',
			]
		);
		$wp_customize->add_control( 'rt_tiktok',
			[
				'label'   => __( 'Tiktok Url', 'cl-hotel' ),
				'section' => 'contact_info_section',
				'type'    => 'url',
			]
		);
	}
}