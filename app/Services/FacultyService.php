<?php
namespace App\Services;
use App\ClassRosters;
use App\Contracts\FacultyContract;
use App\User;
use App\Event;
use App\Terms;
use App\ClassMemberships;
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

    public function getClassAndFinalExamTimes($term, $email){
        $user = User::email($email)->first();

        $classes = ClassRosters::individualsId($user->user_id)
            ->termClasses($term)
            ->instructor()
            ->pluck('classes_id');
            
        $events = [];

        // return Event::whereIn('classes_id', $classes);
        foreach( $classes as $class ){
            $temps = Event::entities($class)->term($term)->with('course')->get();
            foreach( $temps as $temp ){
                if( $temp != null ){
                    /*
                    check if the start_date are null
                    if null, use omar.terms and get begin_date & end_date
                    */
                    if( $temp->from_date == null || $temp->to_date == null ){
                        $terms_table = Terms::term($temp->term_id)->first();
                        $temp->from_date = $terms_table->begin_date;
                        $temp->to_date = $terms_table->end_date;
                    }

                    if( $temp->course != null ){
                        array_push($events, $temp);
                    }
                }
            }
            
            $exam = str_replace('classes', 'final-exams', $class);
            $temp = Event::entities($exam)->term($term)->first();
            if( $temp != null ){
                array_push($events, $temp);
                // final exam will never be null
            }
        }
        return $events;
    }
}
?>
