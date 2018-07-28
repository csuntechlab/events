<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'bedrock.events';

    protected $fillable =[
        'entities_id',
        'term_id',
        'pattern_number',
        'type',
        'label',
        'start_time',
        'end_time',
        'days',
        'from_date',
        'to_date',
        'location_type',
        'location',
        'is_byappointment',
        'is_walkin',
        'booking_url',
        'online_label',
        'online_url',
        'created_at',
        'updated_at'
    ];

    protected $hidden = [];
    
    /*
    public function scopeEmail($query,$email)
    {
        return $query->where('email', 'nr_'.$email.'@csun.edu')
            ->orWhere('email', 'nr_'.$email.'@my.csun.edu');
    }
    */

    public function scopeTerm($query, $term)
    {
        return $query->where('term_id', $term);
    }

    public function scopeEntities($query, $entities)
    {
        return $query->where('entities_id', $entities);
    }

    /**
     * matches the entities id of event with classes_id
     */
    public function scopeClass($query,$class_id)
    {
        return $query->where('entities_id', $class_id);
    }

    /**
     * Each office hour has one corresponding event. 
     */ 
    public function scopeOfficeHours($query,$entities_id)
    {
        //Model col name w/in Events, corresponding col w/in classMemberships
        return $query-> where('entities_id',$entities_id);
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
        return $this->hasOne('App\Classes', 'classes_id', 'entities_id');
    }
}
