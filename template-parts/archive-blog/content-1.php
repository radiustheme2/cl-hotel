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
global $post;

$blog_style = Options::$options['blog_style'];
$cols = Options::$options['blog_grid'];

if ($cols > 1) {
	$imgSize = 'rtcl-thumbnail';
} else {
	$imgSize = 'full';
}
if ($blog_style == 1) {
    $imgSize = 'full';
} else {
    $imgSize = $imgSize;
}
$post_id = get_the_ID();
$padmin = Options::$options['post_meta_admin'];
$pdate = Options::$options['post_meta_date'];
$pcom = Options::$options['post_meta_comnts'];
$pcats = Options::$options['post_meta_cats'];
$excerpt_length = Options::$options['excerpt_length'];

if ( has_post_thumbnail() ){
    $thumb_img = '';
} else {
    $thumb_img = 'no-image';
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'blog-post blog-list blog-post-'.$cols. ' ' .$thumb_img ); ?>>
    <?php if ( has_post_thumbnail()):
        $thumb = get_the_post_thumbnail( get_the_ID(), $imgSize );
        ?>
        <div class="blog-post__figure">
            <a href="<?php the_permalink(); ?>">
                <?php echo wp_kses_post( $thumb ); ?>
            </a>
        </div>
    <?php endif; ?>
    <div class="blog-post__content">
        <?php echo wp_kses_post( Helper::cl_hotel_get_post_meta( $post_id, $padmin, $pdate, $pcom, $pcats, $type = 'icon' ) ); ?>
        <h2 class="blog-post__content__heading"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <?php if (!empty(Options::$options['blog_short_desc'])) { ?>
        <div class="blog-post__content__excerpt">
            <p><?php echo esc_html( Helper::cl_hotel_excerpt( $excerpt_length ) ); ?></p>
        </div>
        <?php } if (!empty(Options::$options['blog_button'])) { ?>
        <div class="read-more">
            <a href="<?php the_permalink(); ?>" class="item-btn">
                <span class="btn__text"><?php esc_html_e( 'Read More', 'cl-hotel' ); ?></span>
                <i class="demo-icon rt-custom-icon-long-arrow-right"></i>
            </a>
        </div>
        <?php } ?>
    </div>
    <?php if ( is_sticky() ) {
        echo '<sup class="meta-featured-post"> <i class="fas fa-thumbtack"></i> ' . esc_html__( 'Sticky', 'cl-hotel' ) . ' </sup>';
    } ?>
</article>