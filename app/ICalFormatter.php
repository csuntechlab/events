<?php

namespace App;

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
    protected $rrule ;
    protected $interval ;
    protected $freq;
    protected $eventTime ;
    protected $lastModified ;
    protected $dtStamp ;
    protected $class ;
    protected $created ;
    protected $categories ;
    protected $dtStart ;
    protected $dtEnd ;

    protected $until ;
    protected $location;
    protected $locationAltrep;
    protected $byDay;

    protected $description;
    /**
     * sets global variables for ical parameter
     */
    public function setParamForClass($event,$course)
    {
        $this->uid = $course['classes_id'].'.'.$event['pattern_number'].'.vevent@metalab.csun.edu';
        $this->summary = $course['subject'].' '.$course['catalog_number'].' ('.$course['class_number'].')';
        $this->vAlarmDescription =  $course['subject'].' '.$course['catalog_number'].' starts in 15 minutes';
        $this->description = $event['label'];
    }
    public function setParamForFinal($event, $course)
    {
//        $this->uid = $course['classes_id'].'.'.$event['pattern_number'].'.vevent@metalab.csun.edu';
        $this->uid = $course['classes_id'].'FINAL'.'.vevent@metalab.csun.edu';
        $this->summary = $course['subject'].' '.$course['catalog_number'].' FINAL ('.$course['class_number'].')';
        $this->vAlarmDescription =  $course['subject'].' '.$course['catalog_number'].' FINAL starts in 15 minutes';
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


    public function setParamBySpecifications($status, $trans, $publicOrPrivate, $freq, $interval)
    {
        $this->status = $status;
        $this->transparent = $trans;
        $this->class = $publicOrPrivate;
        $this->freq = $freq;
        $this->interval = $interval;
    }

    /**
     * gets ical parameter
     */
    public function setParamByEvent($event)
    {
        $this->lastModified = $event['updated_at'];
        $this->dtStamp = $event['updated_at'];
        $this->categories = $event['type'];

        $from_date = explode(" ", $event['from_date']);

        $this->dtStart = $from_date[0] . str_replace('h', '00', $event['start_time']) ;
        $this->dtEnd =  $from_date[0] . str_replace('h', '00', $event['end_time']) ;
        $this->rrule = 'WEEKLY';
        $this->interval = '1';

//        $to_date = explode(" ", $event['from_date']);
        $this->until = $event['to_date'];

//        dd($this->until);

        if($event['location_type']=='physical') {
            $this->location =  $event['location'];
            $this->locationAltrep = "http://academics.csun.edu/classrooms/" . $event['location'] . ":" . $event['location'];
        } else {
            $this->location =  'ZOOM';
            $this->locationAltrep = $event['online_url'];
        }

        $this->byDay = $this->setMeetingDays( $event['days'] );
    }

    public function setEvent()
    {
        date_default_timezone_set('America/Los_Angeles');

        $vEvent = new \Eluceo\iCal\Component\Event();

        $vEvent->setUniqueId($this->uid)
            ->setDtStamp( new \DateTime($this->dtStamp) ) //dtStamp 169
            ->setCreated( new \DateTime($this->created) ) // must create
            ->setModified( new \DateTime($this->lastModified) ) // last Modified
            ->setTrans($this->transparent)
            ->setStatus($this->status)
            ->setCategories($this->categories)
            ->setSummary( $this->summary )
            ->setTimezoneString('America/Los_Angeles')
            ->setLocation($this->location,$this->locationAltrep)
            ->setDtStart( new \DateTime($this->dtStart )  )
            ->setDtEnd(new \DateTime( $this->dtEnd ) )
            ->setDescription( $this->description );

        $recurrenceRule = new \Eluceo\iCal\Property\Event\RecurrenceRule();

        $recurrenceRule->setFreq($this->freq)
            ->setInterval($this->interval) // final exam
            ->setByDay($this->byDay)
            ->setUntil( new \DateTime($this->until) );
        $vEvent->setRecurrenceRule($recurrenceRule);
        return $vEvent;
    }

    public function setVAlarm()
    {
        $vAlarm = new \Eluceo\iCal\Component\Alarm();
        $vAlarm->setTrigger('-PT15M');
        $vAlarm->setDescription($this->vAlarmDescription);
        $vAlarm->setAction('DISPLAY');
        return $vAlarm;
    }

    public function setFileName($fileName)
    {
        header('Content-type: text/calendar; charset=utf-8');
        header('Content-Disposition: attachment; filename='.$fileName.'.ics');
    }

    /**
     * Sets ical's 'BYDAY=' input
     */
    public function setMeetingDays( $days )
    {
        $trans = array("M" => "MO,", "T" => "TU,", "W" => "WE,", "R" => "TH,", "F" => "FR,", "S" => "SA," );
        $dayICal = strtr($days , $trans);
        return substr($dayICal, 0 ,-1);
    }


}
