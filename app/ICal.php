<?php

namespace App;

class ICal{

    protected $summary;
//    'Office Hours: Steven Fitzgerald'
    protected $uid;
//    'office-hours.2187.100010526.1.valarm@metalab.csun.edu'
    protected $status;
//    'TENTATIVE'
    protected $transparent;
//    'TRANSPARENT'

    protected $rules = [
        'frequency' => '',
//        'WEEKLY'
        'interval' => '',
//        '1'
        'until' => '',
//        '20181212T135000Z'
        'byDay' => ''
//        'MO,WE'
    ];

    protected $from;
//    'TZID=America/Los_Angeles:20180829T110000'
    protected $to;
//    'TZID=America/Los_Angeles:20180829T115000'
    protected $dtStamp;
//    '20180505T171003'
    protected $categories;
//    'Office Hours'
    protected $location;
//    '"http://academics.csun.edu/classrooms/META+LAB"'
    protected $geo;
//    '34.2373175;-118.533936'
    protected $description;
//    'grsregsergsergserg'

    public function __construct($summary = null, $uid = null, $status = null, $transparent = null, $rules = null, $from = null, $to = null, $dtStamp = null, $categories = null, $location = null, $geo = null, $description = null)
    {
        $this->summary = $summary;
        $this->uid = $uid;
        $this->status = $status;
        $this->transparent = $transparent;

        $this->rules['frequency'] = $rules['frequency'];
        $this->rules['interval'] = $rules['interval'];
        $this->rules['until'] = $rules['until'];
        $this->rules['byDay'] = $rules['byDay'];

        $this->from = $from;
        $this->to = $to;
        $this->dtStamp = $dtStamp;
        $this->categories = $categories;

        $this->location = $location;
        $this->geo = $geo;
        $this->description = $description;
    }

    public function generateICS(){

        $ics =
            'BEGIN:VCALENDAR'.
            'VERSION:2.0'.
            'PRODID:-//events @ META+LAB//Version 1//EN'.
            'CALSCALE:GREGORIAN'.
            'METHOD:PUBLISH'.
            'BEGIN:VEVENT'.
            'SUMMARY:'.$this->summary.
            'UID:'.$this->uid.
            'SEQUENCE:0'.
            'STATUS:'.$this->status.
            'TRANSP:'.$this->transparent.
            'RRULE:FREQ='.$this->rules['frequency'].';INTERVAL='.$this->rules['interval'].';UNTIL='.$this->rules['until'].';BYDAY='.$this->rules['byDay'].
            'DTSTART;'.$this->from.
            'DTEND;'.$this->to.
            'DTSTAMP:'.$this->dtStamp.
            'CATEGORIES:'.$this->categories.
            'CLASS:PUBLIC'.
            'LOCATION;ALTREP='.$this->location.':META+LAB'.
            'GEO:'.$this->geo.
            'DESCRIPTION:'.$this->description.
            'END:VEVENT'.
            'END:VCALENDAR'
        ;
        header('Content-type: text/calendar; charset=utf-8');
        header('Content-Disposition: attachment; filename=test.ics');

        return $ics;
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