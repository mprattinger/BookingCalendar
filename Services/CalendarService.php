<?php

//https://github.com/googleapis/google-api-php-client/blob/master/UPGRADING.md
//https://devsware.wordpress.com/2015/03/28/google-calendar-api-server-to-server-web-application/

$base = __DIR__ . "/../vendor/";

include($base . "autoload.php");
include(__DIR__ . "/../Models/Event.php");

class CalendarService {

    const GOOGLE_AUTH = __DIR__ . "/../auth.json";
    const CALENDAR_ID = "4i6pm6e08b1jnll1au67lkuac0@group.calendar.google.com";

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
        $events = $service->events->listEvents(self::CALENDAR_ID, array("timeMin" => $timeMin, "timeMax" => $timeMax));

        //$ret = new \ArrayObject();
        $ret = array();

        foreach($events as $event){
            $d = new Event();
            $d->summary = $event->summary;
            $d->description = $event->description;
            if($event->start->date == null) $d->starting = $event->start->dateTime;
            else $d->starting = $event->start->date;
            if($event->end->date == null) $d->ending = $event->end->dateTime;
            else$d->ending = $event->end->date;

            array_push($ret, $d);
        }

        return $ret;
    }

}