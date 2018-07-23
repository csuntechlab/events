<?php

namespace App;

use Carbon\Carbon;

class ICal{
    protected $ics = null;

    protected $fileName = null;

    public function setFileName($fileName)
    {
        $this->fileName =$fileName;
    }

    public function addEvent( $icalParam,$addAlarm)
    {
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
            'UID:'.$icalParam['uid']."\n".
            'DTSTAMP:'.$icalParam['dtStamp']."\n".
            'CREATED:'.$icalParam['created']."\n".
            'LAST-MODIFIED:'.$icalParam['lastModified']."\n".
            'CLASS:'.$icalParam['class']."\n".
            'TRANSP:'.$icalParam['transparent']."\n".
            'STATUS:'.$icalParam['status']."\n".
            'CATEGORIES:'.$icalParam['categories']."\n".
            'SUMMARY:'.$icalParam['summary']."\n".
            'LOCATION;ALTREP='.$icalParam['locationAltRep']."\n".
            'GEO:'.$icalParam['geo']."\n".
            'DESCRIPTION:'.$icalParam['description']."\n".
            'DTSTART;TZID='.$icalParam['dtstart']."\n".
            'DTEND;TZID='.$icalParam['dtend']."\n".
            'RRULE:FREQ='.$icalParam['rRule'].
            ';INTERVAL='.$icalParam['interval'].
            ';UNTIL='.$icalParam['until'].
            ';BYDAY='.$icalParam['byDay']."\n";

            if($addAlarm)
            {
                $this->ics .=
                    'BEGIN:VALARM'."\n".
                    'UID:'.$icalParam['uid']."\n".
                    'TRIGGER:-PT15M'."\n".
                    'DESCRIPTION:'.$icalParam['summary'].' begins in 15 minutes!'."\n".
                    'ACTION:DISPLAY'."\n".
                  'END:VALARM'."\n";
            }
            $this->ics .= 'END:VEVENT'."\n";
    }

    public function addAlarm($icalParam)
    {
        $this->ics .=
            'BEGIN:VALARM'."\n".
            'UID:'.$icalParam['uid']."\n".
            'TRIGGER:-PT15M'."\n".
            'DESCRIPTION:'.$icalParam['vAlarmDescription']."\n".
            'ACTION:DISPLAY'."\n".
            'END:VALARM'."\n";
    }

    public function generateICS()
    {
        if($this->ics != null) {
           $this->ics .= 'END:VCALENDAR';
           header('Content-type: text/calendar; charset=utf-8');
           header('Content-Disposition: attachment; filename='.$this->fileName.'.ics');
       }
        return $this->ics;
    }

}