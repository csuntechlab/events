<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassMembership extends Model
{
    protected $table = 'nemo.class_memberships';

    public function scopeEmail($query, $email){
        return $query->where('email', $email.'@my.csun.edu');
    }

    public function scopeTerm($query, $term){
        return $query->where('term_id', $term);
    }
}
