<?php

namespace App;

class ICal{
    protected $ics = null;

    public function addEvent( $icalParam)
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
            'TRANSP:'.$icalParam['transpartent']."\n".
            'STATUS:'.$icalParam['status']."\n".
            'CATEGORIES:'.$icalParam['catagories']."\n".
            'SUMMARY:'.$icalParam['summary']."\n".
            'LOCATION;ALTREP='.$icalParam['locationAltRep']."\n".
            'GEO:'.$icalParam['geo']."\n".
            'DESCRIPTION:'.$icalParam['desription']."\n".
            'DTSTART;TZID='.$icalParam['dtstart']."\n".
            'DTEND;TZID='.$icalParam['dtend']."\n".
            'RRULE:FREQ='.$icalParam['rRule']."\n".
            ';INTERVAL='.$icalParam['interval']."\n".
            ';UNTIL'.$icalParam['until']."\n".
            ';BYDAY'.$icalParam['byDay']."\n".
            'END:VEVENT';
    }

    public function generateICS()
    {
        if($this->ics != null) {
            $this->ics .= 'END:VCALENDAR';
            header('Content-type: text/calendar; charset=utf-8');
            header('Content-Disposition: attachment; filename=schedule.ics');
        }
        
        return $this->ics;
    }

}