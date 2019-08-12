<?php
/**
* Plugin Name: Booking Calender with Google Cal
* Plugin URI: https://www.yourwebsiteurl.com/
* Description: This widget s
* Version: 1.0
* Author: Michael Prattinger
* Author URI: http://yourwebsiteurl.com/
**/

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}

require_once("MPR-Booking-Calendar.php");

function load_scripts(){
    $ftime = rand(1000, 9000);

    $link = plugins_url( '/css/mpr-booking-calendar.css', __FILE__ );
    wp_enqueue_style( 'mpr-booking-calendar-style', $link);

    wp_register_script('mpr-booking-calendar', plugins_url( '/js/mpr-booking-calendar.js', __FILE__ ));

    wp_enqueue_script( 'mpr-booking-calendar', plugins_url( '/js/mpr-booking-calendar.js', __FILE__ ), array(), $ftime, true);
}
add_action( 'wp_enqueue_scripts', 'load_scripts' );

// register BEC_Weather_Widget
add_action("widgets_init", function(){
    register_widget("MPR_BookingCalendar");
});