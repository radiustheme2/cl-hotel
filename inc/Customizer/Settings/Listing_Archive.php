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
use Rtcl\Helpers\Functions;

/**
 * Adds the individual sections, settings, and controls to the theme customizer
 */
class Listing_Archive extends Customizer {

	public function __construct() {
        parent::instance();
        $this->populated_default_data();
        // Add Controls
        add_action( 'customize_register', array( $this, 'register_listing_post_controls' ) );
	}

    /**
     * Portfolio Post Controls
     */
    public function register_listing_post_controls( $wp_customize ) {
        $group_list = $this->custom_field_group_list();
        
        // Listing grid columns
        $wp_customize->add_setting( 'listing_grid_cols',
            array(
                'default' => $this->defaults['listing_grid_cols'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_radio_sanitization'
            )
        );
        $wp_customize->add_control( 'listing_grid_cols',
            array(
                'label' => esc_html__( 'Grid Columns (Deprecated)', 'cl-hotel' ),
                'section' => 'listing_archive_section',
                'description' => esc_html__( 'Width is defined by the number of columns.', 'cl-hotel' ),
                'type' => 'select',
                'choices' => array(
                    '1' => esc_html__( '1 Columns', 'cl-hotel' ),
                    '2' => esc_html__( '2 Columns', 'cl-hotel' ),
                    '3' => esc_html__( '3 Columns', 'cl-hotel' ),
                    '4' => esc_html__( '4 Columns', 'cl-hotel' ),
                ),
            )
        );

        // Listing content excerpt
        $wp_customize->add_setting( 'cl_hotel_listing_excerpt',
            array(
                'default' => $this->defaults['cl_hotel_listing_excerpt'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_sanitize_integer'
            )
        );
        $wp_customize->add_control( 'cl_hotel_listing_excerpt',
            array(
                'label' => esc_html__( 'Listing Content Excerpt', 'cl-hotel' ),
                'section' => 'listing_archive_section',
                'type' => 'number'
            )
        );

        $wp_customize->add_setting( 'listing_archive_box_layout',
            array(
                'default' => $this->defaults['listing_archive_box_layout'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_radio_sanitization',
            )
        );
        $wp_customize->add_control( 'listing_archive_box_layout',
            array(
                'label' => esc_html__( 'Archive Page Layout', 'cl-hotel' ),
                'section' => 'listing_archive_section',
                'type' => 'select',
                'choices' => array(
                    'container' => esc_html__( 'Select Layout', 'cl-hotel' ),
                    'container' => esc_html__( 'Box layout', 'cl-hotel' ),
                    'container-fluid custom-padding' => esc_html__( 'Full width layout', 'cl-hotel' ),
                ),
            )
        );

        // Sidebar Custom field widget area height 1
        $wp_customize->add_setting( 'custom_fields_widget_height1',
			[
				'default'           => $this->defaults['custom_fields_widget_height1'],
				'transport'         => 'refresh',
				'sanitize_callback' => 'sanitize_text_field',
			]
		);
		$wp_customize->add_control( 'custom_fields_widget_height1',
			[
				'label'   => __( 'Custom field widget area height 1', 'cl-hotel' ),
				'section' => 'listing_archive_section',
				'type'    => 'text',
                'description' => esc_html__( 'Height 1 working after click (+ show more) button. Put only by number without px. like 150', 'cl-hotel' ),
			]
		);
        // Sidebar Custom field widget area height 2
        $wp_customize->add_setting( 'custom_fields_widget_height2',
			[
				'default'           => $this->defaults['custom_fields_widget_height2'],
				'transport'         => 'refresh',
				'sanitize_callback' => 'sanitize_text_field',
			]
		);
		$wp_customize->add_control( 'custom_fields_widget_height2',
			[
				'label'   => __( 'Custom field widget area height 2', 'cl-hotel' ),
				'section' => 'listing_archive_section',
				'type'    => 'text',
                'description' => esc_html__( 'Height 2 working after click (-Hide) button. Put only by number without px. like 270', 'cl-hotel' ),
			]
		);
    }

    public function custom_field_group_list() {
        $group_ids = Functions::get_cfg_ids();

        $list[0] = esc_html__( 'Skip Individual View', 'cl-hotel' );

        foreach ( $group_ids as $id ) {
            $list[ $id ] = get_the_title( $id );
        }

        return $list;
    }

}