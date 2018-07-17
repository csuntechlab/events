<?php
/**
 * Created by PhpStorm.
 * User: Carlos Benavides
 * Date: 7/16/2018
 * Time: 2:10 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    protected $fillable =[
        'classes_id',
        'term_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'role_position',
        'member_status',
        'member_id',
        'email',
    ];


}