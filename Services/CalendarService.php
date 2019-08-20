<?php

$base = __DIR__ . "/../vendor/";

include($base . "autoload.php");
include(__DIR__ . "/../Models/Event.php");

class CalendarService {

    const GOOGLE_AUTH = __DIR__ . "/../auth.json";

    public function __construct()
    {
        $optionsRaw = get_option("widget_mpr_bookingcalendar");
        $options = $optionsRaw[2];

        if(!empty($options['mpr-bc-calid']))
        $this->calendarId = $options['mpr-bc-calid'];
    }

    public function loadEvents($start, $end) {

        $scopes = array("https://www.googleapis.com/auth/calendar", "https://www.googleapis.com/auth/calendar.readonly",
        "https://www.googleapis.com/auth/calendar.events.readonly", "https://www.googleapis.com/auth/calendar.events");


        $client = new Google_Client();
        $client->setApplicationName("TestCalendarAPI");
        $client->setAuthConfig(self::GOOGLE_AUTH);

        $client->setScopes($scopes);

    //    if($client->getAuth()->isAccessTokenExpired())
        // $client->getAuth()->refreshTokenWithAssertion();
        $client->authorize();


       $service = new Google_Service_Calendar($client);

        $timeMin = date("c", strtotime($start));
        $timeMax = date("c", strtotime($end));
        //$list =  $service->calendarList->listCalendarList();
        $events = $service->events->listEvents($this->calendarId, array("timeMin" => $timeMin, "timeMax" => $timeMax));

        //$ret = new \ArrayObject();
        $ret = array();

        foreach($events as $event){
            $d = new Event();
            $d->summary = $event->summary;
            $d->description = $event->description;
            if($event->start->date == null) $d->starting = $event->start->dateTime;
            else $d->starting = $event->start->date;
            if($event->end->date == null) $d->ending = $event->end->dateTime;
            else {
                $endd = date_create($d->ending = $event->end->date);
                $endd->sub(new DateInterval("P1D"));
                $d->ending = $endd->format("Y-m-d");
            }
            array_push($ret, $d);
        }

        return $ret;
    }

}