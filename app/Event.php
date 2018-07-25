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
    ];

    protected $hidden = [
        'description',
        'created_at',
        'updated_at',
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
    * filters the pattern_number
    */
    public function scopePatternNumber($query,$pattern_number)
    {
        return $query->where('pattern_number',$pattern_number);
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


    public function scopeEvent($query, $classes_id){
        return $query->where('$entities_id', $classes_id);
    }

}
