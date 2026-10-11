<?php
/**
 * Agent Archive
 *
 * @package rtcl-agent/templates
 * @version 1.0.0
 */

use Rtcl\Helpers\Functions as RtclFunctions;
use RtclStore\Helpers\Functions as StoreFunctions;

defined('ABSPATH') || exit;

get_header('agent');

/**
 * Hook: rtcl_before_main_content.
 *
 * @hooked rtcl_output_content_wrapper - 10 (outputs opening divs for the content)
 */
do_action('rtcl_before_main_content');

?>
<div class="container">
	<div class="row agent-archive-wrap">
		<div class="col-lg-12">
			<?php
				if (rtcl()->wp_query()->have_posts()) {


					do_action('rtcl_before_agent_loop');

					rtcl_agent_loop_start();

					while (rtcl()->wp_query()->have_posts()) : rtcl()->wp_query()->the_post();

						/**
						 * Hook: rtcl_agent_loop.
						 */
						do_action('rtcl_agent_loop');
						RtclFunctions::get_template_part('content', 'agent');

					endwhile;

					rtcl_agent_loop_end();

					/**
					 * Hook: rtcl_after_store_loop.
					 *
					 * @hooked TemplateHook::pagination() - 10
					 */
					do_action('rtcl_after_agent_loop');
				} else {
					/**
					 * Hook: rtcl_no_agent_found.
					 *
					 * @hooked no_agent_found - 10
					 */
					do_action('rtcl_no_agent_found');
				}
			?>
		</div>
	</div>
</div>

<?php 
/**
 * Hook:  rtcl_after_main_content.
 *
 *  @hooked rtcl_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action('rtcl_after_main_content');

get_footer('agent');