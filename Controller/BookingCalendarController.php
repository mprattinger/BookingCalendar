<?php

require_once(__DIR__ . "/../Services/CalendarService.php");

class BookingCalendarController {

    public function __construct(){
        $this->namespace     = '/mprbc/v1';
        $this->resource_name = 'bcdata';

        $this->calendarService = new CalendarService();
    }

    public function register_routes() {
        register_rest_route( $this->namespace, '/' . $this->resource_name , [
            'methods'   => 'GET',
            'callback'  => [ $this, 'loadBookings' ],
        ]);
    }

    public function loadBookings( $request ) {
        $starting = $request['starting'];
        $ending = $request['ending'];
        $start = date($starting); //date("01." . $m . "." . $y);
        $end = date($ending); //date("t." . $m . "." . $y);

        return $this->calendarService->loadData($start, $end);
    }
}