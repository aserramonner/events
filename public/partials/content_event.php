<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$image   = wp_get_attachment_image_src( get_post_thumbnail_id($item->ID), 'full' ); 
$startdate = strtotime($meta['startdate'][0] . " " . $meta['starttime'][0]);
$weekday = date_i18n('D', $startdate);
$day = date_i18n('d', $startdate);
$month = date_i18n('M', $startdate);
$year = date_i18n('Y', $startdate);

$hhmm = date_i18n('G:i', $startdate);

?>
<div class="event concert">
    <div class="event-thumbnail">
        <a href="<?php echo esc_url( get_permalink( $item->ID ) ); ?>"><img src="<?php echo $image[0] ?>"></a>
        <span class="event-date">
            <div class="startdate">
                <div class="event-weekday">
                <?php echo $weekday ?>
                </div>
                <div class="event-day">
                <?php echo $day ?>
                </div>
                <div class="event-month">
                <?php echo $month ?>
                </div>
                <div class="event-year">
                <?php echo $year ?>
                </div>
            </div>
        </span>
        <?php if ('' != $meta['warning'][0]) { ?>
        <p>
        <span>
            <?php echo $meta['warning'][0] ?>
        </span>
        </p>
        <?php } ?>
    </div>

    <div class="event-details">
        <div class="event-title"><h3>
            <?php echo $item->post_title ?>
            </h3>
        </div>
        <?php if ('0:00' != $hhmm) { ?>
        <span class="event-time">
            <?php echo $hhmm ?>
        </span>
        <?php  } ?>
        <span class="event-location">
            <?php echo $meta['location'][0] ?>
        </span>
        <?php if ('' != $meta['buynow'][0]) { ?>
            <p><span>
                <button onclick="parent.open('')";>
                Entrades 
                </button>
            </span></p>
        <?php } ?>
    </div>
</div>
<?php

?>
