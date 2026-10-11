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
use RadiusTheme\CLHotel\Customizer\Controls\Separator;
use RadiusTheme\CLHotel\Customizer\Controls\Switcher;
use RadiusTheme\CLHotel\Customizer\Customizer;
use WP_Customize_Media_Control;
use WP_Customize_Color_Control;

/**
 * Adds the individual sections, settings, and controls to the theme customizer
 */
class Blog_Layout extends Customizer {

	public function __construct() {
	    parent::instance();
        $this->populated_default_data();
        // Add Controls
        add_action( 'customize_register', array( $this, 'register_blog_page_layout_controls' ) );
	}

    /**
     * Blog Post Controls
     */
    public function register_blog_page_layout_controls( $wp_customize ) {

        $wp_customize->add_setting( 'blog_layout',
            array(
                'default' => $this->defaults['blog_layout'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_radio_sanitization'
            )
        );
        $wp_customize->add_control( new Image_Radio( $wp_customize, 'blog_layout',
            array(
                'label' => __( 'Layout', 'cl-hotel' ),
                'description' => esc_html__( 'Select the default template layout for Pages', 'cl-hotel' ),
                'section' => 'blog_layout_section',
                'choices' => array(
                    'left-sidebar' => array(
                        'image' => trailingslashit( get_template_directory_uri() ) . 'assets/img/sidebar-left.png',
                        'name' => __( 'Left Sidebar', 'cl-hotel' )
                    ),
                    'full-width' => array(
                        'image' => trailingslashit( get_template_directory_uri() ) . 'assets/img/sidebar-full.png',
                        'name' => __( 'Full Width', 'cl-hotel' )
                    ),
                    'right-sidebar' => array(
                        'image' => trailingslashit( get_template_directory_uri() ) . 'assets/img/sidebar-right.png',
                        'name' => __( 'Right Sidebar', 'cl-hotel' )
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
            'section' => 'blog_layout_section',
        )));
        
        // Content padding top
        $wp_customize->add_setting( 'blog_padding_top',
            array(
                'default' => $this->defaults['blog_padding_top'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_sanitize_integer',
            )
        );
        $wp_customize->add_control( 'blog_padding_top',
            array(
                'label' => esc_html__( 'Padding Top', 'cl-hotel' ),
                'section' => 'blog_layout_section',
                'type' => 'number',
                'description' => esc_html__( 'This is banner padding top', 'cl-hotel' ),
            )
        );
        // Content padding top
        $wp_customize->add_setting( 'blog_padding_bottom',
            array(
                'default' => $this->defaults['blog_padding_bottom'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_sanitize_integer',
            )
        );
        $wp_customize->add_control( 'blog_padding_bottom',
            array(
                'label' => esc_html__( 'Padding Bottom', 'cl-hotel' ),
                'section' => 'blog_layout_section',
                'type' => 'number',
                'description' => esc_html__( 'This is banner padding bottom', 'cl-hotel' ),
            )
        );
        // Banner enable/disable option 
        $wp_customize->add_setting( 'blog_banner',
            array(
                'default' => $this->defaults['blog_banner'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_switch_sanitization',
            )
        );
        $wp_customize->add_control( new Switcher( $wp_customize, 'blog_banner',
            array(
                'label' => __( 'Banner', 'cl-hotel' ),
                'section' => 'blog_layout_section',
            )
        ) );
        // Breadcrumb enable/disable option 
        $wp_customize->add_setting( 'blog_breadcrumb',
            array(
                'default' => $this->defaults['blog_breadcrumb'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_switch_sanitization',
            )
        );
        $wp_customize->add_control( new Switcher( $wp_customize, 'blog_breadcrumb',
            array(
                'label' => __( 'Breadcrumb', 'cl-hotel' ),
                'section' => 'blog_layout_section',
            )
        ) );
        // Banner background image
        $wp_customize->add_setting( 'blog_bgimg',
            array(
                'default' => $this->defaults['blog_bgimg'],
                'transport' => 'refresh',
                'sanitize_callback' => 'absint',
            )
        );
        $wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'blog_bgimg',
            array(
                'label' => __( 'Banner Background Image', 'cl-hotel' ),
                'description' => esc_html__( 'This is the description for the Media Control', 'cl-hotel' ),
                'section' => 'blog_layout_section',
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
        $wp_customize->add_setting('blog_bgcolor', 
            array(
                'default' => $this->defaults['blog_bgcolor'],
                'type' => 'theme_mod', 
                'capability' => 'edit_theme_options', 
                'transport' => 'refresh', 
                'sanitize_callback' => 'sanitize_hex_color',
            )
        );
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'blog_bgcolor',
            array(
                'label' => esc_html__('Banner Background Color', 'cl-hotel'),
                'settings' => 'blog_bgcolor', 
                'priority' => 10, 
                'section' => 'blog_layout_section', 
            )
        ));
        
        // Banner background color opacity
        $wp_customize->add_setting( 'blog_bgopacity',
            array(
                'default' => $this->defaults['blog_bgopacity'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_sanitize_integer',
            )
        );
        $wp_customize->add_control( 'blog_bgopacity',
            array(
                'label' => esc_html__( 'Background Opacity', 'cl-hotel' ),
                'section' => 'blog_layout_section',
                'type' => 'number',
            )
        );

        // Page background image
        $wp_customize->add_setting( 'blog_page_bgimg',
            array(
                'default' => $this->defaults['blog_page_bgimg'],
                'transport' => 'refresh',
                'sanitize_callback' => 'absint',
            )
        );
        $wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'blog_page_bgimg',
            array(
                'label' => __( 'Page / Post Background Image', 'cl-hotel' ),
                'description' => esc_html__( 'This is the description for the Media Control', 'cl-hotel' ),
                'section' => 'blog_layout_section',
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
        
        $wp_customize->add_setting('blog_page_bgcolor', 
            array(
                'default' => $this->defaults['blog_page_bgcolor'],
                'type' => 'theme_mod', 
                'capability' => 'edit_theme_options', 
                'transport' => 'refresh', 
                'sanitize_callback' => 'sanitize_hex_color',
            )
        );
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'blog_page_bgcolor',
            array(
                'label' => esc_html__('Page / Post Background Color', 'cl-hotel'),
                'settings' => 'blog_page_bgcolor', 
                'section' => 'blog_layout_section', 
            )
        ));

    }

}