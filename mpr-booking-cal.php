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

putenv('GOOGLE_APPLICATION_CREDENTIALS=C:\\Users\\mprat\\OneDrive\\Projekte\\Mani\\Kalendar-effcb32923b4.json');

require "vendor/autoload.php";

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$log = new Logger('name');
$log->pushHandler(new StreamHandler(ABSPATH . '/log/mpr.log', Logger::WARNING));

require_once("MPR-Booking-Calendar.php");
require_once("Controller/BookingCalendarController.php");
require_once("Services/CalendarService.php");

function load_scripts(){
    $ftime = rand(1000, 9000);

    $link = plugins_url( '/assets/css/mpr-booking-calendar.css', __FILE__ );
    wp_enqueue_style( 'mpr-booking-calendar-style', $link);

    wp_register_script('mpr-booking-calendar', plugins_url( '/assets/js/mpr-booking-calendar.js', __FILE__ ));
    wp_localize_script('mpr-booking-calendar', 'mprbcData', [
        'endpoint' => esc_url_raw(rest_url('/mprbc/v1')),
        // 'nonces' => [
        //     'mprbc_nonce' => wp_create_nonce('mprbc_nonce'),
        //     'wp_rest'   => wp_create_nonce('wp_rest')
        // ]
    ]);
    wp_enqueue_script( 'mpr-booking-calendar', plugins_url( '/assets/js/mpr-booking-calendar.js', __FILE__ ), array(), $ftime, true);

}
add_action( 'wp_enqueue_scripts', 'load_scripts' );

// register BEC_Weather_Widget
add_action("widgets_init", function(){
    register_widget("MPR_BookingCalendar");
});

function mpr_bc_register_controller_routes()
{
	$controller = new BookingCalendarController();
	$controller->register_routes();
}
add_action('rest_api_init', 'mpr_bc_register_controller_routes');

$log->warning("Finished loading the plugin..");

// $test = new CalendarService();
// $start = date("01.m.Y");
// $end = date("t.m.Y");
// $events =$test->loadEvents($start, $end);