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

$post_id = get_the_ID();
$padmin = Options::$options['post_admin'];
$pdate = Options::$options['post_date'];
$pcom = Options::$options['post_comnts'];
$pcats = Options::$options['post_cats'];
$ptags = Options::$options['post_tags'];

if ( Options::$options['post_tags'] && has_tag() || Options::$options['post_share'] == "1" ){
    $tags_shares = '';
} else {
    $tags_shares = 'tags-shares-none';
}

if ( Options::$options['post_tags'] && has_tag() ) {
    $scols = '6';
    $tc = '';
} else {
    $scols = '12';
    $tc = 'none-tag';
}

if ( $share = Options::$options['post_share'] == 1 ) {
    $tcols = '6';
} else {
    $tcols = '12';
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'single-blog-wrap' ); ?>>
    <div class="single-content-wrap">
        <?php if ( has_post_thumbnail() ){ ?> 
            <div class="single-blog-thumb"><?php the_post_thumbnail(); ?></div>
        <?php } ?>
        <div class="single-blog-entry">
            <?php echo wp_kses_post( Helper::cl_hotel_get_post_meta( $post_id, $padmin, $pdate, $pcom, $pcats, $type = 'img' ) ); ?>
        </div>
        <h2 class="entry-title">
            <?php the_title(); ?>
        </h2>
        <div class="single-blog-content">
            <?php the_content(); ?>
            <?php wp_link_pages( array(
                'before'      => '<div class="cl-hotel-page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'cl-hotel' ) . '</span>',
                'after'       => '</div>',
                'link_before' => '<span>',
                'link_after'  => '</span>',
                ) );
            ?>
        </div>
        <?php if ( Options::$options['post_tags'] && has_tag() || Options::$options['post_share'] == "1" ){ ?>
        <div class="single-blog-footer <?php echo esc_attr( $tags_shares.' '.$tc ); ?>">
            <?php if ( Options::$options['post_tags'] && has_tag() ): ?>
                <div class="blog-tags">
                    <span><?php esc_html_e( 'Tags:', 'cl-hotel' ); ?></span>
                    <?php echo get_the_term_list( $post->ID, 'post_tag','',' ' ); ?>
                </div>
            <?php endif; if ( Options::$options['post_share'] == "1"  ): ?>
                <div class="social-btn social-btn-2">
                    <span><?php esc_html_e( 'Share:', 'cl-hotel' ); ?></span>
                    <?php Helper::render(); ?>
                </div>
            <?php endif; ?>
        </div>  
        <?php } ?>      
    </div>
</article>

<?php if (get_the_author_meta('description')) : ?>      
    <div class="blog-author">
        <div class="media">
            <div class="info-item">
                <?php echo get_avatar(get_the_author_meta('user_email'), '180'); ?>
            </div>
            <div class="info-item">
                <span><?php esc_html_e( 'Autohr', 'cl-hotel' ); ?></span>
                <h4 class="author-title"><?php esc_html(the_author_meta('display_name')); ?></h4>
                <p><?php esc_textarea(the_author_meta('description')); ?></p>
                <?php Helper::UserMeta(); ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if ( comments_open() || get_comments_number() ){ ?>
<div class="blog-comment-form">
    <?php comments_template(); ?>  
</div>
<?php } ?>