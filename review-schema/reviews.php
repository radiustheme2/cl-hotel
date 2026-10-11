<?php
/**
 * Review grid one template
 *
 * @author      RadiusTheme
 * @package     review-schema/templates
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Rtrs\Helpers\Functions;
use Rtrs\Modules\Review\Helpers\ReviewFns;

$get_post_type = get_post_type( get_the_ID() );
$p_meta        = Functions::getMetaByPostType( get_post_type() );
$parent_class  = isset( $p_meta['parent_class'] ) ? $p_meta['parent_class'][0] : '';
?>  
<div class="rtrs-review-wrap <?php echo esc_attr( $parent_class ); ?> rtrs-review-post-type-<?php echo esc_attr( $get_post_type ); ?> rtrs-review-sc-<?php echo esc_attr( $p_meta['sc_id'] ); ?>" id="comments">
	<?php if ( have_comments() ) : ?> 
		
		<?php
			$total_rating = ReviewFns::getTotalRatings( get_the_ID() );
			$layout       = isset( $p_meta['summary_layout'] ) ? $p_meta['summary_layout'][0] : 'one';

			$s_affiliate = ( get_post_meta( get_the_ID(), 'rtrs_affiliate', true ) == '1' );
			$s_layout    = get_post_meta( get_the_ID(), 'rtrs_summary_layout', true );

			if ( $s_affiliate && $s_layout ) {
				$layout = $s_layout;
			}

			if ( $total_rating ) {
				Functions::get_template_part(
					'summary/layout-' . $layout,
					[
						'total_rating' => $total_rating,
						'p_meta'       => $p_meta,
					]
				);
			}
		?>
		<div class="listingDetails-block mb-30">
    		<h3 class="listingDetails-block__heading mb-10">
				<?php
					$review_title = esc_html(  sprintf(
						// translators: %s: Number of users who reviewed.
						_n( 'Reviewed by %s user', 'Reviewed by %s users', $total_rating, 'cl-hotel' ) ,
						$total_rating
					) );
					echo esc_html( apply_filters( 'rtrs_review_sorting_title', $review_title, $total_rating, get_the_ID() ) );
				?>
			</h3>
			<div class="rtrs-review-box">
				<ul class="rtrs-review-list"> 
					<?php

						// TODO:: Sticky Comment will display here

						do_action( 'rtrs_before_review_comments_list', $p_meta, get_the_ID() );

						$args = [
							'post_id' => get_the_ID(),
							'status'  => 'approve', // Change this to the type of comments to be displayed
						];
						$comments = get_comments( apply_filters( 'rtrs_comments_query_args', $args, $p_meta ) );
						wp_list_comments(
							[
								'style'      => 'li',
								'short_ping' => true,
								'callback'   => [ ReviewFns::class, 'comment_list' ],
							],
							$comments
						);
					?>
				</ul>
			</div> 

			<?php
			$pagination_type = isset( $p_meta['pagination_type'] ) ? $p_meta['pagination_type'][0] : 'number';
			if ( $pagination_type == 'number' ) {
				?>
				<?php if ( get_the_comments_pagination() ) { ?>
				<div class="rtrs-paginate">
					<?php
					paginate_comments_links(
						[
							'prev_text' => '<i class="rtrs-angle-left"></i>',
							'next_text' => '<i class="rtrs-angle-right"></i>',
						]
					);
					?>
				</div>
				<?php } ?>
			<?php } elseif ( $pagination_type == 'number-ajax' ) { ?>
				<?php if ( get_the_comments_pagination() ) { ?>
				<div class="rtrs-paginate rtrs-paginate-ajax" data-max="<?php echo esc_attr( get_comment_pages_count() ); ?>">
					<?php
					paginate_comments_links(
						[
							'prev_text' => '<i class="rtrs-angle-left"></i>',
							'next_text' => '<i class="rtrs-angle-right"></i>',
						]
					);
					?>
				</div>
				<?php } ?>
			<?php } elseif ( $pagination_type == 'load-more' ) { ?>
				<div class="rtrs-paginate rtrs-paginate-load-more rtrs-align-center">
					<a href="#" id="rtrs-load-more" data-max="<?php echo esc_attr( get_comment_pages_count() ); ?>"><?php echo esc_html_e( 'Load More', 'cl-hotel' ); ?></a>
				</div>
			<?php } elseif ( $pagination_type == 'auto-scroll' ) { ?>
				<div class="rtrs-paginate rtrs-paginate-onscroll" data-max="<?php echo esc_attr( get_comment_pages_count() ); ?>"></div>
			<?php } ?>
		</div>
		<?php
	endif;
	?>

	<div class="listingDetails-block mb-30">
		<?php 
		if ( is_user_logged_in() ) {
			global $current_user;
			$is_commented = get_comments(
				[
					'user_id'    => $current_user->ID,
					'post_id'    => $post->ID,
					'meta_query' => [
						[
							'key'     => 'rating',
							'value'   => [ 1, 5 ],
							'compare' => 'BETWEEN',
						],
					],
				]
			);

			$multiple_review = rtrs()->get_options( 'rtrs_review_settings', [ 'multiple_review', 'no' ] );

			if ( $is_commented && $multiple_review == 'no' ) {
				echo '<div class="rtrs-multiple-comment">';
				ReviewFns::the_comment_form(); // comment_form();
				echo '</div>';
			} else {
				ReviewFns::the_comment_form();
			}
		} else {
			ReviewFns::the_comment_form();
		}
		?>
	  
		<script>
			jQuery( document ).ready(function($) {
				$('#comment_form').removeAttr('novalidate');
			});
		</script>
	</div>
</div> 
