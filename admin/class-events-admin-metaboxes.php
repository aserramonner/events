<?php
/**
 * The metabox-specific functionality of the plugin.
 *
 * @link 		
 * @since 		1.0.0
 *
 * @package 	Events
 * @subpackage 	Events/admin
 */

/**
 * The metabox-specific functionality of the plugin.
 *
 * @package 	Events
 * @subpackage 	Events/admin
 * @author 		Slushman <chris@slushman.com>
 */
class Events_Admin_Metaboxes {

	/**
	 * The post meta data
	 *
	 * @since 		1.0.0
	 * @access 		private
	 * @var 		string 			$meta    			The post meta data.
	 */
	private $meta;

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
	 * Registers metaboxes with WordPress
	 *
	 * @since 	1.0.0
	 * @access 	public
	 */
	public function add_metaboxes($post_type) {

		// add_meta_box( $id, $title, $callback, $screen, $context, $priority, $callback_args );

		add_meta_box(
			'event_edit_meta',
			__('Event data', 'events'),
			array($this, 'render_eventdata_metabox'),
			$post_type,
			'normal',
			'default',
 			array(
				'file' => 'event-info'
			)
		);
	}

    public function render_eventdata_metabox($post, $params) {
		global $post;

		if ( ! is_admin() ) { return; }
		if ( 'el_events' !== $post->post_type ) { return; }

		include( plugin_dir_path( __FILE__ ) . 'partials/events-admin-metabox-' . $params['args']['file'] . '.php' );
	}

	/**
	 * Check each nonce. If any don't verify, $nonce_check is increased.
	 * If all nonces verify, returns 0.
	 *
	 * @since 		1.0.0
	 * @access 		public
	 * @return 		int 		The value of $nonce_check
	 */
	private function check_nonces( $posted ) {

		$nonces 		= array();
		$nonce_check 	= 0;

		$nonces[] 		= 'event_info';

		foreach ( $nonces as $nonce ) {

			if ( ! isset( $posted[$nonce] ) ) { $nonce_check++; }
			if ( isset( $posted[$nonce] ) && ! wp_verify_nonce( $posted[$nonce], $this->plugin_name ) ) { $nonce_check++; }

		}

		return $nonce_check;

	}

	/**
	 * Returns an array of the all the metabox fields and their respective types
	 *
	 * @since 		1.0.0
	 * @access 		public
	 * @return 		array 		Metabox fields and types
	 */
	private function get_metabox_fields() {

		$fields = array();

		$fields[] = array( 'startdate', 'date' );
		$fields[] = array( 'starttime', 'time' );
		$fields[] = array( 'location', 'textarea' );
		$fields[] = array( 'buynow', 'url' );
		$fields[] = array( 'warning', 'textarea' );
	
		return $fields;

	}

	/**
	 * Calls a metabox file specified in the add_meta_box args.
	 *
	 * @since 	1.0.0
	 * @access 	public
	 * @return 	void
	 */
	public function metabox( $post, $params ) {

		if ( ! is_admin() ) { return; }
		if ( 'job' !== $post->post_type ) { return; }

		if ( ! empty( $params['args']['classes'] ) ) {

			$classes = 'repeater ' . $params['args']['classes'];

		}

		include( plugin_dir_path( __FILE__ ) . 'partials/now-hiring-admin-metabox-' . $params['args']['file'] . '.php' );

	} // metabox()

	private function sanitizer( $type, $data ) {

		if ( empty( $type ) ) { return; }
		if ( empty( $data ) ) { return; }

		$return 	= '';
		$sanitizer 	= new Events_Sanitize();

		$sanitizer->set_data( $data );
		$sanitizer->set_type( $type );

		$return = $sanitizer->clean();

		unset( $sanitizer );

		return $return;

	} // sanitizer()

	/**
	 * Saves button order when buttons are sorted.
	 */
	public function save_files_order() {

		check_ajax_referer( 'now-hiring-file-order-nonce', 'fileordernonce' );

		$order 						= $this->meta['file-order'];
		$new_order 					= implode( ',', $_POST['file-order'] );
		$this->meta['file-order'] 	= $new_order;
		$update 					= update_post_meta( 'file-order', $new_order );

		esc_html_e( 'File order saved.', 'now-hiring' );

		die();

	} // save_files_order()

	/**
	 * Sets the class variable $options
	 */
	public function set_meta() {

		global $post;

		if ( empty( $post ) ) { return; }
		if ( 'el_events' != $post->post_type ) { return; }

		$this->meta = get_post_custom( $post->ID );

	} // set_meta()

	/**
	 * Saves metabox data
	 *
	 * Repeater section works like this:
	 *  	Loops through meta fields
	 *  		Loops through submitted data
	 *  		Sanitizes each field into $clean array
	 *   	Gets max of $clean to use in FOR loop
	 *   	FOR loops through $clean, adding each value to $new_value as an array
	 *
	 * @since 	1.0.0
	 * @access 	public
	 * @param 	int 		$post_id 		The post ID
	 * @param 	object 		$object 		The post object
	 * @return 	void
	 */
	public function validate_meta( $post_id, $object ) {

		//wp_die( '<pre>' . print_r( $_POST ) . '</pre>' );

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) { return $post_id; }
		if ( ! current_user_can( 'edit_post', $post_id ) ) { return $post_id; }
		if ( 'el_events' !== $object->post_type ) { return $post_id; }

		$nonce_check = $this->check_nonces( $_POST );

		if ( 0 < $nonce_check ) { return $post_id; }

		$metas = $this->get_metabox_fields();

		foreach ( $metas as $meta ) {

			$name = $meta[0];
			$type = $meta[1];

			$new_value = $this->sanitizer( $type, $_POST[$name] );

			update_post_meta( $post_id, $name, $new_value );

		} // foreach

	}

    /**
	 * Convert a date format to a jQuery UI DatePicker format
	 *
	 * @param string $format a date format
	 * @return string
	 */
	private function datepicker_format($format) {
		return str_replace(
			array(
				'd', 'j', 'l', 'z', // Day.
				'F', 'M', 'n', 'm', // Month.
				'Y', 'y'            // Year.
			),
			array(
				'dd', 'd', 'DD', 'o',
				'MM', 'M', 'm', 'mm',
				'yy', 'y'
			),
			$format);
	}

} // class
