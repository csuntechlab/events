<?php

namespace App;

class ICal{
    protected $ics = null;

    public function addEvent($summary = null, $uid = null, $status = null,
                             $transparent = null, $rules = null, $from = null,
                             $to = null, $dtStamp = null, $categories = null,
                             $location = null, $geo = null, $description = null){
        if($this->ics == null){
            $this->ics =
                'BEGIN:VCALENDAR'.
                'VERSION:2.0'.
                'PRODID:-//events @ META+LAB//Version 1//EN'.
                'CALSCALE:GREGORIAN'.
                'METHOD:PUBLISH'
            ;
        }

        $this->ics .=
            'BEGIN:VEVENT'.
            'SUMMARY:'.$summary.
            'UID:'.$uid.
            'SEQUENCE:0'.
            'STATUS:'.$status.
            'TRANSP:'.$transparent.
            'RRULE:FREQ='.$rules['frequency'].';INTERVAL='.$rules['interval'].';UNTIL='.$rules['until'].';BYDAY='.$rules['byDay'].
            'DTSTART;America/Los_Angeles:'.$from.
            'DTEND;America/Los_Angeles:'.$to.
            'DTSTAMP:'.$dtStamp.
            'CATEGORIES:'.$categories.
            'CLASS:PUBLIC'.
            'LOCATION;ALTREP='.$location.':META+LAB'.
            'GEO:'.$geo.
            'DESCRIPTION:'.$description.
            'END:VEVENT';
    }

    // TODO: see if $event array can hold an array as an element (such as 'rules')
    public function addEventByArray($event){
        if($this->ics == null){
            $this->ics =
                'BEGIN:VCALENDAR'.
                'VERSION:2.0'.
                'PRODID:-//events @ META+LAB//Version 1//EN'.
                'CALSCALE:GREGORIAN'.
                'METHOD:PUBLISH'
            ;
        }

        $this->ics .=
            'BEGIN:VEVENT'.
            'SUMMARY:'. (array_key_exists('summary', $event)) ? $event['summary'] : null.
            'UID:'. (array_key_exists('uid', $event)) ? $event['uid'] : null.
            'SEQUENCE:0'.
            'STATUS:'. (array_key_exists('status', $event)) ? $event['status'] : null.
            'TRANSP:'. (array_key_exists('transparent', $event)) ? $event['transparent'] : null.
            'RRULE:FREQ='. (array_key_exists('rules', $event)) ?
                ($event['rules']['frequency'].';INTERVAL='.$event['rules']['interval'].';UNTIL='.$event['rules']['until'].';BYDAY='.$event['rules']['byDay']) :
                null.
            'DTSTART;America/Los_Angeles:'. (array_key_exists('from', $event)) ? $event['from'] : null.
            'DTEND;America/Los_Angeles:'. (array_key_exists('to', $event)) ? $event['to'] : null.
            'DTSTAMP:'. (array_key_exists('dtStamp', $event)) ? $event['dtStamp'] : null.
            'CATEGORIES:'. (array_key_exists('categories', $event)) ? $event['categories'] : null.
            'CLASS:PUBLIC'.
            'LOCATION;ALTREP='. (array_key_exists('summary', $event)) ? $event['location'].':META+LAB' : null.
            'GEO:'. (array_key_exists('summary', $event)) ? $event['geo'] : null.
            'DESCRIPTION:'. (array_key_exists('summary', $event)) ? $event['description'] : null.
            'END:VEVENT'
        ;
    }

    public function generateICS(){
        if($this->ics != null) {
            $this->ics .= 'END:VCALENDAR';
            header('Content-type: text/calendar; charset=utf-8');
            header('Content-Disposition: attachment; filename=schedule.ics');
        }
        
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