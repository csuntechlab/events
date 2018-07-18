<?php

namespace App;

class ICal{
    protected $ics = null;

    public function addEvent($summary = null, $uid = null, $status = null, $transparent = null, $rules = null, $from = null, $to = null, $dtStamp = null, $categories = null, $location = null, $geo = null, $description = null){
        if($this->ics == null){
            $this->ics = '';
        }

        $this->ics .=
            'BEGIN:VCALENDAR'.
            'VERSION:2.0'.
            'PRODID:-//events @ META+LAB//Version 1//EN'.
            'CALSCALE:GREGORIAN'.
            'METHOD:PUBLISH'.
            'BEGIN:VEVENT'.
            'SUMMARY:'.$summary.
            'UID:'.$uid.
            'SEQUENCE:0'.
            'STATUS:'.$status.
            'TRANSP:'.$transparent.
            'RRULE:FREQ='.$rules['frequency'].';INTERVAL='.$rules['interval'].';UNTIL='.$rules['until'].';BYDAY='.$rules['byDay'].
            'DTSTART;'.$from.
            'DTEND;'.$to.
            'DTSTAMP:'.$dtStamp.
            'CATEGORIES:'.$categories.
            'CLASS:PUBLIC'.
            'LOCATION;ALTREP='.$location.':META+LAB'.
            'GEO:'.$geo.
            'DESCRIPTION:'.$description.
            'END:VEVENT'.
            'END:VCALENDAR'
        ;
    }

    public function generateICS(){
        header('Content-type: text/calendar; charset=utf-8');
        header('Content-Disposition: attachment; filename=schedule.ics');

        return $this->ics;
    }

//BEGIN:VCALENDAR
//VERSION:2.0
//PRODID:-//events @ META+LAB//Version 1//EN
//CALSCALE:GREGORIAN
//METHOD:PUBLISH
//BEGIN:VEVENT
//SUMMARY:Office Hours: Steven Fitzgerald
//UID:office-hours.2187.100010526.1.valarm@metalab.csun.edu
//SEQUENCE:0
//STATUS:TENTATIVE
//TRANSP:TRANSPARENT
//RRULE:FREQ=WEEKLY;INTERVAL=1;UNTIL=20181212T000000Z;BYDAY=WE
//DTSTART;TZID=America/Los_Angeles:20180829T110000
//DTEND;TZID=America/Los_Angeles:20180829T115000
//DTSTAMP:20180505T171003
//CATEGORIES:Office Hours
//CLASS:PUBLIC
//LOCATION;ALTREP="http://academics.csun.edu/classrooms/META+LAB":META+LAB
//GEO:34.2373175;-118.533936
//DESCRIPTION:grsregsergsergserg
//END:VEVENT
//END:VCALENDAR

}