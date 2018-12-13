<?php
/**
 * Created by PhpStorm.
 * User: Carlos Benavides
 * Date: 7/19/2018
 * Time: 10:32 AM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class CourseInfo extends Model
{
    protected $table = "omar.classes";

    protected $hidden = [
        'session_code',
        'term',
        'course_id',
        'units',
        'section_number',
        'class_status',
        'class_type',
        'enrollment_cap',
        'enrollment_total',
        'waitlist_cap',
        'waitlist_total',
    ];

}