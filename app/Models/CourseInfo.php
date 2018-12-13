<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseInfo extends Model
{
    protected $table = "omar.classes";

    protected $hidden = [
        'classes_id',
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
        'updated_at',
        'created_at'
    ];
}