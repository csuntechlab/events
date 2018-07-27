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
use Eluceo\iCal\Property\Event\RecurrenceRule;
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

    public function retrieveClassICS($term,$course_id)
    {
        // grab the SQL data for respective term + class id combo
        $output = $this->retrieveClassDetails($term,$course_id);
        // send the data to the service
        // will format and retrieve a class ICS
        return $this->classContract->ClassICS($output);
    }

}