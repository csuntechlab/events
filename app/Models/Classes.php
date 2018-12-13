<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{

//    receive term + course id
//    VEVENT + VALARM: want meeting days + time VEVENT
//    VEVENT + VALARM: want FINAL time wrt class TIME and DAY

    protected $table = "bedrock.events";

    protected $hidden = [
        'meeting_id',
        'meeting_number',
        'entities_id',
        'classes_id',
        'term_id',
        'created_at',
        'updated_at',
        'is_walkin',
        'is_byappointment'
    ];

    public function scopeClasses_id($query, $queryBuilder)
    {
        return $query->where('entities_id', $queryBuilder);
    }

    public function getDetails()
    {
        return $this->hasOne('App\Models\CourseInfo','classes_id','entities_id');
    }

    public function scopeFinal($query, $queryBuilder)
    {
        return $query->where('entities_id', $queryBuilder);
    }
}