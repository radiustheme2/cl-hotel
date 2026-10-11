<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

do_action( 'rtcl_page_template_before_content' );

while ( have_posts() ) :
	the_post();
	the_content();
endwhile;

do_action( 'rtcl_page_template_after_content' );

get_footer();
?>