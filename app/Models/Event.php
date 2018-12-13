<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'bedrock.events';

    protected $hidden = [
        'description',
    ];

    /**
     * Each office hour has one corresponding event. 
     */ 
    public function scopeOfficeHours($query,$entities_id)
    {
        //Model col name w/in Events, corresponding col w/in classMemberships
        return $query-> where('entities_id',$entities_id);
    }
     /**
     * filters the associated term
     */
    public function scopeTerm($query,$term)
    {
        return $query->where('term_id',$term);
    }

    /**
     * filters the associated Type
     */
    public function scopeType($query,$type)
    {
        return $query->where('type',$type);
    }

    /**
     * Gets courses info 
     */
    public function course()
    {
        return $this->hasOne('App\Models\CourseInfo', 'classes_id', 'entities_id');
    }
    
    /**
     * matches the entties id of event with classes_id
     */
    public function scopeClass($query,$class_id)
    {
        return $query->where('entities_id', $class_id);
    }    
}
