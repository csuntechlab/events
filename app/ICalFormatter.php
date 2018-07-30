<?php

namespace App;
class ICalFormatter{

    /**
     * TODO: Check Public vs Private Class
     * TODO: CHECK if this is going to be weekly 
     * TODO: Events are either Transparent & Tentative or Opaque & Confirmed. 
     *          For Students or as an individual Office Hour: the event it Transparent & Tentative
     *          For Faculty: the event is Opaque & Confirmed
     * 
     * TODO: “By Appointment Only”
     *          If an Office Hour has a label of “By Appointment Only” no .ics file is created
     * TODO: We need to have a way to record
     *          First day of Instruction
     *          Last day of Instruction
     */


    protected $uid = null;
    protected $summary = null;
    protected $vAlarmDescription = null;
    protected $status = null;
    protected $transparent  = null;
    protected $rrule ;
    protected $interval ;
    protected $freq;

    protected $description; 

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

    /**
     * sets global variables for ical parameter 
     */
    public function setParamForClass($event,$course)
    {
        $this->uid = $course['classes_id'].'.'.$event['pattern_number'].'.vevent@metalab.csun.edu'; 
        $this->summary = $course['subject'].' '.$course['catalog_number'].' ('.$course['class_number'].')';
        $this->vAlarmDescription =  $course['subject'].' '.$course['catalog_number'].' starts in 15 minutes';
        $this->description =  $course['title'];
    }

    /**
     * sets global variables for ical parameter 
     */
    public function setParamForOfficeHours($event,$email)
    {
        $this->uid = $event['entities_id'].'.'.$event['pattern_number'].'.vevent@metalab.csun.edu';
        $this->summary = $summary = 'Office Hours: ' . $email ;
        $this->vAlarmDescription = null;
        $this->description =  $event['label'];
    }

    public function setParamForFinal($event, $course)
    {
        $this->uid = $course['classes_id'].'.'.$event['pattern_number'].'.vevent@metalab.csun.edu';
        $this->summary = $course['subject'].' '.$course['catalog_number'].' FINAL ('.$course['class_number'].')';
        $this->vAlarmDescription =  $course['subject'].' '.$course['catalog_number'].' FINAL starts in 15 minutes';
    }

    public function setParmBySpecifications($status, $trans, $publicOrPrivate, $freq, $interval)
    {
        $this->status = $status;
        $this->transparent = $trans;
        $this->class = $publicOrPrivate;
        $this->freq = $freq;
        $this->interval = $interval;
//        dd($this->interval);
    }

    public function setParamByEvent($event)
    {
        //dd($event);
        $eventTime = date("Y-m-d H:i:s");
        $this->dtStart = '2018-08-08 ' . str_replace('h', '00Z', $event['start_time']) ; // $event['from_date']
        $this->dtEnd =  '2018-08-08 ' . str_replace('h', '00Z', $event['end_time']) ;// $event['from_date']

        $this->lastModified = $eventTime; // $event['updated_at']  
        $this->dtStamp = $eventTime; // $event['updated_at']  

        $this->created = '2018-07-25'; // $event['created_at']
        $this->categories = $event['type'];

        $this->until = '2018-12-12 08:12:10'; // $event['to_date']
        // $this->until = $event['to_date'] ; 

        if($event['location_type']=='physical') {
            $this->location =  $event['location']; 
            $this->locationAltrep = "\""."http://academics.csun.edu/classrooms/" . $event['location'] ."\"". ":" . $event['location'];
        } else {
            $this->location =  'ZOOM'; 
            $this->locationAltrep = $event['online_url'];
        }

        $this->byDay = $this->setMeetingDays( $event['days'] );
    }

    /**
     * gets ical parameter
     */
    public function setEvent()
    {
        $vEvent = new \Eluceo\iCal\Component\Event();

        //dd($vEvent);
        $vEvent->setUniqueId($this->uid)
        ->setDtStamp( new \DateTime($this->dtStamp) ) 
        ->setCreated( new \DateTime($this->created) ) 
        ->setModified( new \DateTime($this->lastModified) ) 
        ->setTimeTransparency($this->transparent)
        ->setStatus($this->status)
        ->setCategories($this->categories)
        ->setSummary( $this->summary )
        ->setTimezoneString('America/Los_Angeles')
        ->setLocation($this->location,$this->locationAltrep)
        ->setDtStart( new \DateTime($this->dtStart )  )
        ->setDtEnd(new \DateTime( $this->dtEnd ) ) 
        ->setDescription($this->description);



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
?>