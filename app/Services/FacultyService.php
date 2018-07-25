<?php
namespace App\Services;
use App\ClassRosters;
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

        $classes = ClassRosters::individualsId($user->user_id)
            ->termClasses($term)
            ->instructor()
            ->pluck('classes_id');
            
        $events = [];

        // return Event::whereIn('classes_id', $classes);
        foreach( $classes as $class ){
            $temps = Event::entities($class)->term($term)->with('info')->get();
            foreach( $temps as $temp ){
                if( $temp != null ){
                    array_push($events, $temp);
                }
            }
            
            $exam = str_replace('classes', 'final-exams', $class);
            $temp = Event::entities($exam)->term($term)->first();
            if( $temp != null ){
                array_push($events, $temp);
            }
        }
        return $events;
    }
}
?>
