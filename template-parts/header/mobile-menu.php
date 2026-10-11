<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use RadiusTheme\CLHotel\Helper;
use RadiusTheme\CLHotel\Options;

$header_topbar = Options::$options['header_mobile_topbar'] ? true : false;
$header_login = Options::$options['header_mobile_login'] ? true : false;
$header_listing = Options::$options['header_mobile_listing'] ? true : false;
$login_btn_link = Options::$options['login_btn_link'];
$btn_link = Options::$options['listing_btn_link'];
$nav_menu_args = Helper::nav_menu_args();

?>

<div class="rt-mobile-menu mean-container" id="meanmenu">
	<?php
        if ( $header_topbar && (Options::$header_top == '1' || Options::$header_top === "on" )) {
            get_template_part( 'template-parts/header/header-top', 'mobile' );
        }
	?>
    <div class="container">
        <div class="mean-bar">
            <div class="site-branding">
                <?php get_template_part( 'template-parts/header/logo', 1 ); ?>
            </div>
            <div class="site-menu-btns">
                <?php if ( $header_login == true || $header_listing == true && $btn_link && class_exists( 'Rtcl' ) == true ) { ?>
                <div class="nav-action-elements">
                    <ul>
                        <?php if ( $header_login == true ) { ?>
                        <li class="header-login">
                            <a href="<?php echo esc_url( $login_btn_link ); ?>" class="login-btn">
                                <i class="rt-custom-icon-rt18-user2"></i>
                            </a>
                            
                        </li>
                        <?php } if ( $header_listing == true && $btn_link && class_exists( 'Rtcl' ) ) { ?>
                            <li class="header-btn">
                                <a href="<?php echo esc_url( $btn_link ); ?>" class="listing-btn">
                                    <span class="listing-btn__icon">
                                        <i class="fa-solid fa-plus"></i>
                                    </span>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
                <?php } ?>
                <div class="headerBurgerMenu">
                    <button class="headerBurgerMenu__button sidebarBtn" onclick="this.classList.toggle('opened');this.setAttribute('aria-expanded', this.classList.contains('opened'))" aria-label="Main Menu" aria-expanded="true">
                        <svg width="50" height="50" viewBox="0 0 100 100">
                        <path class="line line1" d="M 20,29.000046 H 80.000231 C 80.000231,29.000046 94.498839,28.817352 94.532987,66.711331 94.543142,77.980673 90.966081,81.670246 85.259173,81.668997 79.552261,81.667751 75.000211,74.999942 75.000211,74.999942 L 25.000021,25.000058">
                        </path>
                        <path class="line line2" d="M 20,50 H 80"></path>
                        <path class="line line3" d="M 20,70.999954 H 80.000231 C 80.000231,70.999954 94.498839,71.182648 94.532987,33.288669 94.543142,22.019327 90.966081,18.329754 85.259173,18.331003 79.552261,18.332249 75.000211,25.000058 75.000211,25.000058 L 25.000021,74.999942">
                        </path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <div class="rt-slide-nav">
            <div class="offscreen-navigation">
                <?php if ( has_nav_menu( 'primary' ) ) { 
                    wp_nav_menu( $nav_menu_args );
                } else {
                    if ( is_user_logged_in() ) {
                        echo '<ul id="menu" class="menu fallbackcd-menu-item"><li class="menu-item"><a class="fallbackcd" href="' . esc_url( admin_url( 'nav-menus.php' ) ) . '">' . esc_html__( 'Add a menu', 'cl-hotel' ) . '</a></li></ul>';
                    }
                } ?>
            </div>
        </div>
    </div>
</div>
