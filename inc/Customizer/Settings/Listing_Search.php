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

use Rtcl\Helpers\Functions;
use RadiusTheme\CLHotel\Customizer\Customizer;
use RadiusTheme\CLHotel\Customizer\Controls\Heading;
use RadiusTheme\CLHotel\Customizer\Controls\Checkbox_Multiple;

/**
 * Adds the individual sections, settings, and controls to the theme customizer
 */
class Listing_Search extends Customizer {

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

        // Listing Banner Search Items
        $wp_customize->add_setting('banner_search', array(
            'default' => '',
            'sanitize_callback' => 'esc_html',
        ));
        $wp_customize->add_control(new Heading($wp_customize, 'banner_search', array(
            'label' => esc_html__( 'Banner Search', 'cl-hotel' ),
            'section' => 'listing_search_section',
        )));

        $wp_customize->add_setting( 'listing_banner_search_items', 
            array(
                'default'           => $this->defaults['listing_banner_search_items'],
                'transport'         => 'refresh',
                'sanitize_callback' => 'sanitize_multiple_checkbox',
            ) 
        );
        $wp_customize->add_control( new Checkbox_Multiple( $wp_customize, 'listing_banner_search_items', 
            array(
                'label'    => __( 'Search Elements', 'cl-hotel' ),
                'description'    => __( 'Select style which you want.', 'cl-hotel' ),
                'section'  => 'listing_search_section',
                'type'  => 'checkbox-multiple',
                'choices'  => array(
                    'keyword'   => 'Keyword',
                    'location'  => 'Location',
                    'category'  => 'Category',
                ),
            ) 
        ) );

        // Listing Search Banner
        $wp_customize->add_setting( 'listing_banner_search_style',
        array(
            'default' => $this->defaults['listing_banner_search_style'],
            'transport' => 'refresh',
            'sanitize_callback' => 'rttheme_radio_sanitization'
        )
        );
        $wp_customize->add_control( 'listing_banner_search_style',
            array(
                'label'    => esc_html__( 'Listing Search Type', 'cl-hotel' ),
                'section' => 'listing_search_section',
                'description'    => esc_html__( 'Listing Search style.', 'cl-hotel' ),
                'type' => 'select',
                'choices'  => array(
                    'popup'      => esc_html__( 'Popup', 'cl-hotel' ),
                    'standard'   => esc_html__( 'Standard', 'cl-hotel' ),
                    'suggestion' => esc_html__( 'Auto Suggestion', 'cl-hotel' ),
                    'dependency' => esc_html__( 'Dependency Selection', 'cl-hotel' ),
                ),
            )
        );        
        
        // Map Search custom advanced fields
        $wp_customize->add_setting('map_search', array(
            'default' => '',
            'sanitize_callback' => 'esc_html',
        ));
        $wp_customize->add_control(new Heading($wp_customize, 'map_search', array(
            'label' => esc_html__( 'Filter Widget', 'cl-hotel' ),
            'section' => 'listing_search_section',
        )));

        $wp_customize->add_setting( 'custom_fields_search_items', 
            array(
                'default'           => $this->defaults['custom_fields_search_items'],
                'transport'         => 'refresh',
                'sanitize_callback' => 'sanitize_multiple_checkbox',
            ) 
        );
        $wp_customize->add_control( new Checkbox_Multiple( $wp_customize, 'custom_fields_search_items', 
            array(
                'label'    => __( 'Custom Fileds', 'cl-hotel' ),
                'description'    => __( 'Select which type you want to display in filter search.', 'cl-hotel' ),
                'section'  => 'listing_search_section',
                'type'  => 'checkbox-multiple',
                'choices'  => $group_list,
            ) 
        ) );

        $wp_customize->add_setting( 'listing_price_search_type',
        array(
            'default' => $this->defaults['listing_price_search_type'],
            'transport' => 'refresh',
            'sanitize_callback' => 'rttheme_radio_sanitization'
        )
        );
        $wp_customize->add_control( 'listing_price_search_type',
            array(
                'label'    => esc_html__( 'Price Search Type', 'cl-hotel' ),
                'section' => 'listing_search_section',
                'description'    => esc_html__( '2 price search are available, they are input box and range slider.', 'cl-hotel' ),
                'type' => 'select',
                'choices'  => array(
                    'input' => 'Input Search',
                    'range' => 'Range Search',
                ),
            )
        );

    }

    public function custom_field_group_list() {
        $list = [];
        $group_ids = Functions::get_cfg_ids();
        foreach ( $group_ids as $id ) {
            $list[ $id ] = get_the_title( $id );
        }
        return $list;
    }

}