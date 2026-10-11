<?php
/**
 * Review layout one template
 *
 * @author      RadiusTheme
 * @package     review-schema/templates/review
 * @version     1.0.0
 *
 * @var use Rtrs\Helpers\Functions
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Rtrs\Modules\Review\Helpers\ReviewFns;

?> 

<div class="<?php echo esc_attr( $comment_classes ); ?>"> 

	<?php if ( get_option( 'show_avatars' ) ) { ?>
		<div class="rtrs-review-imgholder">
			<?php
				$avatar = '';
			if ( get_comment_meta( get_comment_ID(), 'rt_anonymous', true ) ) {
				$avatar = RTRS_URL . '/assets/imgs/avatar.jpg';
			} else {
				$avatar = get_avatar_url( $comment->comment_author_email, [ 'size' => '70' ] );
			}
			?>
			<img src="<?php echo esc_url( $avatar ); ?>" alt="">	
		</div> 
	<?php } ?>

	<div class="rtrs-review-body"> 
		<div class="review-meta-heading">
			<ul class="rtrs-review-meta">  
				<?php rtrs()->get_partial_path( 'author', [ 'p_meta' => $p_meta ] ); ?> 
			</ul>
			<ul class="rtrs-review-meta">  
				<li class="rtrs-review-date"><i class="rtrs-calendar"></i>
					<?php
					// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- ReviewFns::comment_review_time() returns plugin-formatted date HTML.
					echo ReviewFns::comment_review_time( $comment );
					?>
				<?php
				if ( $review_edit == 'yes' && get_current_user_id() && $comment->user_id == get_current_user_id() ) {
					?>
					<span class="rtrs-review-edit-btn" data-comment-post-id="<?php echo esc_attr( $comment->comment_post_ID ); ?>" data-comment-id="<?php echo esc_attr( $comment->comment_ID ); ?>">
						<?php esc_html_e( '(Edit)', 'cl-hotel' ); ?>
					</span> 
				<?php } ?>

				</li>
				<?php if ( $rtrs_avg = get_comment_meta( get_comment_ID(), 'rating', true ) ) { ?>
					<?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- ReviewFns::review_stars() returns plugin-controlled <i> star icon HTML. ?>
                    <li class="rtrs-review-rating"><?php echo ReviewFns::review_stars( $rtrs_avg ); ?></li>
				<?php } ?>
				<?php rtrs()->get_partial_path( 'share', [ 'p_meta' => $p_meta ] ); ?> 
			</ul>
		</div>

		<?php if ( $title = get_comment_meta( get_comment_ID(), 'rt_title', true ) ) { ?>
			<h4 class="rtrs-review-title"><?php echo esc_html( $title ); ?></h4>
		<?php } ?>

		<?php comment_text(); ?> 

		<?php if ( $comment->comment_approved == '0' ) : ?>
			<p><em class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'cl-hotel' ); ?></em></p>
		<?php endif; ?>

		<?php rtrs()->get_partial_path( 'attachment', [ 'p_meta' => $p_meta ] ); ?>

		<?php rtrs()->get_partial_path( 'pros-cons', [ 'p_meta' => $p_meta ] ); ?> 

		<?php
			rtrs()->get_partial_path(
				'reply',
				[
					'args'      => $args,
					'add_below' => $add_below,
					'depth'     => $depth,
				]
			);
		?>

	</div>
</div>   
