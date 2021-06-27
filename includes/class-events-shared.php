<?php

/**
 * The public & admin-facing shared functionality of the plugin.
 *
 * @link 		
 * @since 		1.0.0
 *
 * @package 	
 * @subpackage 	/includes
 */

/**
 * The public & admin-facing shared functionality of the plugin.
 *
 * @package 	
 * @subpackage 	/includes
 * @author 		Slushman <chris@slushman.com>
 */

 // Prevent direct file access
if ( ! defined ( 'ABSPATH' ) ) { exit; }

class Events_Shared {

	/**
	 * The ID of this plugin.
	 *
	 * @since 		1.0.0
	 * @access 		private
	 * @var 		string 			$plugin_name 		The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since 		1.0.0
	 * @access 		private
	 * @var 		string 			$version 			The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 		1.0.0
	 * @param 		string 			$ 		The name of this plugin.
	 * @param 		string 			$version 			The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Flushes widget cache
	 *
	 * @since 		1.0.0
	 * @access 		public
	 * @param 		int 		$post_id 		The post ID
	 * @return 		void
	 */
	public function flush_widget_cache( $post_id ) {

		if ( wp_is_post_revision( $post_id ) ) { return; }

		$post = get_post( $post_id );

		if ( 'job' == $post->post_type ) {

			wp_cache_delete( $this->plugin_name, 'widget' );

		}

	}

	/**
	 * Returns a post object of portfolio posts
	 *
	 * @param 	array 		$params 			An array of optional parameters
	 * 							types 			An array of portfolio item type slugs
	 * 							quantity		Number of posts to return
	 * @param 	string 		$cache 				String to create a new cache of posts
	 *
	 * @return 	object 		A post object
	 */
	public function get_events( $params, $cache = '' ) {

		$return 	= '';
		$cache_name = $this->plugin_name . '_events';

		if ( ! empty( $cache ) ) {

			$cache_name .= '_' . $cache;
		
        }

		$return = wp_cache_get( $cache_name, $this->plugin_name . '_events' );

		if ( false === $return ) {

			//$args 	= $this->set_args( $params );
			$args = array( 'post_type'    => 'el_events',
                           'meta_key'     => 'startdate',
                           'meta_value'   => date( "Y-m-d" ), // change to how "event date" is stored
                           'meta_compare' => '>',
                           'orderby'      => 'meta_value',
                           'order'        => 'ASC' ); 
            $query 	= new WP_Query( $args );

			if ( is_wp_error( $query ) ) {

				$options = get_option( $this->plugin_name . '-options' );
				$return  = $options['message-no-openings'];

			} else {

				wp_cache_set( $cache_name, $query->posts, $this->plugin_name . '_events', 5 * MINUTE_IN_SECONDS );

				$return = $query->posts;

			}
		}

		return $return;

	}

	/**
	 * Sets the args array for a WP_Query call
	 *
	 * @param 	array 		$params 		Array of shortcode parameters
	 * @return 	array 						An array of parameters for WP_Query
	 */
	private function set_args( $params ) {

		if ( empty( $params ) ) { return; }

		$args = array();

		$args['no_found_rows']			= true;
		$args['orderby'] 				= $params['order'];
		$args['posts_per_page'] 		= absint( $params['quantity'] );
		$args['post_status'] 			= 'publish';
		$args['post_type'] 				= 'job';
		$args['update_post_term_cache'] = false;

		unset( $params['order'] );
		unset( $params['quantity'] );
		unset( $params['listview'] );
		unset( $params['singleview'] );

		if ( empty( $params ) ) { return $args; }

		if ( ! empty( $params['location'] ) ) {

			$args['meta_query'][]['key'] 		= 'job-location';
			$args['meta_query'][]['value'] 		= $params['location'];

			if ( is_array( $params['location'] ) ) {

				$args['meta_query'][]['compare'] = 'IN';

			}

			unset( $params['location'] );

		}

		$args = wp_parse_args( $params, $args );

		return $args;

	} // set_args()

	/**
	 * Registers widgets with WordPress
	 *
	 * @since 		1.0.0
	 * @access 		public
	 */
	public function widgets_init() {

		register_widget( 'events_widget' );

	} // widgets_init()

} // class