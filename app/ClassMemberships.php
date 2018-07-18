<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassMemberships extends Model
{
    protected $table = 'nemo.classmemberships';

	protected $fillable =[
        // 'classes_id','term_id',
    ];
    
    protected $hidden = [
        'created_at',
        'updated_at',
        // 'role_position',
        // 'member_status',
        // 'member_id',
        'term',	
        'class_number',
        // 'members_id',
        'members_uid',
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'ad_hoc_member',	
        'confidential',	
        // 'email',
    ];

    /**
     * filters the associated email
     */
    public function scopeEmail($query,$email)
    {
        return $query->where('email',$email.'@csun.edu');
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
     * Each class has one corresponding event
     * Each office hour has one corresponding event. 
     * Each final exam time has one corresponding event. 
     * 
     * Gathers corresponding event of class. 
     */
    public function events()
    {
        //Model col name w/in Events, corresponding col w/in classMemberships
        return $this-> hasMany('App\Event','entities_id','classes_id');
    }

}
