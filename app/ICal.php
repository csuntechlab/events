<?php

namespace App;

class ICal{
    protected $ics = null;

    protected $fileName = null;

    public function setFileName($fileName)
    {
        $this->fileName = $fileName;
    }

    public function addEvent($icalParam,$addAlarm)
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
            'BEGIN:VEVENT'."\n"."\t".
            'UID:'.$icalParam['uid']."\n"."\t".
            'DTSTAMP:'.$icalParam['dtStamp']."\n"."\t".
            'CREATED:'.$icalParam['created']."\n"."\t".
            'LAST-MODIFIED:'.$icalParam['lastModified']."\n"."\t".
            'CLASS:'.$icalParam['class']."\n"."\t".
            'TRANSP:'.$icalParam['transparent']."\n"."\t".
            'STATUS:'.$icalParam['status']."\n"."\t".
            'CATEGORIES:'.$icalParam['categories']."\n"."\t".
            'SUMMARY:'.$icalParam['summary']."\n"."\t".
            'LOCATION;ALTREP='.$icalParam['locationAltRep']."\n"."\t".
            'GEO:'.$icalParam['geo']."\n"."\t".
            'DESCRIPTION:'.$icalParam['description']."\n"."\t".
            'DTSTART;TZID='.$icalParam['dtstart']."\n"."\t".
            'DTEND;TZID='.$icalParam['dtend']."\n"."\t".
            'RRULE:FREQ='.$icalParam['rRule']."\n"."\t".
            ';INTERVAL='.$icalParam['interval']."\n"."\t".
            ';UNTIL='.$icalParam['until']."\n"."\t".
            ';BYDAY='.$icalParam['byDay']."\n".
            'END:VEVENT'."\n";

            if($addAlarm){   
                $this->addAlarm($icalParam);
            }
    }

    public function addAlarm($icalParam)
    {
        $this->ics .=
            'BEGIN:VALARM'."\n"."\t".
            'UID:'.$icalParam['uid']."\n"."\t".
            'TRIGGER:-PT15M'."\n"."\t".
            'DESCRIPTION:'.$icalParam['vAlarmDescription']."\n"."\t".
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