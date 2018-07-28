<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassMembership extends Model
{
    protected $table = 'nemo.classMemberships';

    public function scopeMember($query, $member_id){
        return $query->where('members_id', $member_id);
    }

    public function scopeTermID($query, $term){
        return $query->where('term_id', $term);
    }
}
