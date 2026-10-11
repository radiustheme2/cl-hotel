<?php
/**
 * @package ClassifiedListing/Templates
 * @version 2.2.1.1
 */

use Rtcl\Helpers\Functions;

defined('ABSPATH') || exit;

get_header('listing');

?>
<section class="author-listing-page">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 order-lg-2">
                <div class="listing-box-grid">
                    <?php
                        /**
                         * Hook: rtcl_before_main_content.
                         *
                         * @hooked rtcl_output_content_wrapper - 10 (outputs opening divs for the content)
                         */
                        do_action('rtcl_before_main_content');

                        Functions::get_template( 'listing/author-content');

                        /**
                         * Hook: rtcl_after_main_content.
                         *
                         * @hooked rtcl_output_content_wrapper_end - 10 (outputs closing divs for the content)
                         */
                        do_action('rtcl_after_main_content');
                    ?>
                </div>
            </div>
            <div class="col-lg-4 order-lg-1 listing-sidebar-left">
                <div class="listing-sidebar listing-archive-sidebar">
                    <?php dynamic_sidebar( 'rtcl-archive-sidebar' ); ?>
                </div>
            </div>
        </div>
    </div>
</section> 
<?php 
get_footer('listing');
