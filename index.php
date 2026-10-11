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

$blog_style = Options::$options['blog_style'];
$cols = Options::$options['blog_grid'];
$cols2 = Options::$options['blog_medium_grid'];

?>
<?php get_header(); ?>

<!--=====================================-->
<!--=              Blog Start    	    =-->
<!--=====================================-->
<section class="content-area blog-posts-layout">
	<div class="container">
		<div class="row justify-content-center gutters-40">
			<div class="<?php Helper::the_layout_class(); ?>">
				<?php if ( have_posts() ) : ?>
				<?php
					if ( ( is_home() || is_archive() ) ) {
						if ($blog_style == 2) {
						echo '<div class="row row-cols-1 row-cols-lg-'.esc_attr( $cols ).' row-cols-md-'.esc_attr( $cols2 ).'">';
						} else {
							echo '<div class="row row-cols-1">';
						}
						while ( have_posts() ) : the_post();
							echo '<div class="col">';
								get_template_part( 'template-parts/archive-blog/content',  1 ); 
							echo '</div>';
						endwhile;
						echo '</div>';
						Helper::pagination();
					}
					else {
						while ( have_posts() ) : the_post();
							get_template_part( 'template-parts/content' );
						endwhile;
					}
				?>
				<?php else: ?>
					<?php get_template_part( 'template-parts/content', 'none' ); ?>
				<?php endif; ?>
				<?php wp_reset_postdata(); ?>
			</div>
			<?php Helper::clhotel_sidebar(); ?>
		</div>
	</div>
</section>

<?php get_footer(); ?>