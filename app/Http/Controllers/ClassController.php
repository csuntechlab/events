<?php
/**
 * Created by PhpStorm.
 * User: Carlos Benavides
 * Date: 7/13/2018
 * Time: 11:24 AM
 */

namespace App\Http\Controllers;


use App\Contracts\ClassContract;
use Illuminate\Support\Facades\Validator;

class ClassController extends Controller
{
    protected $classContract;

    public function __construct(ClassContract $classContract)
    {
        $this->classContract = $classContract;
    }

    public function courses($term,$course_id)
    {
//        $validTerm = $this->classContract->getYearAndTerm($term);
        return $term . ' ' . $course_id;
        $result = $this->classContract->isValidCourseId($course_id);
        if(!$result)
        {
            return $this->classContract->test($course_id);
        }
        return $result;
    }
}