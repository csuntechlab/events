<?php
/**
 * Created by PhpStorm.
 * User: Carlos Benavides
 * Date: 7/13/2018
 * Time: 5:24 PM
 */

namespace App\Contracts;


interface ClassContract
{
    public function isValidCourseId($course_id);

    public function isValidTermId($term);

    public function course_details($term,$course_id);

}