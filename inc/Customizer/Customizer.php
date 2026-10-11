<?php
/**
 * @author  RadiusTheme
 * @since   1.0.0
 * @version 1.0.0
 */

namespace RadiusTheme\CLHotel\Customizer;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Adds the individual sections, settings, and controls to the theme customizer
 */
class Customizer {

	// Get our default values
	protected $defaults;
	protected static $instance = null;

	public function __construct() {
		// Register Panels
		add_action( 'customize_register', [ $this, 'add_customizer_panels' ] );
		// Register sections
		add_action( 'customize_register', [ $this, 'add_customizer_sections' ] );
	}

	public static function instance() {
		if ( null == self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function populated_default_data(){
		$this->defaults = Default_Data::default_values();
	}

	/**
	 * Customizer Panels
	 */
	public function add_customizer_panels( $wp_customize ) {
		// Add General Panel
        $wp_customize->add_panel( 'rttheme_general_settings',
            [
                'title' => esc_html__( 'General', 'cl-hotel' ),
                'description' => esc_html__( 'Headers.', 'cl-hotel' ),
                'priority' => 1,
            ]
        );

		// Add Header Panel
        $wp_customize->add_panel( 'rttheme_header_settings',
            [
                'title' => esc_html__( 'Header', 'cl-hotel' ),
                'description' => esc_html__( 'Headers.', 'cl-hotel' ),
                'priority' => 2,
            ]
        );

        // Add Footer Panel
        $wp_customize->add_panel( 'rttheme_footer_settings',
			[
                'title' => esc_html__( 'Footer', 'cl-hotel' ),
                'description' => esc_html__( 'Footers', 'cl-hotel' ),
                'priority' => 3,
            ]
        );
		// Color Panel
		$wp_customize->add_panel( 'rttheme_color_panel',
			[
				'title'       => esc_html__( 'Color', 'cl-hotel' ),
				'description' => esc_html__( 'Change site color', 'cl-hotel' ),
				'priority'    => 4,
			]
		);
		// Blog Panel
		$wp_customize->add_panel( 'rttheme_blog_panel',
			[
				'title'       => esc_html__( 'Blog', 'cl-hotel' ),
				'description' => esc_html__( 'Blog Settings', 'cl-hotel' ),
				'priority'    => 6,
			]
		);
		// Listing Panel
		$wp_customize->add_panel( 'rttheme_listing_panel',
			[
				'title'       => esc_html__( 'Listing', 'cl-hotel' ),
				'description' => esc_html__( 'Listing & Listing Details Settings', 'cl-hotel' ),
				'priority'    => 7,
			]
		);
		// Layout Panel
		$wp_customize->add_panel( 'rttheme_layouts_defaults',
			[
				'title'       => esc_html__( 'Layout Settings', 'cl-hotel' ),
				'description' => esc_html__( 'Adjust the overall layout for your site.', 'cl-hotel' ),
				'priority'    => 8,
			]
		);
		// Pages Panel
		$wp_customize->add_panel( 'rttheme_pages_defaults',
			[
				'title'       => esc_html__( 'Pages Settings', 'cl-hotel' ),
				'description' => esc_html__( 'Default pages settings here.', 'cl-hotel' ),
				'priority'    => 8,
			]
		);
	}

	/**
	 * Customizer sections
	 */
	public function add_customizer_sections( $wp_customize ) {
		// Rename the default Colors section
		$wp_customize->get_section( 'colors' )->title = 'Background';
		// Move the default Colors section to our new Colors Panel
		$wp_customize->get_section( 'colors' )->panel = 'colors_panel';
		// Change the Priority of the default Colors section so it's at the top of our Panel
		$wp_customize->get_section( 'colors' )->priority = 10;

		/* = General Panel
		===================================================================*/
		// Add General Section Logo
		$wp_customize->add_section( 'general_logo',
			[
				'title'    => esc_html__( 'Logo', 'cl-hotel' ),
				'priority' => 1,
				'panel'    => 'rttheme_general_settings',
			]
		);
		// General Section Logo
		$wp_customize->add_section( 'general_switcher',
			[
				'title'    => esc_html__( 'Switcher', 'cl-hotel' ),
				'priority' => 2,
				'panel'    => 'rttheme_general_settings',
			]
		);
		// General Section Contact Info
		$wp_customize->add_section( 'contact_info_section',
			[
				'title'    => esc_html__( 'Contact & Social', 'cl-hotel' ),
				'priority' => 3,
				'panel'    => 'rttheme_general_settings',
			]
		);


		/* = Header Panel
		===================================================================*/
		// Add Header Main Section
		$wp_customize->add_section( 'header_all_section',
			[
				'title'    => esc_html__( 'All Header', 'cl-hotel' ),
				'priority' => 1,
				'panel'    => 'rttheme_header_settings',
			]
		);
		// Add Header Mobile Section
		$wp_customize->add_section( 'header_mobile_section',
			[
				'title'    => esc_html__( 'Mobile', 'cl-hotel' ),
				'priority' => 3,
				'panel'    => 'rttheme_header_settings',
			]
		);

		/* = Footer Panel
		===================================================================*/
		// Add Footer Section
		$wp_customize->add_section( 'footer_all_section',
			[
				'title'    => esc_html__( 'All Footer', 'cl-hotel' ),
				'panel'    => 'rttheme_footer_settings',
				'priority' => 1,
			]
		);
		$wp_customize->add_section( 'footer_1',
			[
				'title'    => esc_html__( 'Footer Columns', 'cl-hotel' ),
				'panel'    => 'rttheme_footer_settings',
				'priority' => 2,
			]
		);
		$wp_customize->add_section( 'footer_2',
			[
				'title'    => esc_html__( 'Footer 2', 'cl-hotel' ),
				'panel'    => 'rttheme_footer_settings',
				'priority' => 3,
			]
		);
		$wp_customize->add_section( 'footer_newsletter',
			[
				'title'    => esc_html__( 'Newsletter Section', 'cl-hotel' ),
				'panel'    => 'rttheme_footer_settings',
				'priority' => 4,
			]
		);


		/* = Colors Panel
		===================================================================*/
		// Add Color Section
		$wp_customize->add_section( 'site_color_section',
			[
				'title'    => esc_html__( 'Site Color', 'cl-hotel' ),
				'panel'    => 'rttheme_color_panel',
				'priority' => 1,
			]
		);
		$wp_customize->add_section( 'menu_color_section',
			[
				'title'    => esc_html__( 'Menu Color', 'cl-hotel' ),
				'panel'    => 'rttheme_color_panel',
				'priority' => 2,
			]
		);
		$wp_customize->add_section( 'breadcrumb_color_section',
			[
				'title'    => esc_html__( 'Breadcrumb Color', 'cl-hotel' ),
				'panel'    => 'rttheme_color_panel',
				'priority' => 3,
			]
		);
		$wp_customize->add_section( 'footer_color_section',
			[
				'title'    => esc_html__( 'Footer Color', 'cl-hotel' ),
				'panel'    => 'rttheme_color_panel',
				'priority' => 4,
			]
		);


		/* = Layout Panel
		===================================================================*/
		// Add Blog Layout Section
		$wp_customize->add_section( 'blog_layout_section',
			[
				'title'    => esc_html__( 'Blog Layout', 'cl-hotel' ),
				'priority' => 1,
				'panel'    => 'rttheme_layouts_defaults',
			]
		);
		// Add Single Post Layout Section
		$wp_customize->add_section( 'blog_single_layout_section',
			[
				'title'    => esc_html__( 'Blog Single Layout', 'cl-hotel' ),
				'priority' => 2,
				'panel'    => 'rttheme_layouts_defaults',
			]
		);
		// Add Pages Layout Section
		$wp_customize->add_section( 'page_layout_section',
			[
				'title'    => esc_html__( 'Pages Layout', 'cl-hotel' ),
				'priority' => 3,
				'panel'    => 'rttheme_layouts_defaults',
			]
		);
		// Add Search Layout Section
		$wp_customize->add_section( 'search_layout_section',
			[
				'title'    => esc_html__( 'Search Layout', 'cl-hotel' ),
				'priority' => 4,
				'panel'    => 'rttheme_layouts_defaults',
			]
		);
		// Add Error Layout Section
		$wp_customize->add_section( 'error_layout_section',
			[
				'title'    => esc_html__( 'Error Layout', 'cl-hotel' ),
				'priority' => 4,
				'panel'    => 'rttheme_layouts_defaults',
			]
		);
		// Add Listing Layout Section
		$wp_customize->add_section( 'listing_archive_layout_section',
			[
				'title'    => esc_html__( 'Listing Archive Layout', 'cl-hotel' ),
				'priority' => 5,
				'panel'    => 'rttheme_layouts_defaults',
			]
		);
		// Add Listing Single Layout Section
		$wp_customize->add_section( 'listing_single_layout_section',
			[
				'title'    => esc_html__( 'Listing Single Layout', 'cl-hotel' ),
				'priority' => 6,
				'panel'    => 'rttheme_layouts_defaults',
			]
		);


		/* = Blog Panel
		===================================================================*/
		// Add Blog Archive Section
		$wp_customize->add_section( 'blog_archive_section',
			[
				'title'    => esc_html__( 'Blog Archive', 'cl-hotel' ),
				'priority' => 1,
				'panel'    => 'rttheme_blog_panel',
			]
		);
		// Add Single Post Section 
		$wp_customize->add_section( 'single_post_section',
			[
				'title'    => esc_html__( 'Blog Post Details', 'cl-hotel' ),
				'priority' => 2,
				'panel'    => 'rttheme_blog_panel',
			]
		);

		/* = Listing Panel
		===================================================================*/
		// Add Listing Section
        $wp_customize->add_section( 'listing_archive_section',
            array(
                'title' => esc_html__( 'Listing Archive', 'cl-hotel' ),
                'priority' => 1,
                'panel' => 'rttheme_listing_panel',
            )
        );
        // Add Listing Section
        $wp_customize->add_section( 'listing_details_section',
            array(
                'title' => esc_html__( 'Listing Details', 'cl-hotel' ),
                'priority' => 2,
                'panel' => 'rttheme_listing_panel',
            )
        );
        // Add Listing Search Section
        $wp_customize->add_section( 'listing_search_section',
            array(
                'title' => esc_html__( 'Listing Search', 'cl-hotel' ),
                'priority' => 3,
                'panel' => 'rttheme_listing_panel',
            )
        );

		// Add Error Page Section
		$wp_customize->add_section( 'error_section',
			[
				'title'    => esc_html__( 'Error Page', 'cl-hotel' ),
				'priority' => 1,
			]
		);

		/* = Pages Panel
		===================================================================*/
		// 404 Page
        $wp_customize->add_section( 'error_section',
            array(
                'title' => esc_html__( '404 Error', 'cl-hotel' ),
                'priority' => 1,
                'panel' => 'rttheme_pages_defaults',
            )
        );
	}

}
