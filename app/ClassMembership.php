<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassMembership extends Model
{
    protected $table = 'nemo.class_memberships';

    public function scopeMember($query, $member_id){
        return $query->where('member_id', $member_id);
    }

    public function scopeTerm($query, $term){
        return $query->where('term_id', $term);
    }
}
