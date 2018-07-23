<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

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
    public function getParam($event)
    {
        $icalParam = [];

        $dayICal = $this->setMeetingDays($event['days']);
            
        $icalParam['uid'] = $this->uid;
        $icalParam['dtStamp'] = '20180505T171003Z';
        $icalParam['created'] = '20180505T170922Z';
        $icalParam['lastModified'] = '20180505T171003Z';
        $icalInfo['sequence'] = '0'; //check for class and final exam importance 
        $icalParam['class'] = 'PUBLIC';
        $icalParam['transparent'] = $this->transparent;
        $icalParam['status'] = $this->status;
        $icalParam['categories'] = $event['type']; 
        $icalParam['summary'] = $this->summary;
        
        if($event['location_type']=='physical') {
            $icalParam['locationAltRep'] = 'http://academics.csun.edu/classrooms/' . $event['location'] . ':' . $event['location'];
        }
        else {
            $icalParam['locationAltRep'] = $event['online_url'];
        }
        // $icalParam['locationAltRep'] = 'http://academics.csun.edu/classrooms/'.$event['location'].':'.$event['location'];
        $icalParam['geo'] = '34.2373175;-118.533936'; 
        $icalParam['description'] = null;
        $icalParam['dtstart'] = 'America/Los_Angeles:20180827T130000';
        $icalParam['dtend'] = 'America/Los_Angeles:20180827T135000';
        $icalParam['rRule'] = 'WEEKLY';
        $icalParam['interval'] = '1';
        $icalParam['until'] = '20181212T135000Z';
        $icalParam['byDay'] = $dayICal; 
        $icalParam['vAlarmDescription'] = $this->vAlarmDescription;

        return $icalParam;
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
