<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    protected $table = 'omar.classes';

    protected $fillable = [
        'classes_id',
        'term_id',
        'term',
        'class_number',
        'course_id',
        'subject',
        'catalog_number',
        'title',
        'description',
        'units',
        'section_number',
        'class_type',
    ];
    
    protected $hidden = [
        'classes_id',
        'term_id',

    ];

    // public function getClassInfo( $classes_id, $term_id){;}
}
