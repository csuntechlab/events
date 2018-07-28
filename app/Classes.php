<?php

/**
 * Created by PhpStorm.
 * User: Carlos Benavides
 * Date: 7/16/2018
 * Time: 2:10 PM
 */

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
    public function scopeClasses_id($query, $queryBuilder)
    {
        return $query->where('entities_id',$queryBuilder);
    }

    public function getDetails()
    {
        return $this->hasOne('App\CourseInfo','classes_id','entities_id');
    }

    public function scopeFinal($query,$queryBuilder)
    {
        return $query->where('entities_id', $queryBuilder);
    }

}
