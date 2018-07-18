<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'bedrock.events';

	protected $fillable =[
    
    ];
    
    protected $hidden = [
    ];

    /**
     * members:yyyyy ====  office-hours:term:yyyyy
     * 
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
     * Each class has one corresponding event
     * Each office hour has one corresponding event. 
     * Each final exam time has one corresponding event. 
     * 
     * Gathers corresponding event of class. 
     */
    public function classEvents()
    {
        //Model col name w/in Events, corresponding col w/in classMemberships
        return $this-> hasMany('App\Event','entities_id','classes_id');
    }


    

}
