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

use RadiusTheme\CLHotel\Customizer\Controls\Image_Radio;
use RadiusTheme\CLHotel\Customizer\Controls\Switcher;
use RadiusTheme\CLHotel\Customizer\Controls\Heading;
use RadiusTheme\CLHotel\Customizer\Customizer;
use RadiusTheme\CLHotel\Helper;

/**
 * Adds the individual sections, settings, and controls to the theme customizer
 */
class Footer extends Customizer {

	public function __construct() {
		parent::instance();
		$this->populated_default_data();
		// Add Controls
		add_action( 'customize_register', [ $this, 'register_footer_controls' ] );
	}

	public function register_footer_controls( $wp_customize ) {

		// Footer off & on
        $wp_customize->add_setting( 'footer_area',
			[
                'default' => $this->defaults['footer_area'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_switch_sanitization',
			]
        );
        $wp_customize->add_control( new Switcher( $wp_customize, 'footer_area',
            [
                'label' => __( 'Footer On/Off', 'cl-hotel' ),
                'section' => 'footer_all_section',
			]
        ) );

		// Footer Style
		$wp_customize->add_setting( 'footer_style',
			[
				'default'           => $this->defaults['footer_style'],
				'transport'         => 'refresh',
				'sanitize_callback' => 'rttheme_radio_sanitization',
			]
		);
		$wp_customize->add_control( new Image_Radio( $wp_customize, 'footer_style',
			[
				'label'       => esc_html__( 'Footer Layout', 'cl-hotel' ),
				'description' => esc_html__( 'Select the header style', 'cl-hotel' ),
				'section'     => 'footer_all_section',
				'choices'     => Helper::get_hf_list( 'footer' ),
			]
		) );

		/**
        * Copyright Text
        * ======================*/
        $wp_customize->add_setting( 'copyright_text',
			[
                'default' => $this->defaults['copyright_text'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_text_sanitization',
            ]
        );
        $wp_customize->add_control( 'copyright_text',
			[
                'label' => esc_html__( 'Copyright Text', 'cl-hotel' ),
                'section' => 'footer_all_section',
                'type' => 'textarea',
            ]
        );

		/**
        * Footer 1 Settiings
        * ==================================================================================================*/
        $wp_customize->add_setting('footer_widgets_area_cols', array(
            'default' => '',
            'sanitize_callback' => 'esc_html',
        ));
        $wp_customize->add_control(new Heading($wp_customize, 'footer_widgets_area_cols', array(
            'label' => esc_html__( 'Columns Settings', 'cl-hotel' ),
            'section' => 'footer_1',
        )));
        $wp_customize->add_setting( 'f1_widgets_area',
            array(
                'default' => $this->defaults['f1_widgets_area'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_radio_sanitization',
            )
        );
        $wp_customize->add_control( 'f1_widgets_area',
            array(
                'label'   => esc_html__( 'Widget Area', 'cl-hotel' ),
                'section' => 'footer_1',
                'type'    => 'select',
                'choices' => Helper::rt_grid_options(),
                'description' => esc_html__( 'Divided how many columns of footer area? Set here.', 'cl-hotel' ),
            )
        );
        $wp_customize->add_setting( 'f1_area1_column',
            array(
                'default' => $this->defaults['f1_area1_column'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_radio_sanitization',
            )
        );
        $wp_customize->add_control( 'f1_area1_column',
            array(
                'label' => esc_html__( 'Area 1 Columns', 'cl-hotel' ),
                'section' => 'footer_1',
                'type' => 'select',
                'choices' => Helper::rt_grid_options(),
                'description' => esc_html__( 'Total Columns 12', 'cl-hotel' ),
            )
        );
        $wp_customize->add_setting( 'f1_area2_column',
            array(
                'default' => $this->defaults['f1_area2_column'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_radio_sanitization',
            )
        );
        $wp_customize->add_control( 'f1_area2_column',
            array(
                'label' => esc_html__( 'Area 2 Columns', 'cl-hotel' ),
                'section' => 'footer_1',
                'type' => 'select',
                'choices' => Helper::rt_grid_options(),
                'description' => esc_html__( 'Total Columns 12', 'cl-hotel' ),
            )
        );
        $wp_customize->add_setting( 'f1_area3_column',
            array(
                'default' => $this->defaults['f1_area3_column'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_radio_sanitization',
            )
        );
        $wp_customize->add_control( 'f1_area3_column',
            array(
                'label' => esc_html__( 'Area 3 Columns', 'cl-hotel' ),
                'section' => 'footer_1',
                'type' => 'select',
                'choices' => Helper::rt_grid_options(),
                'description' => esc_html__( 'Total Columns 12', 'cl-hotel' ),
            )
        );

        $wp_customize->add_setting( 'f1_area4_column',
            array(
                'default' => $this->defaults['f1_area4_column'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_radio_sanitization',
            )
        );
        $wp_customize->add_control( 'f1_area4_column',
            array(
                'label' => esc_html__( 'Area 4 Columns', 'cl-hotel' ),
                'section' => 'footer_1',
                'type' => 'select',
                'choices' => Helper::rt_grid_options(),
                'description' => esc_html__( 'Total Columns 12', 'cl-hotel' ),
            )
        );

		$wp_customize->add_setting( 'f1_area5_column',
			array(
				'default' => $this->defaults['f1_area5_column'],
				'transport' => 'refresh',
				'sanitize_callback' => 'rttheme_radio_sanitization',
			)
		);
		$wp_customize->add_control( 'f1_area5_column',
			array(
				'label' => esc_html__( 'Area 5 Columns', 'cl-hotel' ),
				'section' => 'footer_1',
				'type' => 'select',
				'choices' => Helper::rt_grid_options(),
				'description' => esc_html__( 'Total Columns 12', 'cl-hotel' ),
			)
		);

		$wp_customize->add_setting( 'f1_area6_column',
			array(
				'default' => $this->defaults['f1_area6_column'],
				'transport' => 'refresh',
				'sanitize_callback' => 'rttheme_radio_sanitization',
			)
		);
		$wp_customize->add_control( 'f1_area6_column',
			array(
				'label' => esc_html__( 'Area 6 Columns', 'cl-hotel' ),
				'section' => 'footer_1',
				'type' => 'select',
				'choices' => Helper::rt_grid_options(),
				'description' => esc_html__( 'Total Columns 12', 'cl-hotel' ),
			)
		);
	}
}