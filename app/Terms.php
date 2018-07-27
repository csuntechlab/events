<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Terms extends Model
{
    protected $table = 'omar.terms';

    protected $fillable = [
        'term_id',
        'term',
        'description',
        'begin_date',
        'end_date',
        'created_at',
        'updated_at'
    ];

    public function scopeTerm($query, $term_id)
    {
        return $this->query('term_id', $term_id);
    }
}