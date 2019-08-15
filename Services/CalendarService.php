<?php 

//https://github.com/googleapis/google-api-php-client/blob/master/UPGRADING.md
//https://devsware.wordpress.com/2015/03/28/google-calendar-api-server-to-server-web-application/

$base = __DIR__ . "/../vendor/";
include($base . "autoload.php");

class CalendarService {

    public function loadCalendar() {
        
        $scopes = array("https://www.googleapis.com/auth/calendar", "https://www.googleapis.com/auth/calendar.readonly");

        
        $client = new Google_Client();
        $client->setApplicationName(‘TestCalendarAPI’);
        $client->setAssertionCredentials($credentials);
        $client->setAuthConfig('/path/to/service-account.json');

        if($client->getAuth()->isAccessTokenExpired())
        $client->getAuth()->refreshTokenWithAssertion();

        $service = new Google_Service_Calendar($client);

        $list = $service->calendarList->listCalendarList();
    }

}