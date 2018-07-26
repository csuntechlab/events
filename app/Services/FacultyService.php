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
        
        $classes = ClassMemberships::memberId($user->user_id)
            ->term($term)
            ->instructorRole()
            ->pluck('classes_id');

        $events = [];

        foreach( $classes as $class ){
            $temp = Event::class($class)
            ->with('course')
            ->get();
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

                if( $event['days'] != 'A' || $event['days'] != '-' || $event['days'] != 'NULL' ){

                    $this->setParamForClassAndFinal($event,$event->course);
                
                    $vEvent = new \Eluceo\iCal\Component\Event();
                    
                    $vEvent = $this->setEvent($vEvent, $event, true);

                    $vAlarm = new \Eluceo\iCal\Component\Alarm();
                    
                    $vAlarm = $this->setVAlarm($vAlarm);
                    
                    $vEvent->addComponent($vAlarm);
                    
                    $vCalendar->addComponent($vEvent);

                }
            }
        }

        foreach ($instructorInfo['officeHours'] as $officeHours){
            $this->setParamForOfficeHours($officeHours,$email);
            
            $vEvent = new \Eluceo\iCal\Component\Event();
            
            $vEvent = $this->setEvent($vEvent, $officeHours , false);
            
            $vCalendar->addComponent($vEvent);
        }

        header('Content-type: text/calendar; charset=utf-8');
        header('Content-Disposition: attachment; filename='.$email.'.ics');

        return $vCalendar->render();

    }
    
}
?>