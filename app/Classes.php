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

//    receive term + course id
//    VEVENT + VALARM: want meeting days + time VEVENT
//    VEVENT + VALARM: want FINAL time wrt class TIME and DAY

    protected $table = "bedrock.events";

    protected $fillable =[
        'description',
        'location',
        'start_time',
        'end_time',
        'days',
        'from_date',
        'to_date',
        'term',
        'classes_id',
        'term_id',
        'label'
    ];

    protected $hidden = [
        'meeting_id',
        'meeting_number',
        'entities_id',
        "created_at",
        "updated_at",
        'is_walkin',
        'is_byappointment'
    ];

    public function scopeClasses_id($query, $queryBuilder)
    {
        return $query->where('entities_id',$queryBuilder);
    }

    public function details()
    {
        return $this->hasOne('App\CourseInfo','classes_id','entities_id');
    }

    public function scopeFinal($query,$queryBuilder)
    {
        return $query->where('entities_id', $queryBuilder);
    }

}