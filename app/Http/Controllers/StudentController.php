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

    /**
     * @param $term
     * @param $email
     * @return null|string
     */
    public function termClasses($term, $email){
        $events = $this->studentService->termClasses($term, $email);
//        return ($events);
        $ical = new ICal();
        foreach($events as $event) {
            $ical->addEventByArray($event);
        }
        return $ical->generateICS();
    }
}