<?php  
/**
 * Review summary summary layout one template
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

use RadiusTheme\CLHotel\Options;
use Rtrs\Modules\Review\Helpers\ReviewFns;
$rating_title = Options::$options['listing_rating_title'];
$avg_rating = ReviewFns::getAvgRatings( get_the_ID() );

?> 

<div class="listingDetails-block mb-30">
    <h3 class="listingDetails-block__heading mb-30"><?php echo esc_html( $rating_title ); ?></h3>
    <div class="listingDetails-block__rating listingDetails-block__rating"> 
        <div class="rtrs-summary rtrs-summary-1"> 
            <?php if ( $avg_rating ) { ?>
                <div class="rtrs-summary-box">
                    <div class="rtrs-rating-box">
                        <div class="rtrs-rating-number">
                            <span class="rtrs-rating"><?php echo esc_html( $avg_rating ); ?></span>
                        </div>
                        <div class="rtrs-rating-icon">
	                        <?php echo ReviewFns::review_stars( $avg_rating ); ?>
                            <div class="rtrs-rating-text"> 
                                <?php 
                                printf(
                                        // translators: %s: Total number of ratings.
                                        esc_html( _n( 'Based on %s rating', 'Based on %s ratings', $total_rating, 'cl-hotel' ) ), 
                                        esc_html( $total_rating ) 
                                    ); 
                                ?> 
                            </div>
                        </div>
                    </div>
                </div>
            <?php } 
            
            if ( isset( $p_meta['recommendation'] ) && $p_meta['recommendation'][0] == '1' ) {

            ?>
            <div class="rtrs-summary-box">
                <div class="rtrs-rating-box">
                    <div class="rtrs-recomnded-icon">
                        <i class="rtrs-thumbs-up"></i>
                    </div>
                    <div class="rtrs-recomnded-content">
                        <span class="rtrs-recomnded-number"> 
                            <?php 
                                $total_recommended = ReviewFns::getTotalRecommendation( get_the_ID() );
                                printf(
                                    // translators: %s: Number of users who recommended.
                                    wp_kses( _n( '<span>%s</span>User', '<span>%s</span>Users', $total_recommended, 'cl-hotel' ), array( 'span' => array() ) ), 
                                    esc_html( $total_recommended ) 
                                ); 
                            ?> 
                        </span>
                        <p class="rtrs-recomnded-text"><?php esc_html_e( 'Recommended this item', 'cl-hotel' ); ?></p>
                    </div>
                </div>
            </div> 
            <?php 
            } //end recommendation

            if ( isset( $p_meta['criteria'] ) && $p_meta['criteria'][0] == 'multi' ) {
            ?> 
            <div class="rtrs-summary-box">
                <div class="rtrs-progress-wrap">
                    <?php foreach( ReviewFns::getCriteriaAvgRatings( get_the_ID() ) as $value ) {
                        if ( !$value['avg'] ) continue;
                        ?>  
                        <div class="rtrs-progress">
                            <div class="trs-progress-top">
                                <label><?php echo esc_html($value['title']); ?></label>
                                <span class="progress-percent">
                                    <?php echo esc_html($value['avg']);  ?>
                                </span>
                            </div>
                            <div class="trs-progress-bottom">
                                <progress class="rtrs-progress-bar service-preogress" value="<?php echo esc_html($value['avg']*20); ?>" max="100"></progress>
                            </div>
                        </div> 
                    <?php } ?>  
                </div>
            </div> 
            <?php } ?>
        </div>
    </div>
</div>