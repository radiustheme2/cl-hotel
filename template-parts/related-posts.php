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

if ($cols > 1) {
	$imgSize = 'cl-hotel-size1';
} else {
	$imgSize = 'full';
}
if ($blog_style == 1) {
    $imgSize = 'full';
} else {
    $imgSize = $imgSize;
}

$excerpt_length = 12;
$padmin = Options::$options['post_meta_admin'];
$pdate = Options::$options['post_meta_date'];
$pcom = Options::$options['post_meta_comnts'];

$rt_post_cat = wp_get_object_terms( $post->ID, 'category', [ 'fields' => 'ids' ] );
// arguments
$args = [
	'post_type'      => 'post',
	'post_status'    => 'publish',
	'posts_per_page' => 3,
	'tax_query'      => [
		[
			'taxonomy' => 'category',
			'field'    => 'id',
			'terms'    => $rt_post_cat,
		],
	],
	'post__not_in'   => [ $post->ID ],
];

$query = new \WP_Query( $args );
if ( $query->have_posts() ) :
?>

<div class="related-post-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="related-listing-header">
                    <div class="section-heading">
                        <h5><?php echo esc_html__( 'Update News', 'cl-hotel' ); ?></h5>    
                        <h3><?php echo esc_html__( 'Similar Post', 'cl-hotel' ); ?></h3>    
                    </div>
                </div>
                <div class="section-title-wrapper">
                    <div class="row">
                        <?php
                            while ( $query->have_posts() ) : 
                                $query->the_post();
                                if ( has_post_thumbnail() ){
                                    $thumb_img = '';
                                } else {
                                    $thumb_img = 'no-image';
                                }
                                $post_id = get_the_ID();
                        ?>
                        <div class="col-lg-4 col-md-6">
                            <article id="post-<?php the_ID(); ?>" <?php post_class( 'blog-post blog-list blog-post-'.$cols. ' ' .$thumb_img ); ?>>
                                <?php if ( has_post_thumbnail()):
                                    $thumb = get_the_post_thumbnail( get_the_ID(), 'cl-hotel-size1');
                                    ?>
                                    <div class="blog-post__figure">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php echo wp_kses_post($thumb); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                <div class="blog-post__content">
                                    <?php echo wp_kses_post( Helper::cl_hotel_get_post_meta( $post_id, $padmin, $pdate, $pcom, $pcats = NULL, $type = 'icon' ) ); ?>
                                    <h3 class="blog-post__content__heading"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                    <div class="blog-post__content__excerpt">
                                        <p><?php echo esc_html( Helper::cl_hotel_excerpt( $excerpt_length ) ); ?></p>
                                    </div>
                                    <div class="btn-wrap">
                                        <a href="<?php the_permalink(); ?>" class="item-btn">
                                            <span class="btn__text"><?php esc_html_e( 'Read More', 'cl-hotel' ); ?></span>
                                        </a>
                                    </div>
                                </div>
                                <?php if ( is_sticky() ) {
                                    echo '<sup class="meta-featured-post"> <i class="fas fa-thumbtack"></i> ' . esc_html__( 'Sticky', 'cl-hotel' ) . ' </sup>';
                                } ?>
                            </article>
                        </div>
                        <?php
                            endwhile;
                            wp_reset_postdata();
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php endif; ?>