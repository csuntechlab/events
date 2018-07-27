<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassRosters extends Model
{
    protected $table = 'nemo.classRosters';

	protected $fillable = [
        'classes_id',
        'individuals_id',
        'class_position',
        'ad_hoc_member',
        'confidential',
        'member_status',
        'created_at',
        'updated_at'
    ];
    
    protected $hidden = [];

    /**
     * filters the associated individuals id
     */
    public function scopeIndividualsId($query, $id)
    {
        return $query->where('individuals_id', $id);
    }

    /**
    * filter instructors
    */
    public function scopeInstructor($query)
    {
        return $query->where('class_position', 'Instructor');
    }

    /**
     * filter students
     */
    public function scopeStudent($query){
        return $query->whereIn('class_position', ['Freshmen', 'Sophomore', 'Junior', 'Senior', 'Graduate']);
    }

    /**
     * filter classes
     */
    public function scopeClasses($query, $class){
        return $query->where('classes_id', $class);
    }

    /**
     * filter classes and term
    */
    public function scopeTermClasses($query, $term)
    {
        return $query->where('classes_id', 'LIKE', 'classes:' . $term . ':%');
    }

    /**
     * Each class has one corresponding event
     * Each office hour has one corresponding event. 
     * Each final exam time has one corresponding event. 
     * 
     * Gathers corresponding event of class. 
     */
    public function events()
    {
        //Model col name w/in Events, corresponding col w/in classMemberships
        return $this->hasMany('App\Event','entities_id','classes_id');
    }

}
