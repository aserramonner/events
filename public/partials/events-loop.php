<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the archive loop.
 *
 * @link       
 * @since      1.0.0
 *
 * @package    
 * @subpackage /public/partials
 */

/**
 * now-hiring-before-loop hook
 *
 * @hooked 		list_wrap_start 		10
 */
//do_action( 'now-hiring-before-loop' );
?>
<link rel="stylesheet" id="event-list-css" href="wp-content/plugins/events/public/css/events-public.css?ver=5.7.2" type="text/css" media="all">

<div class="event-list">
<div class="event-list-view">
<?php
foreach ( $items as $item ) {

	$meta = get_post_custom( $item->ID );

	/**
	 * now-hiring-before-loop-content hook
	 *
	 * @param 		object  	$item 		The post object
	 *
	 * @hooked 		content_wrap_start 		10
	 */
//	do_action( 'now-hiring-before-loop-content', $item, $meta );

		/**
		 * now-hiring-loop-content hook
		 *
		 * @param 		object  	$item 		The post object
		 *
		 * @hooked 		content_job_title 		10
		 * @hooked 		content_job_location 	15
		 */
//		do_action( 'events-loop-content', $item, $meta );
        include events_get_template( 'content_event' );

	/**
	 * now-hiring-after-loop-content hook
	 *
	 * @param 		object  	$item 		The post object
	 *
	 * @hooked 		content_link_end 		10
	 * @hooked 		content_wrap_end 		90
	 */
//	do_action( 'now-hiring-after-loop-content', $item, $meta );

}

?>
</div>
</div>
<?php

/**
 * now-hiring-after-loop hook
 *
 * @hooked 		list_wrap_end 			10
 */
//do_action( 'now-hiring-after-loop' );
