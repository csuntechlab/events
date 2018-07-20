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

        foreach($instructorInfo['classList']  as $class){
            $course  = null;
            $event = null;
            foreach($class as $classInfo){
                $course = $classInfo['course'];   
                $event = $classInfo['class_events'];   
            }

            // return $class;
            $icalParam = $this->getParam($class,$course,$event);
            return $icalParam;
        }
       
    }


//    UID:classes.2187.20433.1.vevent@metalab.csun.edu
//    DTSTAMP:20180505T171003Z
//    CREATED:20180505T170922Z
//    LAST-MODIFIED:20180505T171003Z
//    CLASS:PUBLIC
//    TRANSP:OPAQUE
//    STATUS:CONFIRMED
//    CATEGORIES:Class
//    SUMMARY:CIT 160 (20433)
//    LOCATION;ALTREP="http://academics.csun.edu/classrooms/JD3520":JD3520
//    GEO:34.2373175;-118.533936
//    DESCRIPTION: <Add some type of description>
//    DTEND;TZID=America/Los_Angeles:20180827T135000
//    RRULE:FREQ=WEEKLY;INTERVAL=1;UNTIL=20181212T135000Z;BYDAY=MO,WE
/*
    $uid = null, 
    $dtStamp = null,
    $created = null,
    $lastModified = null,
    $class = null,
    $transpartent = null,
    $status = null,
    $catagories = null, 
    $summary = null,
    $location = null,
    $geo = null, 
    $desription = null,
    $dtstart = null,
    $dtend = null,
    $rRule = null,
    $interval = null,
    $until = null,
    $byDay = null, 
    $categories = null,
    $location = null,
    $geo = null,
    $description = null
*/
    public function getICal()
    {
        $instructorInfo['classList'] =  $this->getClassList($term, $email);
        $instructorInfo['finalExamTimes'] = $this->getFinalExamTimes($term, $email);
        $instructorInfo['officeHours'] = $this->getOfficeHours($term, $email);  
        

        foreach($instructorInfo['classList']  as $class){
            $icalParam = $this->getParam($class);
        }

    }



}
