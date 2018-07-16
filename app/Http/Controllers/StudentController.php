<?php
/**
 * Created by PhpStorm.
 * User: Rinzlo
 * Date: 7/13/18
 * Time: 11:10 AM
 */

namespace App\Http\Controllers;


use App\Contracts\StudentContract;

class StudentController
{
    protected $studentService = null;

    public function __construct(StudentContract $studentService)
    {
        $this->studentService = $studentService;
    }

    public function termClasses($term, $email){
        // TODO: mock the database tables in tests here
        $this->studentService->termClasses($term, $email);
//        return 1;
    }
}