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
        //
        $this->facultyRetriever = $facultyRetriever;
    }

    public function getClassList($term,$email)
    {
        // return $term.' '.$email;
        return $this->facultyRetriever->getClassList($term, $email);
    }

    public function getFinalExamTimes($term,$email)
    {
        return $this->facultyRetriever->getClassList($term, $email);
    }

    public function getOfficeHoursWithPattern($term, $email, $pattern)
    {
      $OfficeHours = $this->facultyRetriever->getOfficeHoursWithPattern($term, $email, $pattern);

      // $instructorInfo['officeHours'] = $this->getOfficeHoursWithPattern($term, $email, $pattern);

      // return  $instructorInfo;

      $ical = new ICal();
      //make a controller obj so you can set global param
      $controller = new Controller();

      foreach ($OfficeHours as $officeHour){
          $event = $officeHour;
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

    // public function getInstructorInfo($term,$email)
    // {
    //     $instructorInfo['classList'] =  $this->getClassList($term, $email);
    //     $instructorInfo['officeHours'] = $this->getOfficeHoursWithPattern($term, $email, $pattern);
    //
    //     // return  $instructorInfo;
    //
    //     $ical = new ICal();
    //     //make a controller obj so you can set global param
    //     $controller = new Controller();
    //
    //     foreach($instructorInfo['classList']  as $class){
    //
    //         foreach($class as $event){
    //             $course  = $event->course;
    //             //sets global parm for class and final events
    //             $controller->setParamForClassAndFinal($event,$course);
    //             //gets ical param
    //             $icalParam = $controller->getParam($event);
    //             //adds ical event with param , boolean is for adding alarm
    //             $ical->addEvent($icalParam,true);
    //         }
    //
    //     }
    //
    //     foreach ($instructorInfo['officeHours'] as $officeHours){
    //         $event = $officeHours;
    //         //sets global parm for office hours
    //         $controller->setParamForOfficeHours($event,$email);
    //         //gets ical param
    //         $icalParam = $controller->getParam($event);
    //         //adds ical event with param , boolean is for adding alarm
    //         $ical->addEvent($icalParam,false);
    //     }
    //
    //     $ical->setFileName($email);
    //     //generates an ics file for download
    //     return $ical->generateICS();
    //   }
}
