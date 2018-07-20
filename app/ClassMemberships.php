<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassMemberships extends Model
{
    protected $table = "bedrock.events";

    protected $fillable =[
        'description',
        'location',
        'start_time',
        'end_time',
        'days',
        'from_date',
        'to_date',
        'term'
    ];

    protected $hidden = [
        'meeting_id',
        'meeting_number',
        'entities_id',
        'classes_id',
        'term_id',
    ];

    public function scopeClasses_id($query, $queryBuilder)
    {
        return $query->where('entities_id',$queryBuilder);
    }
}
