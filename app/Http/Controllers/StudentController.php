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

        $ical = new ICal();
        foreach($events as $event) {
//            $ical->addEvent(
//                $event['summary'],
//                $event['uid'],
//                $event['status'],
//                $event['transparent'],
//                $event['rules'],
//                $event['from'],
//                $event['to'],
//                $event['dtStamp'],
//                $event['categories'],
//                $event['location'],
//                $event['geo'],
//                $event['description']
//            );

            $ical->addEventByArray($event);
        }
        return $ical->generateICS();
    }
}