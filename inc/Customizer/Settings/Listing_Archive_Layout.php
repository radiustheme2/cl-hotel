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
use RadiusTheme\CLHotel\Customizer\Controls\Separator;
use RadiusTheme\CLHotel\Customizer\Customizer;
use WP_Customize_Media_Control;
use WP_Customize_Color_Control;

/**
 * Adds the individual sections, settings, and controls to the theme customizer
 */
class Listing_Archive_Layout extends Customizer {

	public function __construct() {
        parent::instance();
        $this->populated_default_data();
        // Add Controls
        add_action( 'customize_register', array( $this, 'register_listing_layout_controls' ) );
	}

    /**
     * Blog Post Controls
     */
    public function register_listing_layout_controls( $wp_customize ) {

        // Listing grid columns
        $wp_customize->add_setting( 'listing_layout',
            array(
                'default' => $this->defaults['listing_layout'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_radio_sanitization'
            )
        );
        $wp_customize->add_control( new Image_Radio( $wp_customize, 'listing_layout',
            array(
                'label' => esc_html__( 'Layout', 'cl-hotel' ),
                'description' => esc_html__( 'Select the default template layout for Pages', 'cl-hotel' ),
                'section' => 'listing_archive_layout_section',
                'choices' => array(
                    'left-sidebar' => array(
                        'image' => trailingslashit( get_template_directory_uri() ) . 'assets/img/sidebar-left.png',
                        'name' => esc_html__( 'Left Sidebar', 'cl-hotel' )
                    ),
                    'full-width' => array(
                        'image' => trailingslashit( get_template_directory_uri() ) . 'assets/img/sidebar-full.png',
                        'name' => esc_html__( 'Full Width', 'cl-hotel' )
                    ),
                    'right-sidebar' => array(
                        'image' => trailingslashit( get_template_directory_uri() ) . 'assets/img/sidebar-right.png',
                        'name' => esc_html__( 'Right Sidebar', 'cl-hotel' )
                    )
                )
            )
        ) );

        /**
         * Separator
         */
        $wp_customize->add_setting('separator_page', array(
            'default' => '',
            'sanitize_callback' => 'esc_html',
        ));
        $wp_customize->add_control(new Separator($wp_customize, 'separator_page', array(
            'settings' => 'separator_page',
            'section' => 'listing_archive_layout_section',
        )));
        
        // Content padding top
        $wp_customize->add_setting( 'listing_padding_top',
            array(
                'default' => $this->defaults['listing_padding_top'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_sanitize_integer',
            )
        );
        $wp_customize->add_control( 'listing_padding_top',
            array(
                'label' => esc_html__( 'Padding Top', 'cl-hotel' ),
                'section' => 'listing_archive_layout_section',
                'type' => 'number',
                'description' => esc_html__( 'This is banner padding top', 'cl-hotel' ),
            )
        );
        // Content padding top
        $wp_customize->add_setting( 'listing_padding_bottom',
            array(
                'default' => $this->defaults['listing_padding_bottom'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_sanitize_integer',
            )
        );
        $wp_customize->add_control( 'listing_padding_bottom',
            array(
                'label' => esc_html__( 'Padding Bottom', 'cl-hotel' ),
                'section' => 'listing_archive_layout_section',
                'type' => 'number',
                'description' => esc_html__( 'This is banner padding bottom', 'cl-hotel' ),
            )
        );
        // Banner enable/disable option 
        $wp_customize->add_setting( 'listing_banner',
            array(
                'default' => $this->defaults['listing_banner'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_switch_sanitization',
            )
        );
        $wp_customize->add_control( new Switcher( $wp_customize, 'listing_banner',
            array(
                'label' => __( 'Banner', 'cl-hotel' ),
                'section' => 'listing_archive_layout_section',
            )
        ) );
        // Breadcrumb enable/disable option 
        $wp_customize->add_setting( 'listing_breadcrumb',
            array(
                'default' => $this->defaults['listing_breadcrumb'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_switch_sanitization',
            )
        );
        $wp_customize->add_control( new Switcher( $wp_customize, 'listing_breadcrumb',
            array(
                'label' => __( 'Breadcrumb', 'cl-hotel' ),
                'section' => 'listing_archive_layout_section',
            )
        ) );
        // Banner background image
        $wp_customize->add_setting( 'listing_bgimg',
            array(
                'default' => $this->defaults['listing_bgimg'],
                'transport' => 'refresh',
                'sanitize_callback' => 'absint',
            )
        );
        $wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'listing_bgimg',
            array(
                'label' => __( 'Banner Background Image', 'cl-hotel' ),
                'description' => esc_html__( 'This is the description for the Media Control', 'cl-hotel' ),
                'section' => 'listing_archive_layout_section',
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
        $wp_customize->add_setting('listing_bgcolor', 
            array(
                'default' => $this->defaults['listing_bgcolor'],
                'type' => 'theme_mod', 
                'capability' => 'edit_theme_options', 
                'transport' => 'refresh', 
                'sanitize_callback' => 'sanitize_hex_color',
            )
        );
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'listing_bgcolor',
            array(
                'label' => esc_html__('Banner Background Color', 'cl-hotel'),
                'settings' => 'listing_bgcolor', 
                'priority' => 10, 
                'section' => 'listing_archive_layout_section', 
            )
        ));
        
        // Banner background color opacity
        $wp_customize->add_setting( 'listing_bgopacity',
            array(
                'default' => $this->defaults['listing_bgopacity'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_sanitize_integer',
            )
        );
        $wp_customize->add_control( 'listing_bgopacity',
            array(
                'label' => esc_html__( 'Background Opacity', 'cl-hotel' ),
                'section' => 'listing_archive_layout_section',
                'type' => 'number',
            )
        );

        // Page background image
        $wp_customize->add_setting( 'listing_page_bgimg',
            array(
                'default' => $this->defaults['listing_page_bgimg'],
                'transport' => 'refresh',
                'sanitize_callback' => 'absint',
            )
        );
        $wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'listing_page_bgimg',
            array(
                'label' => __( 'Page / Post Background Image', 'cl-hotel' ),
                'description' => esc_html__( 'This is the description for the Media Control', 'cl-hotel' ),
                'section' => 'listing_archive_layout_section',
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
        
        $wp_customize->add_setting('listing_page_bgcolor', 
            array(
                'default' => $this->defaults['listing_page_bgcolor'],
                'type' => 'theme_mod', 
                'capability' => 'edit_theme_options', 
                'transport' => 'refresh', 
                'sanitize_callback' => 'sanitize_hex_color',
            )
        );
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'listing_page_bgcolor',
            array(
                'label' => esc_html__('Page / Post Background Color', 'cl-hotel'),
                'settings' => 'listing_page_bgcolor', 
                'section' => 'listing_archive_layout_section', 
            )
        ));

    }

}