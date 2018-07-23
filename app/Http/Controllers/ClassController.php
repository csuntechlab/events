<?php
/**
 * Created by PhpStorm.
 * User: Carlos Benavides
 * Date: 7/13/2018
 * Time: 11:24 AM
 */

namespace App\Http\Controllers;


use App\Contracts\ClassContract;
use App\ICal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClassController extends Controller
{
    protected $classContract;

    public function __construct(ClassContract $classContract)
    {
        $this->classContract = $classContract;
    }

    public function classInfo($term,$course_id)
    {
        return $this->classContract->classInfo($term,$course_id);
    }

    public function finalInfo($term,$course_id)
    {
        return $this->classContract->finalInfo($term , $course_id);
    }

    public function retrieveClassDetails($term,$course_id)
    {
        // original
//        $classDetails = $this->classContract->classInfo($term,$course_id);
//        $finalDetails = $this->classContract->finalInfo($term,$course_id);
        $classDetails = ["classEvents" => $this->classContract->classInfo($term,$course_id)];
        $finalDetails = ["finalEvent" => $this->classContract->finalInfo($term,$course_id)];

        $output = $classDetails + $finalDetails;
        return $output;
    }

    public function retrieveClassICS($term, $course_id)
    {
        // Gets the SQL data, method above
        $output = $this->retrieveClassDetails($term,$course_id);
        $ical = new ICal();
        $controller = new Controller();

        $course = [];

        /**
         *  Each class might have a in person AND a online meeting
         *  Each class deserves a Alarm
         */
        foreach ($output['classEvents'] as $class)
        {
            $course = $class->details;
            $controller->setParamForClassAndFinal($class,$course);
//            $controller->setParamForClassFinalHours($class);
            $icalParam = $controller->getParam($class);
            $ical->addEvent($icalParam,1);
        }

        $ical->addEvent($output['finalEvent'],1);

        $fileName = 'classes'.'.'.$class['term_id'].'.'.$class['course_id'].'.'.$class['section_number'];

        $ical->setFileName($fileName);

        return $ical->generateICS();
    }
}