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
<div id="primary" class="content-area">
	<div class="container">
		<div class="row">
			<div class="<?php Helper::the_layout_class();?>">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php
					get_template_part( 'template-parts/content', 'page' );
					if ( comments_open() || get_comments_number() ){
						comments_template();
					}
					?>
				<?php endwhile; ?>
			</div>
			<?php
                if (Helper::has_sidebar()) {
                    get_sidebar();
                }
			?>
		</div>
	</div>
</div>
<?php get_footer(); ?>