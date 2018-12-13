<?php

namespace App\Http\Controllers;

use App\Contracts\FacultyContract;
use Illuminate\Support\Facades\Request;

class FacultyController extends Controller
{
    /**
     * @var FacultyContract
     */
    protected $facultyRetriever;

    /**
     * Create a new controller instance.
     *
     * @param FacultyContract $facultyRetriever
     */
     public function __construct(FacultyContract $facultyRetriever)
    {
        $this->facultyRetriever = $facultyRetriever;
    }

    /**
     * Get a my Classes table for professors
     * @param $term
     * @param $email
     * @return
     */
    public function getClassList($term, $email)
    {
        $classList = $this->facultyRetriever->getClassList($term, $email);
        return  $classList;
    }

    /**
     * Retrieve a teachers Final-Exam hours for term 2187
     * @param $term
     * @param $email
     * @return
     */
    public function getFinalExamTimes($term, $email)
    {
        $finalExamTimes =  $this->facultyRetriever->getFinalExamTimes($term, $email);
        return $finalExamTimes;
    }

    /**
     * * Retrieve a teachers Final-Exam hours for term 2187
     * @param $term
     * @param $email
     * @return
     */
    public function getOfficeHours($term, $email)
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
     * @param $term
     * @param $email
     * @return
     */
    public function getInstructorInfo($term, $email)
    {
        $instructorInfo['classList'] =  $this->getClassList($term, $email);
        $instructorInfo['officeHours'] = $this->getOfficeHours($term, $email);
        if (!Request::has('download')) {
            return $instructorInfo;
        }
        return $this->facultyRetriever->getIcal($instructorInfo,$email);
    }
}