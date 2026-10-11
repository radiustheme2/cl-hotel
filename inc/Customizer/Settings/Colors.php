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

use RadiusTheme\CLHotel\Customizer\Controls\Heading;
use RadiusTheme\CLHotel\Customizer\Customizer;
use WP_Customize_Color_Control;

/**
 * Adds the individual sections, settings, and controls to the theme customizer
 */
class Colors extends Customizer {

	public function __construct() {
        parent::instance();
        $this->populated_default_data();
        // Add Controls
        add_action( 'customize_register', array( $this, 'register_general_controls' ) );
	}

    public function register_general_controls( $wp_customize ) {


        /**
        * Site Primary Color Controls
        * ==================================================================*/
        $wp_customize->add_setting( 'primary_color',
            array(
                'default' => $this->defaults['primary_color'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_text_sanitization',
            )
        );
        $wp_customize->add_control( 'primary_color',
            array(
                'label' => esc_html__( 'Primary Color', 'cl-hotel' ),
                'section' => 'site_color_section',
                'type' => 'color',
            )
        );

        /**
        * Site Primary Dark Color Controls
        * ==================================================================*/
        $wp_customize->add_setting( 'primary_dark_color',
            array(
                'default' => $this->defaults['primary_dark_color'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_text_sanitization',
            )
        );
        $wp_customize->add_control( 'primary_dark_color',
            array(
                'label' => esc_html__( 'Primary Dark Color', 'cl-hotel' ),
                'section' => 'site_color_section',
                'type' => 'color',
            )
        );

        /**
        * Site Secondary Color Controls
        * ==================================================================*/
        $wp_customize->add_setting( 'secondary_color',
            array(
                'default' => $this->defaults['secondary_color'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_text_sanitization',
            )
        );
        $wp_customize->add_control( 'secondary_color',
            array(
                'label' => esc_html__( 'Secondary Color', 'cl-hotel' ),
                'section' => 'site_color_section',
                'type' => 'color',
            )
        );

        /**
        * Site Secondary Dark Color Controls
        * ==================================================================*/
        $wp_customize->add_setting( 'secondary_dark_color',
            array(
                'default' => $this->defaults['secondary_dark_color'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_text_sanitization',
            )
        );
        $wp_customize->add_control( 'secondary_dark_color',
            array(
                'label' => esc_html__( 'Secondary Dark Color', 'cl-hotel' ),
                'section' => 'site_color_section',
                'type' => 'color',
            )
        );

        /**
        * Site Body Color Controls
        * ==================================================================*/
        $wp_customize->add_setting( 'body_color',
            array(
                'default' => $this->defaults['body_color'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_text_sanitization',
            )
        );
        $wp_customize->add_control( 'body_color',
            array(
                'label' => esc_html__( 'Body Color', 'cl-hotel' ),
                'section' => 'site_color_section',
                'type' => 'color',
            )
        );

        /**
        * Site Heading Color Controls
        * ==================================================================*/
        $wp_customize->add_setting( 'heading_color',
            array(
                'default' => $this->defaults['heading_color'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_text_sanitization',
            )
        );
        $wp_customize->add_control( 'heading_color',
            array(
                'label' => esc_html__( 'Heading Color', 'cl-hotel' ),
                'section' => 'site_color_section',
                'type' => 'color',
            )
        );

        /**
        * Normal Menu BG Color Controls
        * =================================================================*/
        $wp_customize->add_setting('menu_color_heading', array(
            'default' => '',
            'sanitize_callback' => 'esc_html',
        ));
        $wp_customize->add_control(new Heading($wp_customize, 'menu_color_heading', array(
            'label' => esc_html__( 'Menu Color', 'cl-hotel' ),
            'section' => 'menu_color_section',
        )));

        // Menu BG Color
        $wp_customize->add_setting( 'menu_bg_color',
            array(
                'default' => $this->defaults['menu_bg_color'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_text_sanitization',
            )
        );
        $wp_customize->add_control( 'menu_bg_color',
            array(
                'label' => esc_html__( 'Menu Background Color', 'cl-hotel' ),
                'section' => 'menu_color_section',
                'type' => 'color',
                'default' => '#ffffff',
            )
        );

        // Menu Text Color
        $wp_customize->add_setting( 'menu_text_color',
            array(
                'default' => $this->defaults['menu_text_color'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_text_sanitization',
            )
        );
        $wp_customize->add_control( 'menu_text_color',
            array(
                'label' => esc_html__( 'Normal Color', 'cl-hotel' ),
                'section' => 'menu_color_section',
                'type' => 'color',
                'default' => '#111111',
            )
        );
        // Menu Text Hover Color
        $wp_customize->add_setting( 'menu_text_hover_color',
            array(
                'default' => $this->defaults['menu_text_hover_color'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_text_sanitization',
            )
        );
        $wp_customize->add_control( 'menu_text_hover_color',
            array(
                'label' => esc_html__( 'Hover Color', 'cl-hotel' ),
                'section' => 'menu_color_section',
                'type' => 'color',
                'default' => '#ff3c48',
            )
        );

        /**
        * Sub Menu Color Controls
        * ======================================================================*/
        $wp_customize->add_setting('dropdown_menu_color_heading', array(
            'default' => '',
            'sanitize_callback' => 'esc_html',
        ));
        $wp_customize->add_control(new Heading($wp_customize, 'dropdown_menu_color_heading', array(
            'label' => esc_html__( 'Sub Menu Color', 'cl-hotel' ),
            'section' => 'menu_color_section',
        )));

        // Submenu BG Color
        $wp_customize->add_setting( 'submenu_bg_color',
            array(
                'default' => $this->defaults['submenu_bg_color'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_text_sanitization',
            )
        );
        $wp_customize->add_control( 'submenu_bg_color',
            array(
                'label' => esc_html__( 'Background Color', 'cl-hotel' ),
                'section' => 'menu_color_section',
                'type' => 'color',
                'default' => '#ffffff',
            )
        );

        // Submenu Text Color
        $wp_customize->add_setting( 'submenu_text_color',
            array(
                'default' => $this->defaults['submenu_text_color'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_text_sanitization',
            )
        );
        $wp_customize->add_control( 'submenu_text_color',
            array(
                'label' => esc_html__( 'Text Color', 'cl-hotel' ),
                'section' => 'menu_color_section',
                'type' => 'color',
                'default' => '#646464',
            )
        );

         // Submenu Hover Text Color
        $wp_customize->add_setting( 'submenu_htext_color',
            array(
                'default' => $this->defaults['submenu_htext_color'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_text_sanitization',
            )
        );
        $wp_customize->add_control( 'submenu_htext_color',
            array(
                'label' => esc_html__( 'Hover Text Color', 'cl-hotel' ),
                'section' => 'menu_color_section',
                'type' => 'color',
                'default' => '#ff3c48',
            )
        );
    }

}