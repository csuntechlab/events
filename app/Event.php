<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'bedrock.events';

    public function scopeEntities($query, $classes_id){
        return $query->where('$entities_id', $classes_id);
    }
}
