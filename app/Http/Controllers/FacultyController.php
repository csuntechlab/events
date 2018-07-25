<?php

namespace App\Http\Controllers;
use App\Contracts\FacultyContract;
use Eluceo\iCal\Property\Event\RecurrenceRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\ICal;

// use Controller;
// require_once __DIR__ . '/../vendor/autoload.php';

class FacultyController extends Controller
{


    protected $facultyRetriever;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
     public function __construct(FacultyContract $facultyRetriever)
    {
        $this->facultyRetriever = $facultyRetriever;
    }

    /**
    * Get a my Classes table for professors
    */
    public function getClassList($term,$email)
    {
        $classList = $this->facultyRetriever->getClassList($term, $email);
        return  $classList;
    }

    /**
    * Retrieve a teachers Final-Exam hours for term 2187
    */
    public function getFinalExamTimes($term,$email)
    {
        $finalExamTimes =  $this->facultyRetriever->getFinalExamTimes($term, $email);
        return $finalExamTimes;
    }
    /**
    * * Retrieve a teachers Final-Exam hours for term 2187
    */
    public function getOfficeHours($term,$email)
    {
        $officeHours = $this->facultyRetriever->getOfficeHours($term, $email);    
        return $officeHours;
    }

    /**
    * Retrieve Instructor info:
    *   professor classes   
    *   final exam times
    *   professor office hours
    * Creates an ics file
    */
    public function getInstructorInfo($term,$email)
    {
        $instructorInfo['classList'] =  $this->getClassList($term, $email);
        $instructorInfo['officeHours'] = $this->getOfficeHours($term, $email);  

        $vCalendar = new \Eluceo\iCal\Component\Calendar('-//events @ META+LAB//Version 1//EN');

        $controller = new Controller();

        foreach($instructorInfo['classList']  as $class){
           
           
           
           
            foreach($class as $event){
                $course  = $event->course;

                $controller->setParamForClassAndFinal($event,$course);
                
                $controller->setEvent($event);

                $vEvent = new \Eluceo\iCal\Component\Event();

                $controller->setEvent($vEvent, $event);

                
                
                $vEvent->setRecurrenceRule($recurrenceRule);

                $vAlarm = new \Eluceo\iCal\Component\Alarm();
                $vAlarm->setTrigger('-PT15M');
                $vAlarm->setDescription($vAlarmDescription);
                $vAlarm->setAction('DISPLAY');

                $vEvent->addComponent($vAlarm);

                $vCalendar->addComponent($vEvent);
            }
            
        }

        header('Content-Type: text/calendar; charset=utf-8');
        header('Content-Disposition: attachment; filename="cal.ics"');

        return $vCalendar->render();
        
        // $vCalendar->addComponent($vEvent);
        
        $ical = new ICal();
        //make a controller obj so you can set global param
        $controller = new Controller();

        foreach($instructorInfo['classList']  as $class){

            foreach($class as $event){
                $course  = $event->course;
                //sets global parm for class and final events
                $controller->setParamForClassAndFinal($event,$course);
                //gets ical param
                $icalParam = $controller->getParam($event);
                //adds ical event with param , boolean is for adding alarm
                $ical->addEvent($icalParam,true);
            }
            
        }

        foreach ($instructorInfo['officeHours'] as $officeHours){
            $event = $officeHours;
            //sets global parm for office hours
            $controller->setParamForOfficeHours($event,$email);
            //gets ical param
            $icalParam = $controller->getParam($event);
            //adds ical event with param , boolean is for adding alarm
            $ical->addEvent($icalParam,false);
        }

        $ical->setFileName($email);
        //generates an ics file for download
        return $ical->generateICS();
    }



}
