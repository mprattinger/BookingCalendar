<?php

//namespace MPR\Wordpress\BookingCalendar\Controller;

require_once(__DIR__ . "/../Services/CalendarService.php");

class BookingCalendarController {

    public function __construct(){
        $this->namespace     = '/mprbc/v1';
        $this->resource_name = 'bcdata';

        $this->calendarService = new CalendarService();
    }

    public function register_routes() {
        register_rest_route( $this->namespace, '/' . $this->resource_name . '/(?P<year>[0-9]+)/(?P<month>[0-9]+)', [
            'methods'   => 'GET',
            'callback'  => [ $this, 'loadBookings' ],
            // 'args'      => [
            //     'mprbc_nonce' => [
            //         //'validate_callback' => 'validate'
            //         'validate_callback' => function ($param, $request, $key) {
            //             $test = wp_verify_nonce($param, 'mprbc_nonce');
            //             return false;
            //         }
            //     ]
            // ]
        ]);
    }

    public function loadBookings( $request ) {
        $y = $request['year'];
        $m = $request['month'];
        $start = date("01." . $m . "." . $y);
        $end = date("t." . $m . "." . $y);

        return $this->calendarService->loadEvents($start, $end);
    }

    // private function validate($param, $request, $key){
    //     return true;
    // }
}