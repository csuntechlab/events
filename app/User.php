<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model 
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'email',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'display_name',
        'first_name',
        'last_name',
        'affiliation',
        'rank',
        'affiliation_status',
        'created_at',
        'updated_at'
    ];

    public function scopeEmail($query,$email)
    {
        return $query->where('email','nr_'.$email.'@csun.edu');
    }

}
