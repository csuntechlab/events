<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassMemberships extends Model
{
    //check for rank not affilation 
    // if not null then faculty (rank)

    protected $table = 'nemo.classMemberships';
    
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
        return $query->whereEmail($email.'@csun.edu');
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
