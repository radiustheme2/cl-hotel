<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */
 
namespace RadiusTheme\CLHotel\Customizer;

use RadiusTheme\CLHotel\Customizer\Settings\General;
use RadiusTheme\CLHotel\Customizer\Settings\Contact_Info;
use RadiusTheme\CLHotel\Customizer\Settings\Header;
use RadiusTheme\CLHotel\Customizer\Settings\Newsletter;
use RadiusTheme\CLHotel\Customizer\Settings\Footer;
use RadiusTheme\CLHotel\Customizer\Settings\Blog;
use RadiusTheme\CLHotel\Customizer\Settings\Post;
use RadiusTheme\CLHotel\Customizer\Settings\Colors;
use RadiusTheme\CLHotel\Customizer\Typography\Typography;
use RadiusTheme\CLHotel\Customizer\Settings\Error;
/* = Layouts = */
use RadiusTheme\CLHotel\Customizer\Settings\Page_Layout;
use RadiusTheme\CLHotel\Customizer\Settings\Blog_Layout;
use RadiusTheme\CLHotel\Customizer\Settings\Blog_Single_Layout;
use RadiusTheme\CLHotel\Customizer\Settings\Error_Layout;
use RadiusTheme\CLHotel\Customizer\Settings\Search_Layout;
/* = Listing = */
use RadiusTheme\CLHotel\Customizer\Settings\Listing_Archive;
use RadiusTheme\CLHotel\Customizer\Settings\Listing_Single;
use RadiusTheme\CLHotel\Customizer\Settings\Listing_Search;
use RadiusTheme\CLHotel\Customizer\Settings\Listing_Archive_Layout;
use RadiusTheme\CLHotel\Customizer\Settings\Listing_Single_Layout;



class Init {
	protected static $instance = null;

	/**
	 * Create an inaccessible constructor.
	 */
	private function __construct() {
		$this->includes();
	}

	public static function instance() {
		if ( null == self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	private function includes() {
		new General();
		new Contact_Info();
		new Header();
		new Footer();
		new Newsletter();
		new Blog();
		new Post();
		new Colors();
		new Typography();
		new Error();
		// Layout
		new Page_Layout();
		new Blog_Layout();
		new Blog_Single_Layout();
		new Search_Layout();
		new Error_Layout();
		
		// Listings
		if ( class_exists( 'Rtcl' ) ) {
			new Listing_Archive();
			new Listing_Single();
			new Listing_Search();
			new Listing_Archive_Layout();
			new Listing_Single_Layout();
		}
	}
}