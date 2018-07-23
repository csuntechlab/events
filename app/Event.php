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
        'type', 'label',
        'start_time',
        'end_time',
        'days',
        'from_date',
        'to_date',
        'location_type',
        'location',
        'is_byappointment',
        'is_walkin'
    ];
    
    public function scopeEmail($query,$email)
    {
        return $query->where('email', 'nr_'.$email.'@csun.edu')
            ->orWhere('email', 'nr_'.$email.'@my.csun.edu');
    }

    public function scopeClass($query,$class_id)
    {
        return $query->where('entities_id', $class_id);
    }

    public function info()
    {
        return $this->hasOne('App\Classes', 'classes_id', 'entities_id');
    }
}
