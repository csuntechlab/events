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
        $classDetails = $this->classContract->classInfo($term,$course_id);
        $finalDetails = $this->classContract->finalInfo($term,$course_id);

        $output = $classDetails;

        return $output;
    }


    public function retrieveClassICS($term, $course_id)
    {
        $output = $this->retrieveClassDetails($term,$course_id);
        $helper = $this->getClassParam($output);
        $fileName = 'classes'.'.'.$output->term_id.'.'.$output->details->course_id.'.'.$output->details->section_number;
        return $this->classContract->ClassICS($helper,$fileName);
    }
}