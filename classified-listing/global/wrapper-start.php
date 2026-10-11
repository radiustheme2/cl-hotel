<?php
/**
 * Content wrappers
 *
 * @package     ClassifiedListing/Templates
 * @version     1.4.0
 */

use Rtcl\Helpers\Functions;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

echo '<div id="primary" class="content-area clhotel-archive-main-container-wrapper' . esc_attr( Functions::add_theme_container_class() ) . '">';
