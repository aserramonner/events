<?php

/**
 * Provide the view for a metabox
 *
 * @link 		
 * @since 		1.0.0
 *
 * @package 	Events
 * @subpackage 	Events/admin/partials
 */

wp_nonce_field( $this->plugin_name, 'event_info' );

$atts 					= array();
$atts['class'] 			= 'widefat';
$atts['description'] 	= '';
$atts['id'] 			= 'startdate';
$atts['label'] 			= 'Start date';
$atts['name'] 			= 'startdate';
$atts['placeholder'] 	= '';
$atts['type'] 			= 'text';
$atts['value'] 			= '';

if ( ! empty( $this->meta[$atts['id']][0] ) ) {

	$atts['value'] = $this->meta[$atts['id']][0];
}

//apply_filters( $this->plugin_name . '-field-' . $atts['id'], $atts );

?><p>
<?php

include( plugin_dir_path( __FILE__ ) . $this->plugin_name . '-admin-field-date-picker.php' );

?>
</p>
<?php

$atts 					= array();
$atts['class'] 			= 'widefat';
$atts['description'] 	= '';
$atts['id'] 			= 'starttime';
$atts['label'] 			= 'Start time';
$atts['name'] 			= 'starttime';
$atts['placeholder'] 	= '';
$atts['type'] 			= 'text';
$atts['value'] 			= '';

if ( ! empty( $this->meta[$atts['id']][0] ) ) {

	$atts['value'] = $this->meta[$atts['id']][0];
}

//apply_filters( $this->plugin_name . '-field-' . $atts['id'], $atts );

?><p>
<?php

include( plugin_dir_path( __FILE__ ) . $this->plugin_name . '-admin-field-time-picker.php' );

?>
</p>
<?php

$atts 					= array();
$atts['class'] 			= 'widefat';
$atts['description'] 	= '';
$atts['id'] 			= 'location';
$atts['label'] 			= 'Location';
$atts['name'] 			= 'location';
$atts['placeholder'] 	= '';
$atts['type'] 			= 'text';
$atts['value'] 			= '';

if ( ! empty( $this->meta[$atts['id']][0] ) ) {

	$atts['value'] = $this->meta[$atts['id']][0];

}

?>
<p>
<?php

include( plugin_dir_path( __FILE__ ) . $this->plugin_name . '-admin-field-text.php' );

?>
</p>
<?php

$atts 					= array();
$atts['class'] 			= 'widefat';
$atts['description'] 	= '';
$atts['id'] 			= 'buynow';
$atts['label'] 			= 'Buy now URL';
$atts['name'] 			= 'buynow';
$atts['placeholder'] 	= '';
$atts['type'] 			= 'text';
$atts['value'] 			= '';

if ( ! empty( $this->meta[$atts['id']][0] ) ) {

	$atts['value'] = $this->meta[$atts['id']][0];

}

?>
<p>
<?php

include( plugin_dir_path( __FILE__ ) . $this->plugin_name . '-admin-field-text.php' );

?>

</p>
<?php

$atts 					= array();
$atts['class'] 			= 'widefat';
$atts['description'] 	= '';
$atts['id'] 			= 'warning';
$atts['label'] 			= 'Last minute message';
$atts['name'] 			= 'warning';
$atts['placeholder'] 	= '';
$atts['type'] 			= 'text';
$atts['value'] 			= '';

if ( ! empty( $this->meta[$atts['id']][0] ) ) {

	$atts['value'] = $this->meta[$atts['id']][0];

}

?>
<p>
<?php

include( plugin_dir_path( __FILE__ ) . $this->plugin_name . '-admin-field-text.php' );

?>
