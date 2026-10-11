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

use RadiusTheme\CLHotel\Customizer\Controls\Switcher;
use RadiusTheme\CLHotel\Customizer\Customizer;
use WP_Customize_Media_Control;
use WP_Customize_Color_Control;
/**
 * Adds the individual sections, settings, and controls to the theme customizer
 */
class Error_Layout extends Customizer {

	public function __construct() {
        parent::instance();
        $this->populated_default_data();
        // Register Page Controls
        add_action( 'customize_register', array( $this, 'register_error_layout_controls' ) );
	}

    public function register_error_layout_controls( $wp_customize ) {
		
		// Content padding top
        $wp_customize->add_setting( 'error_padding_top',
            array(
                'default' => $this->defaults['error_padding_top'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_sanitize_integer',
            )
        );
        $wp_customize->add_control( 'error_padding_top',
            array(
                'label' => esc_html__( 'Padding Top', 'cl-hotel' ),
                'section' => 'error_layout_section',
                'type' => 'number',
                'description' => esc_html__( 'This is banner padding top.', 'cl-hotel' ),
            )
        );
        // Content padding bottom
        $wp_customize->add_setting( 'error_padding_bottom',
            array(
                'default' => $this->defaults['error_padding_bottom'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_sanitize_integer',
            )
        );
        $wp_customize->add_control( 'error_padding_bottom',
            array(
                'label' => esc_html__( 'Padding Bottom', 'cl-hotel' ),
                'section' => 'error_layout_section',
                'type' => 'number',
                'description' => esc_html__( 'This is banner padding bottom.', 'cl-hotel' ),
            )
        );
        // Banner enable/disable option
		$wp_customize->add_setting( 'error_banner',
            array(
                'default' => $this->defaults['error_banner'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_switch_sanitization',
            )
        );
        $wp_customize->add_control( new Switcher( $wp_customize, 'error_banner',
            array(
                'label' => __( 'Banner', 'cl-hotel' ),
                'section' => 'error_layout_section',
            )
        ) );
        // Breadcrumb enable/disable option 
        $wp_customize->add_setting( 'error_breadcrumb',
            array(
                'default' => $this->defaults['error_breadcrumb'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_switch_sanitization',
            )
        );
        $wp_customize->add_control( new Switcher( $wp_customize, 'error_breadcrumb',
            array(
                'label' => __( 'Breadcrumb', 'cl-hotel' ),
                'section' => 'error_layout_section',
            )
        ) );
        // Banner background image
        $wp_customize->add_setting( 'error_bgimg',
            array(
                'default' => $this->defaults['error_bgimg'],
                'transport' => 'refresh',
                'sanitize_callback' => 'absint',
            )
        );
        $wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'error_bgimg',
            array(
                'label' => __( 'Banner Background Image', 'cl-hotel' ),
                'description' => esc_html__( 'This is the description for the Media Control', 'cl-hotel' ),
                'section' => 'error_layout_section',
                'mime_type' => 'image',
                'button_labels' => array(
                    'select' => __( 'Select File', 'cl-hotel' ),
                    'change' => __( 'Change File', 'cl-hotel' ),
                    'default' => __( 'Default', 'cl-hotel' ),
                    'remove' => __( 'Remove', 'cl-hotel' ),
                    'placeholder' => __( 'No file selected', 'cl-hotel' ),
                    'frame_title' => __( 'Select File', 'cl-hotel' ),
                    'frame_button' => __( 'Choose File', 'cl-hotel' ),
                ),
            )
        ) );

        // Banner background color
        $wp_customize->add_setting('error_bgcolor', 
            array(
                'default' => $this->defaults['error_bgcolor'],
                'type' => 'theme_mod', 
                'capability' => 'edit_theme_options', 
                'transport' => 'refresh', 
                'sanitize_callback' => 'sanitize_hex_color',
            )
        );
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'error_bgcolor',
            array(
                'label' => esc_html__('Banner Background Color', 'cl-hotel'),
                'settings' => 'error_bgcolor', 
                'priority' => 10, 
                'section' => 'error_layout_section', 
            )
        ));

        // Banner background color opacity
        $wp_customize->add_setting( 'error_bgopacity',
            array(
                'default' => $this->defaults['error_bgopacity'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_sanitize_integer',
            )
        );
        $wp_customize->add_control( 'error_bgopacity',
            array(
                'label' => esc_html__( 'Background Opacity', 'cl-hotel' ),
                'section' => 'error_layout_section',
                'type' => 'number',
            )
        );
		
		// Page background image
		$wp_customize->add_setting( 'error_page_bgimg',
            array(
                'default' => $this->defaults['error_page_bgimg'],
                'transport' => 'refresh',
                'sanitize_callback' => 'absint',
            )
        );
        $wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'error_page_bgimg',
            array(
                'label' => __( 'Page / Post Background Image', 'cl-hotel' ),
                'description' => esc_html__( 'This is the description for the Media Control', 'cl-hotel' ),
                'section' => 'error_layout_section',
                'mime_type' => 'image',
                'button_labels' => array(
                    'select' => __( 'Select File', 'cl-hotel' ),
                    'change' => __( 'Change File', 'cl-hotel' ),
                    'default' => __( 'Default', 'cl-hotel' ),
                    'remove' => __( 'Remove', 'cl-hotel' ),
                    'placeholder' => __( 'No file selected', 'cl-hotel' ),
                    'frame_title' => __( 'Select File', 'cl-hotel' ),
                    'frame_button' => __( 'Choose File', 'cl-hotel' ),
                ),
            )
        ) );
		
		$wp_customize->add_setting('error_page_bgcolor', 
            array(
                'default' => $this->defaults['error_page_bgcolor'],
                'type' => 'theme_mod', 
                'capability' => 'edit_theme_options', 
                'transport' => 'refresh', 
                'sanitize_callback' => 'sanitize_hex_color',
            )
        );
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'error_page_bgcolor',
            array(
                'label' => esc_html__('Page / Post Background Color', 'cl-hotel'),
                'settings' => 'error_page_bgcolor', 
                'section' => 'error_layout_section', 
            )
        ));
        

    }

}