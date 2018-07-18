<?php
namespace App\Services;

use App\Contracts\StudentContract;

class StudentService implements StudentContract{
    public function termClasses($term, $email){
        // TODO: parse tables from database into a standard format.

        // TODO: where classMembership[email] = $email, get * class_id

        // TODO: magically use 'events'

        return $email;
    }
}