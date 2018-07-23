<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Registry extends Model
{
    protected $table = 'bedrock.registry';

    /**
     * @param $query
     * @param $email
     * @return mixed
     */
    public function scopeEmail($query, $email){
        return $query->where('email', $email);
    }
}
