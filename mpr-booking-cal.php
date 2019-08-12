
<?php
/**
* Plugin Name: Booking Calender with Google Cal
* Plugin URI: https://www.yourwebsiteurl.com/
* Description: This widget s
* Version: 1.0
* Author: Michael Prattinger
* Author URI: http://yourwebsiteurl.com/
**/

require_once("MPR-Booking-Calendar.php");

function load_scripts(){

}
add_action( 'wp_enqueue_scripts', 'load_scripts' );

// register BEC_Weather_Widget
add_action("widgets_init", function(){
    register_widget("MPR-Booking-Calendar");
});