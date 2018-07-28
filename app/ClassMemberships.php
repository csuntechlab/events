<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassMemberships extends Model
{
    //check for rank not affilation 
    // if not null then faculty (rank)

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
        return $query->where('email',$email.'@csun.edu')->orWhere('email', $email.'@my.csun.edu');
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
        return $query->where('members_id',$id);
    }

    /*
    * filter instructors
    */
    public function scopeInstructor($query)
    {
        return $query->where('role_position', 'Instructor');
    }

    /*
     * filter classes
    */
    public function scopeClasses($query)
    {
        return $query->orWhere('classes_id', 'LIKE', 'classes:%');
    }

    /*
    * filter final exams
    */
    public function scopeExams($query)
    {
        return $query->orWhere('classes_id', 'LIKE', 'final-exams:%');
    }
    /**
     * filters instructor
     */
    public function scopeInstructorRole($query)
    {
        return $query->where('role_position','Instructor');
    }

    /**
     * gets course info
     */
    public function course()
    {
        return $this->hasOne('App\CourseInfo','classes_id','classes_id' );
    }

    
    
}
