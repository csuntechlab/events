<?php

class ICalFormatter{

    /**
     * TODO: Check Public vs Private Class
     * TODO: CHECK if this is going to be weekly 
     */


    protected $uid = null;
    protected $summary = null;
    protected $vAlarmDescription = null;
    protected $status = null;
    protected $transparent  = null;

    /**
     * sets global variables for ical parameter 
     */
    public function setParamForClassAndFinal($event,$course)
    {
        $this->uid = $course['classes_id'].'.'.$event['pattern_number'].'.vevent@metalab.csun.edu'; 
        $this->summary = $course['subject'].' '.$course['catalog_number'].' ('.$course['class_number'].')';
        $this->vAlarmDescription =  $course['subject'].' '.$course['catalog_number'].' starts in 15 minutes';
        $this->status = 'CONFIRMED';
        $this->transparent = 'OPAQUE';
    }

    /**
     * sets global variables for ical parameter 
     */
    public function setParamForOfficeHours($event,$email)
    {
        $this->uid = $event['entities_id'].'.'.$event['pattern_number'].'.vevent@metalab.csun.edu';
        $this->summary = $summary = 'Office Hours: ' . $email ;
        $this->vAlarmDescription = null;
        $this->status = 'TENTATIVE';
        $this->transparent = 'TRANSPARENT';
    }

    /**
     * gets ical parameter
     */
    public function setEvent($vEvent, $event, $addAlarm)
    {
        $eventTime = date("Y-m-d H:i:s");

        $lastModified = $eventTime;
        $dtStamp = $eventTime;
        $class = 'PUBLIC';
        $created = '2018-07-25';

        $categories = $event['type'];
        $dtStart = '2018-08-08 ' . str_replace('h', '00Z', $event['start_time']) ;
        $dtEnd =  '2018-08-08 ' . str_replace('h', '00Z', $event['end_time']) ;
        $rrule = 'WEEKLY';
        $interval = '1';
        $until = '2018-12-12 08:12:10';


        if($event['location_type']=='physical') {
            $location =  $event['location']; 
            $locationAltrep = "http://academics.csun.edu/classrooms/" . $event['location'] . ":" . $event['location'];
        } else {
            $location =  'ZOOM'; 
            $locationAltrep = $event['online_url'];
        }

        $byDay = $this->setMeetingDays($event['days'] );

        $vEvent->setUniqueId($this->uid)
        ->setDtStamp( new \DateTime($dtStamp) ) //dtStamp 169
        ->setCreated( new \DateTime($created) ) // must create
        ->setModified( new \DateTime($lastModified) ) // last Modified
        ->setTrans($this->transparent)
        ->setStatus($this->status)
        ->setCategories($categories)
        ->setSummary( $this->summary )
        ->setTimezoneString('America/Los_Angeles')
        ->setLocation($location,$locationAltrep)
        ->setDtStart( new \DateTime($dtStart )  )
        ->setDtEnd(new \DateTime( $dtEnd ) ) ;

        $recurrenceRule = new \Eluceo\iCal\Property\Event\RecurrenceRule();

        $recurrenceRule->setFreq(\Eluceo\iCal\Property\Event\RecurrenceRule::FREQ_WEEKLY);
        $recurrenceRule->setInterval(1); // final exam 
        $recurrenceRule->setByDay($byDay);
        $recurrenceRule->setUntil( new \DateTime($until) );

        $vEvent->setRecurrenceRule($recurrenceRule);

        return $vEvent;
    }

    public function setVAlarm ($vAlarm)
    {
        $vAlarm = new \Eluceo\iCal\Component\Alarm();
        $vAlarm->setTrigger('-PT15M');
        $vAlarm->setDescription($this->vAlarmDescription);
        $vAlarm->setAction('DISPLAY');

        return $vAlarm;
    }


    /**
     * Sets ical's 'BYDAY=' input
     */
    public function setMeetingDays( $days )
    { 
        $daysArray = str_split($days);

        $trans = array("M" => "MO,", "T" => "TU,", "W" => "WE,", "R" => "TH,", "F" => "FR,", "S" => "SA," );

        $dayICal = strtr($days, $trans);

        if($dayICal[( strlen($dayICal)-1) ] === ','){
            $dayICal[( strlen($dayICal)-1) ] = " ";
        }

        return $dayICal;

    }


}
    