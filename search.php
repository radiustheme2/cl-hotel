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

?>
<?php get_header(); ?>
<section id="primary" class="content-area site-search blog-inner">
	<div class="container">
		<div class="row">
			<div class="<?php Helper::the_layout_class(); ?>">
				<div class="main-content">
					<?php if ( have_posts() ) :?>
						<?php while ( have_posts() ) : the_post(); ?>
							<?php get_template_part( 'template-parts/content', 'search' ); ?>
						<?php endwhile; ?>
					<?php else:?>
						<?php get_template_part( 'template-parts/content', 'none' ); ?>
					<?php endif;?>
				</div>
				<?php get_template_part( 'template-parts/pagination' ); ?>
			</div>
            <?php
            if (Helper::has_sidebar()) {
                get_sidebar();
            }
            ?>
		</div>
	</div>
</section>
<?php get_footer(); ?>