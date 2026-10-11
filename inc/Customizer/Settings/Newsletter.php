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

use RadiusTheme\CLHotel\Customizer\Controls\Image_Radio;
use RadiusTheme\CLHotel\Customizer\Controls\Switcher;
use RadiusTheme\CLHotel\Customizer\Customizer;
use RadiusTheme\CLHotel\Helper;
use WP_Customize_Media_Control;

/**
 * Adds the individual sections, settings, and controls to the theme customizer
 */
class Newsletter extends Customizer {

	public function __construct() {
        parent::instance();
        $this->populated_default_data();
        // Add Controls
        add_action( 'customize_register', array( $this, 'register_footer_newsletter_controls' ) );
	}

    public function register_footer_newsletter_controls( $wp_customize ) {

        /* = App section on/off
        ==========================================*/
        $wp_customize->add_setting( 'footer_newsletter',
            array(
                'default' => $this->defaults['footer_newsletter'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_switch_sanitization',
            )
        );
        $wp_customize->add_control( new Switcher( $wp_customize, 'footer_newsletter',
            array(
                'label' => __( 'Newsletter Section', 'cl-hotel' ),
                'section' => 'footer_newsletter',
            )
        ) );

        /* = App Title
        ==========================================*/
        $wp_customize->add_setting( 'newsletter_title',
            array(
                'default' => $this->defaults['newsletter_title'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_text_sanitization',
            )
        );
        $wp_customize->add_control( 'newsletter_title',
            array(
                'label' => esc_html__( 'Title', 'cl-hotel' ),
                'section' => 'footer_newsletter',
                'type' => 'text',
            )
        );
        /* = App Description
        ==========================================*/
        $wp_customize->add_setting( 'newsletter_desc',
            array(
                'default' => $this->defaults['newsletter_desc'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_text_sanitization',
            )
        );
        $wp_customize->add_control( 'newsletter_desc',
            array(
                'label' => esc_html__( 'Description', 'cl-hotel' ),
                'section' => 'footer_newsletter',
                'type' => 'textarea',
            )
        );

        /* = App Description
        ==========================================*/
        $wp_customize->add_setting( 'newsletter_shortcode',
            array(
                'default' => $this->defaults['newsletter_shortcode'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_text_sanitization',
            )
        );
        $wp_customize->add_control( 'newsletter_shortcode',
            array(
                'label' => esc_html__( 'Form Shortcode', 'cl-hotel' ),
                'section' => 'footer_newsletter',
                'type' => 'textarea',
            )
        );

    }

}
