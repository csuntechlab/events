<?php
namespace App\Services;
use App\ClassMemberships;
use App\Contracts\FacultyContract;
use App\User;
use App\Event;

class FacultyService implements FacultyContract {
    
    protected $table = 'nemo.classmemberships';

    public function getClassList($term,$email)
    {
        // $first = ClassMemberships::all();
        $first = ClassMemberships::email($email)
        ->term($term)
        ->with('events')
        ->get();
        // var_dump($first);
        return ['status'=>'true'] ;
        // return $first;
    }
    
    public function getFinalExamTimes($term,$email){
        return 'this is a test';
    }

    public function getClassAndFinalExamTimes($term, $email){
        $user = User::email($email)->first();

        $classes = ClassMemberships::memberId($user->user_id)
            ->term($term)
            ->instructor()
            ->pluck('classes_id');

        $events = [];

        // return Event::whereIn('classes_id', $classes);
        foreach( $classes as $class ){
            $temp = Event::class($class)->with('info')->first();
            array_push($events, $temp);
        }
        return $events;
    }
}
?>