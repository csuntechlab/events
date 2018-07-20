<?php
/**
 * Created by PhpStorm.
 * User: Carlos Benavides
 * Date: 7/13/2018
 * Time: 11:24 AM
 */

namespace App\Http\Controllers;


use App\Contracts\ClassContract;
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

}