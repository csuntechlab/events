<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    protected $table = 'omar.classes';
    protected $primaryKey = 'classes_id';

    protected $fillable = [
        'classes_id',
        'term_id',
        'session_code',
        'term',
        'class_number',
        'course_id',
        'subject',
        'catalog_number',
        'title',
        'description',
        'units',
        'section_number',
        'class_status',
        'class_type',
        'enrollment_cap',
        'enrollment_total',
        'waitlist_cap',
        'waitlist_total'
    ];

    // public function getClassInfo( $classes_id, $term_id){;}
}
