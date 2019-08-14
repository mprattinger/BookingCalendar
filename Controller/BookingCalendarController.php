<?php

class BookingCalendarController {

    public function __construct(){
        $this->namespace     = '/mprbc/v1';
        $this->resource_name = 'bcdata';
    }

    public function register_routes() {
        register_rest_route( $this->namespace, '/' . $this->resource_name . '/(?P<year>[0-9]+)/(?P<month>[0-9]+)', [
            'methods'   => 'GET',
            'callback'  => [ $this, 'loadBookings' ],
            'args'      => [
                'mprbc_nonce' => [
                    'validate_callback' => function($mprbc_nonce) {
                        // return wp_verify_nonce($mprbc_nonce, 'mprbc_nonce');
                        return false;
                    }
                ]
            ]
        ]);
    }

    public function loadBookings( $request ) {
        
        $object = new stdClass();

        $object->year = $request['year'];
        $object->month = $request['month'];

        return $object;
    }
}