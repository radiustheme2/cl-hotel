<?php  
/**
 * Review author template
 * @author      RadiusTheme
 * @package     review-schema/templates
 * @version     1.0.0
 *   
 */ 

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<li class="rtrs-author-link">
    <?php 
        if ( get_comment_meta( get_comment_ID(), 'rt_anonymous', true ) ) {
            esc_html_e( 'Anonymous', 'cl-hotel' );
        } else {
            echo get_comment_author_link(); 
        } 
    ?> <i class="rtrs-verified-author"></i>
</li> 