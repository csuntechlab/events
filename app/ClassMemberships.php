<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassMemberships extends Model
{
    //check for rank not affilation 
    // if not null then faculty (rank)
    //nemo entities
    // nemo means nobody everybody 
    //calendar user
    // all indivuals are enties
    // not all enties are individuals 
    /**
     * 
     * registery data os metadata
     * on your account
     * 
     * 
     * 
     * events composite key, 
     * entities 
     * term
     * pattern
     * type
     * 
     * type: 
     *      Class
     *      Final-exam
     *      Office-Hours 
     * 
     *
     * 
     */

    protected $table = 'nemo.classMemberships';

	protected $fillable =[
        'classes_id',
        'term_id',
        'members_id',
        'email',
        'role_position',
    ];
    
    protected $hidden = [
        'term',
        'class_number',
        'members_id',
        'members_uid',
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'role_position',
        'ad_hoc_member',
        'confidential',
        'member_status',
    ];

    /**
     * filters the associated email
     */
    public function scopeEmail($query,$email)
    {
        return $query->where('email','nr_'.$email.'@csun.edu');
    }

    /**
     * filters the associated term
     */
    public function scopeTerm($query,$term)
    {
        return $query->where('term_id',$term);
    }

    /**
     * filters the associated member:id
     */ 
    public function scopeMemberId($query,$id)
    {
        return $query->where('member_id','member_id:'.$id);
    }

    /**
     * filters instructor
     */
    public function scopeInstructorRole($query)
    {
        return $query->where('role_position','Instructor');
    }

     /**
     * Each class has one corresponding event
     * Gathers corresponding event of class. 
     */
    public function classEvents()
    {
        //Model col name w/in Events, corresponding col w/in classMemberships
        return $this
        ->hasMany('App\Event','entities_id','classes_id')
        ->type('class');
    }

    /**
     * Each final exam time has one corresponding event. 
     * Gathers corresponding event of final Exams. 
     */
    public function finalExamEvents()
    {
        //Model col name w/in Events, corresponding col w/in classMemberships
        return $this
        ->hasMany('App\Event','entities_id','classes_id')
        ->type('final-exam');
    }

    public function events()
    {
        return $this
        ->hasMany('App\Event','entities_id','classes_id');
    }



    public function course()
    {
        return $this->hasOne('App\CourseInfo','classes_id','classes_id' );
    }
    
}
