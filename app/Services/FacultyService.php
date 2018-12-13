<?php

namespace App\Services;

use App\Contracts\FacultyContract;
use App\Classes\ICalFormatter;
use App\Models\ClassMembership;
use App\Models\Event;
use App\Models\User;

class FacultyService extends ICalFormatter implements FacultyContract {

    public function getClassList($term,$email)
    {
        $user = User::email($email)->first();
        $classes = ClassMembership::memberId($user->user_id)->term($term)->instructorRole()->pluck('classes_id');
        return Event::class($classes)->with('course')->get();
    }
    
    public function getFinalExamTimes($term,$email)
    {
        $finalExamList = ClassMembership::email($email)
        ->term($term)
        ->instructorRole()
        ->with('course','finalExamEvents')
        // ->get();
        ->first();
        return $finalExamList;
    }

    public function getOfficeHours($term,$email)
    {
        $userId = User::email($email)->first();
        $userId = str_replace("members:","",$userId['user_id']);
        $entities_id = 'office-hours:'.$term.':'.$userId;
        $officeHours = Event::officeHours($entities_id)
        ->term($term)
        ->type('office-hours')
        // ->with('course')
        ->get();
        return $officeHours;
    }

    public function getIcal($instructorInfo,$email)
    {
        //STEP 1
        $vCalendar = new \Eluceo\iCal\Component\Calendar('-//events @ META+LAB//Version 1//EN');
        foreach($instructorInfo['classList']  as $event){
            if( $event['days'] != 'A' && $event['days'] != '-' && $event['days'] != 'NULL' && $event['is_byappointment'] != '1' ){
                //STEP 2
                $this->setParamForClass($event,$event->course);
                //STEP 3
                $this->setParamByEvent($event);
                //STEP 4 check your requirements
                $this->setParmBySpecifications('CONFIRMED','OPAQUE', 'PUBLIC', 'WEEKLY', '1');

                //need to change
                if($event['type'] != 'class' ){
                    $this->setParamForFinal($event,$event->course);
                }
                //STEP 5 SET EVENT
                $vEvent = $this->setEvent();
                //STEP 6 (Optional based on your requirements)
                $vEvent->addComponent( $this->setVAlarm() );
                //STEP 7
                $vCalendar->addComponent( $vEvent );
            }
        }

        foreach ($instructorInfo['officeHours'] as $officeHours){
            if( $officeHours['days'] != 'A' && $officeHours['days'] != '-' && $officeHours['days'] != 'NULL' && $officeHours['is_byappointment'] != 1 ){
                $this->setParamForOfficeHours($officeHours,$email);
                $this->setParamByEvent($officeHours);
                $this->setParmBySpecifications('CONFIRMED','OPAQUE', 'PUBLIC', 'WEEKLY', '1');
                $vEvent = $this->setEvent();
                $vCalendar->addComponent($vEvent);
            }
        }
        $this->setFileName( $email );
        return $vCalendar->render();
    }
}