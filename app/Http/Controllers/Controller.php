<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

use Eluceo\iCal\Property\Event\RecurrenceRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\ICal;

class Controller extends BaseController
{
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
    public function setEvent(\Eluceo\iCal\Component\Event $vEvent,$event)
    {
        $eventTime = date("Y-m-d H:i:s");
        $lastModified = $eventTime;
        $dtStamp = $eventTime;
        $class = 'PUBLIC';
        $created = '2018-07-25';
        $transparent = 'OPAQUE';
        $status = 'CONFIRMED';
        $categories = $event['type'];

        if($event['location_type']=='physical') {
            $location =  $event['location']; 
            $locationAltrep = "http://academics.csun.edu/classrooms/" . $event['location'] . ":" . $event['location'];
        } else {
            $location =  'ZOOM'; 
            $locationAltrep = $event['online_url'];
        }
        $dtStart = '2018-08-08 ' . str_replace('h', '00Z', $event['start_time']) ;
        $dtEnd =  '2018-08-08 ' . str_replace('h', '00Z', $event['end_time']) ;
        $rrule = 'WEEKLY';
        $interval = '1';
        $until = '2018-12-12 08:12:10';
        $icalParam = [];
        $byDay = $this->setMeetingDays($event['days'] );

        $vEvent
        ->setUniqueId($uid)
        ->setDtStamp( new \DateTime($dtStamp) ) //dtStamp 169
        ->setCreated( new \DateTime($created) ) // must create
        ->setModified( new \DateTime($lastModified) ) // last Modified
        ->setTrans($transparent)
        ->setStatus($status)
        ->setCategories($categories)
        ->setSummary( $summary )
        ->setTimezoneString('America/Los_Angeles')
        ->setLocation($location,$locationAltrep)
        ->setDtStart( new \DateTime($dtStart )  )
        ->setDtEnd(new \DateTime( $dtEnd ) )
        ;
        $recurrenceRule = new \Eluceo\iCal\Property\Event\RecurrenceRule();
        $recurrenceRule->setFreq(\Eluceo\iCal\Property\Event\RecurrenceRule::FREQ_WEEKLY);
        $recurrenceRule->setInterval(1); // final exam 
        $recurrenceRule->setByDay($byDay);
        $recurrenceRule->setUntil( new \DateTime($until) );



        // return $icalParam;

    }


    /**
     * Sets ical's 'BYDAY=' input
     */
    public function setMeetingDays( $days )
    { 
        $dayICal = "";

        $daysArray = str_split($days);

        foreach($daysArray as $day){
            if($day === 'M' ){
                $dayICal .= 'MO,';
            }
            else if($day === 'T' ){
                $dayICal .= 'TU,';
            }
            else if($day === 'W' ){
                $dayICal .= 'WE,';
            }
            else if($day === 'R' ){
                $dayICal .= 'TH,';
            }
            else if($day === 'F' ){
                $dayICal .= 'FR,';
            }
            else if($day === 'S' ){
                $dayICal .= 'SAT,';
            }
            else{
                $dayICal .= 'NULL';
            }
        }

        if($dayICal[( strlen($dayICal)-1) ] === ','){
            $dayICal[( strlen($dayICal)-1) ] = " ";
        }

        return $dayICal;

    }

}
