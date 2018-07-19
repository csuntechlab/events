<?php
namespace App\Services;

use App\ClassMembership;
use App\Contracts\StudentContract;
use App\Event;

class StudentService implements StudentContract{
    public function termClasses($term, $email){
        // TODO: parse tables from database into a standard format.

        // TODO: where classMembership[email] = $email, get * class_id

        $myClasses = ClassMembership::email($email)->term($term)->get();

        $myEvents = [count($myClasses)];

        for($i = 0; $i < count($myClasses); $i++){
            $myEvents[$i] = Event::event($myClasses[$i]['classes_id'])->get();
        }

        return $myEvents;
        //var_dump($classes->first()['email']);
    }
}