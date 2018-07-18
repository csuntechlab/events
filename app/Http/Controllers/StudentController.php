<?php
/**
 * Created by PhpStorm.
 * User: Rinzlo
 * Date: 7/13/18
 * Time: 11:10 AM
 */

namespace App\Http\Controllers;


use App\Contracts\StudentContract;
use App\ICal;

class StudentController
{
    protected $studentService = null;

    public function __construct(StudentContract $studentService)
    {
        $this->studentService = $studentService;
    }

    public function termClasses($term, $email){
//        return json_encode($this->studentService->termClasses($term, $email));
//        return $this->generate_ics('2018-07-01', '2018-08-01', 'bunch-o-stuff');
//        return $this->test();
        $ical = new ICal();
        $ical->addEvent();
        return $ical->generateICS();
    }
}