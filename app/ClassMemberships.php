<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassMemberships extends Model
{
	protected $fillable =[
        'classes_id','term_id'
    ];
    
    protected $hidden = [
        'created_at',
        'updated_at',
        'role_position',
        'member_status',
        'member_id',
        'email',
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
    

}
