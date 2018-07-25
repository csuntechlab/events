<?php
/**
 * Created by PhpStorm.
 * User: Carlos Benavides
 * Date: 7/13/2018
 * Time: 5:27 PM
 */

namespace App\Services;

use App\Classes;
use Illuminate\Support\Facades\Validator;

use App\Contracts\ClassContract;

class ClassService implements ClassContract
{

    public function isValidCourseId($course_id)
    {
        $data = ['course_id' => $course_id];
        $validator = Validator::make($data, [
            'course_id' => 'digits:5'
        ]);
//            $this->validate($course_id,[
//                'course_id' => 'digits:5'
////                 $course_id => 'required|exists:posts,id',
//            ]);
//      TEMP code!!!
        if ($validator->fails()) {
            return $validator->errors();
        }
    }

    public function course_details($term,$course_id)
    {
        return [
            'Locate' => 'Classroom',
            'events' => [
                'Class Start' =>'Date 1',
                'Class End' => 'Date 2',
                'Attendance' => [
                    'Friday' => 'Day'
                ],
                'Final Exam' => 'Final Day'
            ]
         ];
    }

    public function classInfo($term, $course_id)
    {
        $queryBuilder = "classes:{$term}:{$course_id}";
        $result = Classes::Classes_id($queryBuilder)
            ->with('getDetails')
            ->get();
        return $result;
    }

    public function finalInfo($term,$course_id)
    {
        $queryBuilder = "classes:{$term}:{$course_id}";

        $result = Classes::Final($queryBuilder)
                    ->where('type','final-exam')
                    ->get();

        return $result;
    }

    public function isValidTermId($termId)
    {
        $data = ['course_id' => $termId];

        $validator = Validator::make($data, [
            'course_id' => 'digits:4'
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }
    }

}