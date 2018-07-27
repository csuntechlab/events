<?php
namespace App\Services;

use App\Contracts\FacultyContract;
use App\User;
use App\ClassMemberships;
use App\Event;
use Eluceo\iCal\Property\Event\RecurrenceRule;
use App\ICalFormatter;

class FacultyService extends ICalFormatter implements FacultyContract {



    public function getAllOfficeHours($facultyData){


        $faculty_id = $facultyData['email'];
        $faculty_term = $facultyData['term']->term_id;

        //  return $faculty_id->user_id;
        $faculty_id = str_replace("members:","",$faculty_id->user_id);

        //$faculty_id = User::findOrFail($facultyData['term'])->find($facultyData['email']);

        $entities_id = 'office-hours:'.$faculty_term.':'.$faculty_id;
        $officeHours = Event::officeHours($entities_id)
            ->term($faculty_term)
            ->type('office-hours')
            ->get();

        $vCalendar = new \Eluceo\iCal\Component\Calendar('-//events @ META+LAB//Version 1//EN');

        foreach ($officeHours as $officeHour){
            // if( $officeHours['days'] != 'A' && $officeHours['days'] != '-' && $officeHours['days'] != 'NULL' && $officeHours['is_byappointment'] != 1 ){
            $this->setParamForOfficeHours($officeHour,$officeHours->email);
            $this->setParamByEvent($officeHours);

            $this->setParmBySpecifications('CONFIRMED','OPAQUE', 'PUBLIC', 'WEEKLY', '1');

            $vEvent = $this->setEvent();

            $vCalendar->addComponent($vEvent);
            // }
        }
        $this->setFileName( $officeHours->email );
        return $vCalendar->render();
//---------------------------------------
        //find term first then find faculty in that term thru email
       // $faculty_id = $facultyData['email'];
        //$faculty_term = $facultyData['term']->term_id;

          //  return $faculty_id->user_id;
          //  $faculty_id = str_replace("members:","",$faculty_id->user_id);

        //$faculty_id = User::findOrFail($facultyData['term'])->find($facultyData['email']);

        //$entities_id = 'office-hours:'.$faculty_term.':'.$faculty_id;
        /*$officeHours = Event::officeHours($entities_id)
            ->term($faculty_term)
            ->type('office-hours')
            ->get();



        return $officeHours;*/
       // return $this->jsonResponse();
    }

    /*public function getIcal($instructorInfo,$email)
    {
        //STEP 1
        $vCalendar = new \Eluceo\iCal\Component\Calendar('-//events @ META+LAB//Version 1//EN');
        foreach($instructorInfo['classList']  as $class){
            foreach($class as $event) {
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
        }
        foreach ($instructorInfo['officeHours'] as $officeHours){
            // if( $officeHours['days'] != 'A' && $officeHours['days'] != '-' && $officeHours['days'] != 'NULL' && $officeHours['is_byappointment'] != 1 ){
            $this->setParamForOfficeHours($officeHours,$email);
            $this->setParamByEvent($officeHours);

            $this->setParmBySpecifications('CONFIRMED','OPAQUE', 'PUBLIC', 'WEEKLY', '1');

            $vEvent = $this->setEvent();

            $vCalendar->addComponent($vEvent);
            // }
        }
        $this->setFileName( $email );
        return $vCalendar->render();
    }

}*/
}
?>