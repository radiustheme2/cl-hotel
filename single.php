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

?>

<?php get_header(); ?>

<!--=====================================-->
<!--=         Blog Details Start    	=-->
<!--=====================================-->
<section class="content-area blog-details-page">
    <div class="container">
        <div class="row justify-content-center gutters-40">
            <div class="<?php Helper::the_layout_class(); ?>">
                <div id="main" class="site-main">
					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'template-parts/content-single' ); ?>
					<?php endwhile; 
                    wp_reset_postdata();
                    ?>
				</div>
            </div>
            <?php Helper::clhotel_sidebar(); ?>
        </div>
    </div>
    <?php
        if ( Options::$options['blog_related_post'] ) {
            get_template_part( 'template-parts/related', 'posts' );
        }
    ?>
</section>

<?php get_footer(); ?>