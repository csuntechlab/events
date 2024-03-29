<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model 
{
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

    public function scopeEmail($query, $email)
    {
        return $query->whereEmail($email.'@csun.edu');
    }
}
