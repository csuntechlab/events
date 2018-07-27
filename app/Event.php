<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'bedrock.events';

	protected $fillable = [
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
        'is_walkin'
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

    public function course()
    {
        return $this->hasOne('App\Classes', 'classes_id', 'entities_id');
    }
}
