<?php
/**
 * The template for displaying all single events.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Events
 */

if ( ! defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly

/**
 * Get a custom header-employee.php file, if it exists.
 * Otherwise, get default header.
 */
get_header( 'events' );

$meta = get_post_custom( $item->ID );

$image   = wp_get_attachment_image_src( get_post_thumbnail_id($item->ID), 'full' ); 
$startdate = strtotime($meta['startdate'][0] . " " . $meta['starttime'][0]);
$weekday = date_i18n('D', $startdate);
$day = date_i18n('d', $startdate);
$month = date_i18n('M', $startdate);
$year = date_i18n('Y', $startdate);

$hhmm = date_i18n('G:i', $startdate);

$buylink = $meta['buynow'][0];
$location = $meta['location'][0];

?>
<div class="event-list">
<div class="event-single-wrapper">

<div class="event-single-flex">
    <div class="event-single-content">
        <div class="event-single-title">
            <h2><?php echo $event->title; ?></h2>
        </div>
        <div class="event-default-feature-image">
            <div class="event-event-thumbnail">
<img src="<?php echo $image[0]; ?>" class="attachment-full size-full wp-post-image" alt="" sizes="(max-width: 1920px) 100vw, 1920px" width="1920" height="870">
            </div>
        </div>
        <div class="event-single-feature-date-time-location-wrapper">
                <div class="event-single-feature-date-location">
                    <div class="f-ico"><i class="fa fa-calendar"></i></div>
                    <div class='f-dtl'>
                        <h3>
                            Data
                        </h3>
                        <p><?php echo $day.'/'.$month.'/'.$year; ?></p>
                    </div>
                </div>
                <div class="event-single-feature-time">
                    <div class="f-ico"><i class="fa fa-clock-o"></i></div>
                    <div class='f-dtl'>
                        <h3>
                            Hora
                        </h3>
                        <p><?php echo $hhmm; ?></p>
                    </div>
                </div>
               <div class="event-single-feature-date-location">
                    <div class="f-ico"><i class="fa fa-map-marker"></i></div>
                    <div class='f-dtl'>
                        <h3>
                           Lloc
                        </h3>
                        <p>
                        <?php echo $location; ?>
                        </p>
                    </div>
                </div>
        </div>
        <div class="event-single-feature-content">
			 <p>
               <?php echo wpautop($content); ?>
	         </p>
        </div>
    </div>
    <div class="event-sidebar">
        <?php if ($buylink!="") { ?>
            <div class="event-sidebag-buy">
                <div class="f-ico"><i class="fa fa-map-marker"></i></div>
                    <div class='f-dtl'>
                        <h3>
                           
                        </h3>
                        <p>
                        <?php echo $buylink; ?>
                        </p>
                    </div>
                    </div>
                    </div>
        <?php } ?>

        <div class="event-sidebar-map">
            <h3>
                Mapa
            </h3>
      <div class="event-gmap-sec">
         <iframe id="gmap_canvas" src="https://maps.google.cat/maps?q=<?php echo $location; ?>&t=&z=19&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" style='width: 100%;min-height: 250px;'></iframe>
      </div>

        </div>
    </div>
</div>
</div>
</div>
<?php

get_footer( 'job' );