<?php  
/**
 * Review summary layout three template
 * @author      RadiusTheme
 * @package     review-schema/templates/review
 * @version     1.0.0
 * 
 * @var use Rtrs\Helpers\Functions 
 * 
 */  

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Rtrs\Helpers\Functions;
use RadiusTheme\CLHotel\Options;
use Rtrs\Modules\Review\Helpers\ReviewFns;

$rating_title = Options::$options['listing_rating_title'];
?>  


<div class="listingDetails-block mb-30">
    <h3 class="listingDetails-block__heading mb-30"><?php echo esc_html( $rating_title ); ?></h3>
    <div class="listingDetails-block__rating listingDetails-block__rating">                 
        <div class="rtrs-summary-3 rtrs-summary-4-by-user">
            <div class="rtrs-rating-summary">
                <div class="rtrs-rating-item grid-span-2"> 
                    <ul class="rtrs-rating-category">
                        <?php 
                        $avg_by_star = ReviewFns::getAvgRatingByStar( get_the_ID() );

                        for( $i = 5; $i >= 1; $i-- ) {  ?>     
                            <li class="review-<?php echo esc_attr($i); ?>"> 
                                <div class="rating-icon">
                                    <?php 
                                    if ($i == 5 ) {
                                        esc_html_e( 'Excellent', 'cl-hotel' );
                                    } elseif ($i == 4 ) {
                                        esc_html_e( 'Good', 'cl-hotel' );
                                    } elseif ($i == 3 ) {
                                        esc_html_e( 'Average', 'cl-hotel' );
                                    } elseif ($i == 2 ) {
                                        esc_html_e( 'Below Average', 'cl-hotel' );
                                    } else {
                                        esc_html_e( 'Poor', 'cl-hotel' );
                                    }
                                    ?>
                                </div>
                                
                                <div class="rtrs-progress-wrap">
                                    <div class="rtrs-progress"> 
                                        <?php 
                                            if ( $avg_by_star[$i] ) {
                                                $percent = ( 100 / $total_rating ) * $avg_by_star[$i];
                                            } else {
                                                $percent = 0;
                                            } 
                                        ?>
                                        <progress class="rtrs-progress-bar starting-preogress" value="<?php echo esc_attr( $percent ); ?>" max="100"></progress> 
                                    </div> 
                                </div>

                                <div class="rating-number-user">
                                    <span class="total-number"><?php echo esc_html( $avg_by_star[$i] ); ?></span> 
                                </div>
                            </li>
                        <?php } ?> 
                    </ul>
                </div> 
                
                <?php if ( $avg_rating = ReviewFns::getAvgRatings( get_the_ID() ) ) { ?>
                <div class="rtrs-rating-item">
                    <div class="rtrs-rating-overall">
                        <div class="rating-percent"><?php echo esc_html( $avg_rating ); ?><span class="rtrs-out-of">/5</span></div>
                        <div class="rating-text"><?php esc_html_e( 'OVERALL', 'cl-hotel' ); ?></div>
                        <div class="rating-icon">
	                        <?php echo ReviewFns::review_stars( $avg_rating ); ?>
                        </div>
                        <p>
                            <?php 
                                printf(
                                    // translators: %s: Total number of ratings.
                                    esc_html( _n( 'Based on %s rating', 'Based on %s ratings', $total_rating, 'cl-hotel' ) ), 
                                    esc_html( $total_rating ) 
                                ); 
                            ?>
                        </p>
                    </div>
                </div>
                <?php } ?> 
            </div>
        </div>
    </div>
</div>




