<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://
 * @since      1.0.0
 *
 * @package    Events
 * @subpackage Events/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Events
 * @subpackage Events/public
 * @author     Albert Serra <none>
 */
class Events_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Events_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Events_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/events-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Events_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Events_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/events-public.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Registers all shortcodes at once
	 *
	 * @return [type] [description]
	 */
	public function register_shortcodes() {

		add_shortcode( 'event-list', array( $this, 'list_events' ) );
	}

	/**
	 * Adds a default single view template for an event
	 *
	 * @param 	string 		$template 		The name of the template
	 * @return 	mixed 						The single template
	 */
	public function single_cpt_template( $template ) {

		global $post;

		$return = $template;

	    if ( $post->post_type == 'el_events' ) {

			$return = events_get_template( 'single-event' );

		}

		return $return;

	} // single_cpt_template()

	/**
	 * Processes shortcode list_events
	 *
	 * @param   array	$atts		The attributes from the shortcode
	 *
	 * @uses	get_option
	 * @uses	get_layout
	 *
	 * @return	mixed	$output		Output of the buffer
	 */
	public function list_events( $atts = array() ) {

		ob_start();

		$defaults = array();

		// TODO: Add defaults
		$defaults['loop-template'] 	= $this->plugin_name . '-loop';
		$args   = shortcode_atts( $defaults, $atts, 'event-list' );
		$shared = new Events_Shared( $this->plugin_name, $this->version );
		$items 	= $shared->get_events( $args );		

		include events_get_template( $args['loop-template'] ); 

		$output = ob_get_contents();

		ob_end_clean();

		return $output;
	}
}
