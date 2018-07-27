<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\String_;

class ICal{
    protected $ics = null;

    public function addEvent($summary = null, $uid = null, $status = null,
                             $transparent = null, $rules = null, $from = null,
                             $to = null, $dtStamp = null, $categories = null,
                             $link = null, $location = null, $geo = null,
                             $description = null){
        if($this->ics == null){
            $this->ics =
                'BEGIN:VCALENDAR'."\n".
                'VERSION:2.0'."\n".
                'PRODID:-//events @ META+LAB//Version 1//EN'."\n".
                'CALSCALE:GREGORIAN'."\n".
                'METHOD:PUBLISH'."\n"
            ;
        }

        $this->ics .=
            'BEGIN:VEVENT'."\n".
            'SUMMARY:'.$summary."\n".
            'UID:'.$uid."\n".
            'SEQUENCE:0'."\n".
            'STATUS:'.$status."\n".
            'TRANSP:'.$transparent."\n".
            'RRULE:FREQ='.$rules['frequency'].';INTERVAL='.$rules['interval'].';UNTIL='.$rules['until'].';BYDAY='.$rules['byDay']."\n".
            'DTSTART;America/Los_Angeles:'.$from."\n".
            'DTEND;America/Los_Angeles:'.$to."\n".
            'DTSTAMP:'.$dtStamp."\n".
            'CATEGORIES:'.$categories."\n".
            'CLASS:PUBLIC'."\n"
        ;
        $this->ics .= 'LOCATION;ALTREP=' . ($link ? '"'. $link . '"': null) . ':' . $location."\n";

        $this->ics .=
            'GEO:'.$geo."\n".
            'DESCRIPTION:'.$description."\n".
            'END:VEVENT'."\n"
        ;
    }

    // TODO: see if $event array can hold an array as an element (such as 'rules')
    public function addEventByArray($event){
        if($this->ics == null){
            $this->ics =
                'BEGIN:VCALENDAR'."\n".
                'VERSION:2.0'."\n".
                'PRODID:-//events @ META+LAB//Version 1//EN'."\n".
                'CALSCALE:GREGORIAN'."\n".
                'METHOD:PUBLISH'."\n"
            ;
        }

        $this->ics .=
            'BEGIN:VEVENT'."\n".
            'SUMMARY:'. (array_key_exists('summary', $event)) ? $event['summary'] : null."\n".
            'UID:'. (array_key_exists('uid', $event)) ? $event['uid'] : null."\n".
            'SEQUENCE:0'."\n".
            'STATUS:'. (array_key_exists('status', $event)) ? $event['status'] : null."\n".
            'TRANSP:'. (array_key_exists('transparent', $event)) ? $event['transparent'] : null."\n".
            'RRULE:FREQ='. (array_key_exists('rules', $event)) ?
                ($event['rules']['frequency'].';INTERVAL='.$event['rules']['interval'].';UNTIL='.$event['rules']['until'].';BYDAY='.$event['rules']['byDay']) :
                null."\n".
            'DTSTART;America/Los_Angeles:'. (array_key_exists('from', $event)) ? $event['from'] : null."\n".
            'DTEND;America/Los_Angeles:'. (array_key_exists('to', $event)) ? $event['to'] : null."\n".
            'DTSTAMP:'. (array_key_exists('dtStamp', $event)) ? $event['dtStamp'] : null."\n".
            'CATEGORIES:'. (array_key_exists('categories', $event)) ? $event['categories'] : null."\n".
            'CLASS:PUBLIC'."\n".
            'LOCATION;ALTREP='. ((array_key_exists('link', $event)) ? '"' . $event['link'] .'"' : null) .':'."\n".
                    ((array_key_exists('location', $event)) ? '"' . $event['location'] .'"' : null)."\n".
            'GEO:'. (array_key_exists('geo', $event)) ? $event['geo'] : null."\n".
            'DESCRIPTION:'. (array_key_exists('description', $event)) ? $event['description'] : null."\n".
            'END:VEVENT'."\n"
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