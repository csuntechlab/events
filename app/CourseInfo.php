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

    protected $fillable =[
        'subject',
        'catalog_number',
        'title',
        'class_number',
    ];

    protected $hidden = [
        'session_code',
        
        'courses_id',
        'description',
        'units',
        'created_at',
        'updated_at',
        'waitlist_total',
        'waitlist_cap',
        'enrollment_total',
        'enrollment_cap',
        'class_type',
        'class_status'
    ];

}