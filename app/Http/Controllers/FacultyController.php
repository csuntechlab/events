<?php

namespace App\Http\Controllers;
use App\Contracts\FacultyContract;

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

    public function getClassList($term,$email){
        // return $term.' '.$email;
        return $this->facultyRetriever->getClassList($term, $email);
    }

    public function getFinalExamTimes($term,$email){
        return $this->facultyRetriever->getClassList($term, $email);
    }
       


}
