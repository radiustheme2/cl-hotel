<?php
/**
 * Business Hours
 *
 * @author     RadiusTheme
 * @package    cldirectory/templates
 * @version    1.0.0
 *
 * @var array $business_hours   business hours
 * @var int   $current_week_day Day of the week (0 on Sunday)
 * @var array $options
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Rtcl\Controllers\BusinessHoursController as BHS;
use Rtcl\Helpers\Utility;
use Rtcl\Resources\Options;

global $wp_locale;

?>

<div class="business-hours-widget widget">
    <div class="rtcl-listing-side-title">
		<h3><?php  esc_html_e( "Opening Hours", 'cl-hotel' ); ?></h3>
	</div>
    <div class="time-table-wrapper">
        <?php 
            foreach (Options::get_week_days() as $dayKey => $day) {
                // Display the day as either its initial or abbreviation.
                switch ($options['day_name']) {
                    case 'initial' :
                        $day = $wp_locale->get_weekday_initial($day);
                        break;

                    case 'abbrev' :
                        $day = $wp_locale->get_weekday_abbrev($day);
                        break;
                }
                $dayData = !empty($business_hours[$dayKey]) ? $business_hours[$dayKey] : '';
                if (!BHS::openToday($dayData)) {
                    if ($options['show_closed_day']) {
                        printf('<div class="rtclbh-closed %1$s"><div class="day">%2$s:</div><div class="rtclbh-info" >%3$s</div></div>',
                            sprintf('rtclbh-day-%d%s', absint($dayKey), $current_week_day === $dayKey ? ' rtclbh-active' : ''),
                            esc_attr($day),
                            $current_week_day === $dayKey ? (!empty($options['closed_today_text']) ? esc_html($options['closed_today_text']) : esc_html__('Closed Today', 'cl-hotel'))
                                : (!empty($options['closed_24_text']) ? esc_html($options['closed_24_text']) : esc_html__('Closed', 'cl-hotel'))
                        );
                    }
    
                    // Exit this loop.
                    continue;
                }
                if (BHS::isOpenAllDayLong($dayData)) {
                    printf('<div class="rtclbh-opened %1$s"><div class="day">%2$s:</div><div class="rtclbh-info" >%3$s</div></div>',
                        sprintf('rtclbh-day-%d%s', absint($dayKey), $current_week_day === $dayKey ? ' rtclbh-active' : ''),
                        esc_attr($day),
                        $current_week_day === $dayKey ? (!empty($options['open_today_text']) ? esc_html($options['open_today_text']) : esc_html__('Open Today (24 Hours)', 'cl-hotel'))
                            : (!empty($options['open_24_text']) ? esc_html($options['open_24_text']) : esc_html__('Open (24 Hours)', 'cl-hotel'))
                    );
    
                    // Exit this loop.
                    continue;
                }
                $timePeriods = $dayData['times'];
                // If there are open and close hours recorded for the day, loop thru the open periods.
                foreach ($timePeriods as $periodIndex => $timePeriod) {

                    if (BHS::openPeriod($timePeriod)) {
                        printf('<div class="rtclbh-period %1$s" %2$s><div class="day">%3$s:</div><div class="time-wrapper"><div class="rtclbh-open">%4$s</div><div class="rtclbh-separator">%5$s</div><div class="rtclbh-close">%6$s</div></div></div>',
                            sprintf('rtclbh-day-%d%s%s',
                                absint($dayKey),
                                $current_week_day === $dayKey ? ' rtclbh-active' : '',
                                $options['highlight_open_period'] && $current_week_day === $dayKey && BHS::isOpen($timePeriod['start'], $timePeriod['end']) ? ' rtclbh-opened' : ''
                            ),
                            'data-count="' . absint($periodIndex) . '"',
                            $periodIndex == 0 ? esc_attr($day) : '&nbsp;',
                            esc_html( Utility::formatTime($timePeriod['start'], NULL, 'H:i') ),
                            esc_attr($options['open_close_separator']),
                            esc_html( Utility::formatTime($timePeriod['end'], NULL, 'H:i') )
                        );

                    }

                }
            }
        ?>
        <?php 
                // Whether or not to display the open status message.
            if ($options['show_open_status']) {
                if (BHS::openStatus($business_hours)) {
                    printf('<div class="rtclbh-status rtclbh-status-open">%s</div>', !empty($options['open_status_text']) ? esc_html($options['open_status_text']) : esc_html__('We are currently open.', 'cl-hotel'));
                } else {
                    printf('<div class="rtclbh-status rtclbh-status-closed">%s</div>', !empty($options['close_status_text']) ? esc_html($options['close_status_text']) : esc_html__('Sorry, we are currently closed.', 'cl-hotel'));
                }
            }
        
        ?>
    </div>
</div>