<?php

namespace App\Http\Controllers;
use App\Contracts\FacultyContract;
use App\ICal;

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
    */
    public function getInstructorInfo($term,$email)
    {
        $instructorInfo['classList'] =  $this->getClassList($term, $email);
        $instructorInfo['finalExamTimes'] = $this->getFinalExamTimes($term, $email);
        $instructorInfo['officeHours'] = $this->getOfficeHours($term, $email);  

        // return  $instructorInfo;
        
        $ical = new ICal();

        foreach($instructorInfo['classList']  as $class){
            $course  = $class->course;
            $event = $class->class_events;
            // if(!empty($event) ){
                $icalParam = $this->getParam($course,$event);
                $ical->addEvent($icalParam);
            // }
        }

        // $course = $instructorInfo['finalExamTimes']->course;
        // $event = $instructorInfo['finalExamTimes']->final_exam_events;

        // $icalParam = $this->getParam($course,$event);
        // $ical->addEvent($icalParam);

        // $course = $instructorInfo['officeHours']->course;
        // $event = $instructorInfo['officeHours'];

        // $icalParam = $this->getParam($course,$event);
        // $ical->addEvent($icalParam);


        return $ical->generateICS();
    }



}
