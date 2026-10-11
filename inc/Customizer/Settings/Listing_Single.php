<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0.5
 */
namespace RadiusTheme\CLHotel\Customizer\Settings;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use RadiusTheme\CLHotel\Customizer\Controls\Checkbox_Multiple;
use RadiusTheme\CLHotel\Customizer\Controls\Switcher;
use RadiusTheme\CLHotel\Customizer\Controls\Heading;
use RadiusTheme\CLHotel\Customizer\Customizer;

use Rtcl\Helpers\Functions;
use Rtcl\Models\RtclCFGField;

/**
 * Adds the individual sections, settings, and controls to the theme customizer
 */
class Listing_Single extends Customizer {

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
        $fields_list = $this->custom_fields_list();

        /**
         * Heading for listing details
         * ================================================================================================*/
        $wp_customize->add_setting('listing_details_heading', array(
            'default' => '',
            'sanitize_callback' => 'esc_html',
        ));
        $wp_customize->add_control(new Heading($wp_customize, 'listing_details_heading', array(
            'label' => esc_html__( 'Listing Details', 'cl-hotel' ),
            'section' => 'listing_details_section',
        )));

        // Description
        $wp_customize->add_setting( 'listing_desc_title',
            array(
                'default' => $this->defaults['listing_desc_title'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_text_sanitization'
            )
        );
        $wp_customize->add_control( 'listing_desc_title',
            array(
                'label' => esc_html__( 'Description Title', 'cl-hotel' ),
                'section' => 'listing_details_section',
                'type' => 'text'
            )
        );

        // Listing Video
        $wp_customize->add_setting( 'listing_video_title',
            array(
                'default' => $this->defaults['listing_video_title'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_text_sanitization'
            )
        );
        $wp_customize->add_control( 'listing_video_title',
            array(
                'label' => esc_html__( 'Video Title', 'cl-hotel' ),
                'section' => 'listing_details_section',
                'type' => 'text'
            )
        );

        // Listing Video
        $wp_customize->add_setting( 'listing_map_title',
            array(
                'default' => $this->defaults['listing_map_title'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_text_sanitization'
            )
        );
        $wp_customize->add_control( 'listing_map_title',
            array(
                'label' => esc_html__( 'Map Title', 'cl-hotel' ),
                'section' => 'listing_details_section',
                'type' => 'text'
            )
        );

        // Listing Rating
        $wp_customize->add_setting( 'listing_rating_title',
            array(
                'default' => $this->defaults['listing_rating_title'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_text_sanitization'
            )
        );
        $wp_customize->add_control( 'listing_rating_title',
            array(
                'label' => esc_html__( 'Rating Title', 'cl-hotel' ),
                'section' => 'listing_details_section',
                'type' => 'text'
            )
        );

		//Heading on banner
	    $wp_customize->add_setting( 'show_heading_on_banner',
		    array(
			    'default' => $this->defaults['show_heading_on_banner'],
			    'transport' => 'refresh',
			    'sanitize_callback' => 'rttheme_text_sanitization'
		    )
	    );

	    $wp_customize->add_control( new Switcher( $wp_customize, 'show_heading_on_banner',
		    array(
			    'label' => esc_html__( 'Show Listing Title on Banner', 'cl-hotel' ),
			    'section' => 'listing_details_section',
		    )
	    ) );
		//

        // Listing Custom Fields Group
        $wp_customize->add_setting( 'custom_fields_group_types', 
            array(
                'default'           => $this->defaults['custom_fields_group_types'],
                'transport'         => 'refresh',
                'sanitize_callback' => 'sanitize_multiple_checkbox',
            ) 
        );
        $wp_customize->add_control( new Checkbox_Multiple( $wp_customize, 'custom_fields_group_types', 
            array(
                'label'    => __( 'Custom Group Fileds', 'cl-hotel' ),
                'description'    => __( 'Select custom individual groups. There come only multi checkbox type groups', 'cl-hotel' ),
                'section'  => 'listing_details_section',
                'type'  => 'checkbox-multiple',
                'choices'  => $group_list,
            ) 
        ) );

        $wp_customize->add_setting( 'custom_fields_list_types', 
            array(
                'default'           => $this->defaults['custom_fields_list_types'],
                'transport'         => 'refresh',
                'sanitize_callback' => 'rttheme_text_sanitization',
            ) 
        );
        $wp_customize->add_control( new Checkbox_Multiple( $wp_customize, 'custom_fields_list_types', 
            array(
                'label'    => __( 'Custom Single Fileds', 'cl-hotel' ),
                'description'    => __( 'Select custom single fields. There come all fileds without multi checkbox type groups', 'cl-hotel' ),
                'section'  => 'listing_details_section',
                'type'  => 'checkbox-multiple',
                'choices'  => $fields_list,
            ) 
        ) );

        /**
         * Heading for listing details related post
         * ================================================================================================*/
        $wp_customize->add_setting('listing_details_related_heading', array(
            'default' => '',
            'sanitize_callback' => 'esc_html',
        ));
        $wp_customize->add_control(new Heading($wp_customize, 'listing_details_related_heading', array(
            'label' => esc_html__( 'Related Posts', 'cl-hotel' ),
            'section' => 'listing_details_section',
        )));

        // Listing related post
        $wp_customize->add_setting( 'show_related_listing',
            array(
                'default' => $this->defaults['show_related_listing'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_switch_sanitization',
            )
        );
        $wp_customize->add_control( new Switcher( $wp_customize, 'show_related_listing',
            array(
                'label' => esc_html__( 'Show Related Posts', 'cl-hotel' ),
                'section' => 'listing_details_section',
            )
        ) );

        // Heading
        $wp_customize->add_setting( 'related_post_heading',
            array(
                'default' => $this->defaults['related_post_heading'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_text_sanitization',
            )
        );
        $wp_customize->add_control( 'related_post_heading',
            array(
                'label' => esc_html__( 'Heading', 'cl-hotel' ),
                'type' => 'text',
                'section' => 'listing_details_section',
            )
        );
        // Sub Heading
        $wp_customize->add_setting( 'related_post_subheading',
            array(
                'default' => $this->defaults['related_post_subheading'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_text_sanitization',
            )
        );
        $wp_customize->add_control( 'related_post_subheading',
            array(
                'label' => esc_html__( 'Sub Heading', 'cl-hotel' ),
                'type' => 'text',
                'section' => 'listing_details_section',
            )
        );
        // Description
        $wp_customize->add_setting( 'related_post_desc',
            array(
                'default' => $this->defaults['related_post_desc'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_text_sanitization',
            )
        );
        $wp_customize->add_control( 'related_post_desc',
            array(
                'label' => esc_html__( 'Description', 'cl-hotel' ),
                'type' => 'text',
                'section' => 'listing_details_section',
            )
        );

        // Related Post Columns
        $wp_customize->add_setting( 'related_post_slider_cols',
            array(
                'default' => $this->defaults['related_post_slider_cols'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_sanitize_integer'
            )
        );
        $wp_customize->add_control( 'related_post_slider_cols',
            array(
                'label' => esc_html__( 'Post Columns', 'cl-hotel' ),
                'type' => 'number',
                'section' => 'listing_details_section',
            )
        );

        /**
        * Heading for listing details sidebar
        * ================================================================================================*/
        $wp_customize->add_setting('listing_details_sidebar_heading', array(
            'default' => '',
            'sanitize_callback' => 'esc_html',
        ));
        $wp_customize->add_control(new Heading($wp_customize, 'listing_details_sidebar_heading', array(
            'label' => esc_html__( 'Sidebar Settings', 'cl-hotel' ),
            'section' => 'listing_details_section',
        )));

        // Listing contact/information
        $wp_customize->add_setting( 'listing_list_information',
            array(
                'default' => $this->defaults['listing_list_information'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_switch_sanitization',
            )
        );
        $wp_customize->add_control( new Switcher( $wp_customize, 'listing_list_information',
            array(
                'label' => esc_html__( 'Contact/Information Widget', 'cl-hotel' ),
                'section' => 'listing_details_section',
            )
        ) );
        
        // Listing owner information        
        $wp_customize->add_setting( 'single_listing_stor_info',
            array(
                'default' => $this->defaults['single_listing_stor_info'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_radio_sanitization'
            )
        );
        $wp_customize->add_control( 'single_listing_stor_info',
            array(
                'label' => esc_html__( 'Listing Author', 'cl-hotel' ),
                'section' => 'listing_details_section',
                'description' => esc_html__( 'This is listing information like store info, store owner info, store manager info', 'cl-hotel' ),
                'type' => 'select',
                'choices' => array(
                    'listing_store' => esc_html__( 'Listing Store', 'cl-hotel' ),
                    'listing_owner' => esc_html__( 'Listing Owner', 'cl-hotel' ),
                    'listing_manager' => esc_html__( 'Listing Manager', 'cl-hotel' ),
                ),
            )
        );

        // Listing open/close time
        $wp_customize->add_setting( 'listing_list_timing',
            array(
                'default' => $this->defaults['listing_list_timing'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_switch_sanitization',
            )
        );
        $wp_customize->add_control( new Switcher( $wp_customize, 'listing_list_timing',
            array(
                'label' => esc_html__( 'Open/Close Timing', 'cl-hotel' ),
                'section' => 'listing_details_section',
            )
        ) );
        // Listing Social Profile
        $wp_customize->add_setting( 'listing_list_socials',
            array(
                'default' => $this->defaults['listing_list_socials'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_switch_sanitization',
            )
        );
        $wp_customize->add_control( new Switcher( $wp_customize, 'listing_list_socials',
            array(
                'label' => esc_html__( 'Social Profiles', 'cl-hotel' ),
                'section' => 'listing_details_section',
            )
        ) );
        // Listing Map Location
        $wp_customize->add_setting( 'listing_list_map_location',
            array(
                'default' => $this->defaults['listing_list_map_location'],
                'transport' => 'refresh',
                'sanitize_callback' => 'rttheme_switch_sanitization',
            )
        );
        $wp_customize->add_control( new Switcher( $wp_customize, 'listing_list_map_location',
            array(
                'label' => esc_html__( 'Map Location', 'cl-hotel' ),
                'section' => 'listing_details_section',
            )
        ) );

    }

    public function custom_field_group_list() {
        $list = [];
        $field = '';
        $group_ids = Functions::get_cfg_ids();
        foreach ( $group_ids as $id ) {
            $atts = [
                'group_ids' => $id
            ];
            if ( $id ) {
                $field_ids   = Functions::get_cf_ids( $atts );
            }
            foreach ( $field_ids as $single_field ) {
                $field = new RtclCFGField( $single_field );
                if ( !empty( $field ) && $field->getType() == 'checkbox' ) {
                    $list[ $id ] = get_the_title( $id );
                }
            }
        }
        return $list;
    }

    public function custom_fields_list() {
        $list = [];
        $group_ids = Functions::get_cfg_ids();
        foreach ( $group_ids as $id ) {
            $atts = [
                'group_ids' => $id
            ];
            if ( $id ) {
                $field_ids   = Functions::get_cf_ids( $atts );
            }
            foreach ( $field_ids as $single_field ) {
                $field = new RtclCFGField( $single_field );
                if ( !empty( $field ) && $field->getType() !== 'checkbox' ) {
                    $list[ $id ] = get_the_title( $id );
                }
            }
        }
        return $list;
    }
}
