<?php
namespace App\Services;
use App\ClassMemberships;
use App\User;
use App\Event;
use App\Contracts\FacultyContract;
use Eluceo\iCal\Property\Event\RecurrenceRule;
use App\ICalFormatter;

class FacultyService extends ICalFormatter implements FacultyContract {

    public function getClassList($term,$email)
    {
        $user = User::email($email)->first();
        
        $classes = ClassMemberships::memberId($user->user_id)->term($term)->instructorRole()->pluck('classes_id');

        $events = [];

        foreach( $classes as $class ){
            $temp = Event::class($class)->with('course')->get();
            array_push($events, $temp);
        }
        return $events;

    }
    
    public function getFinalExamTimes($term,$email)
    {
        $finalExamList = ClassMemberships::email($email)
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
        $vCalendar = new \Eluceo\iCal\Component\Calendar('-//events @ META+LAB//Version 1//EN');

        foreach($instructorInfo['classList']  as $class){
            foreach($class as $event) {

                if( $event['days'] != 'A' && $event['days'] != '-' && $event['days'] != 'NULL' && $event['is_byappointment'] != '1' ){

                    $this->setParamForClass($event,$event->course);

                    $this->setParamByEvent($event);
                    
                    $this->setParmBySpecifications('CONFIRMED','OPAQUE', 'PUBLIC', 'WEEKLY', '1');

                    //need to change
                    if($event['type'] != 'class' ){
                        $this->setParamForFinal($event,$event->course);
                    }
                
                    $vEvent = $this->setEvent();
                    
                    $vEvent->addComponent( $this->setVAlarm() );
                    
                    $vCalendar->addComponent( $vEvent );

                }
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
?>