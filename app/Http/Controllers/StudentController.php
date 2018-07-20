<?php
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
        $classes = $this->studentService->termClasses($term, $email);

        $ical = new ICal();
        foreach($classes as $class) {
            $ical->addEvent(
                $class['summary'],
                $class['uid'],
                $class['status'],
                $class['transparent'],
                $class['rules'],
                $class['from'],
                $class['to'],
                $class['dtStamp'],
                $class['categories'],
                $class['location'],
                $class['geo'],
                $class['description']);
        }
        return $ical->generateICS();
    }
}