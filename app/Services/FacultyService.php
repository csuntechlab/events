<?php
namespace App\Services;
use App\ClassRosters;
use App\Contracts\FacultyContract;
use App\User;
use App\Event;
use App\Terms;

class FacultyService implements FacultyContract {
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
            $temps = Event::entities($class)->term($term)->with('course')->get();
            foreach( $temps as $temp ){
                if( $temp != null ){
                    /*
                    check if the start_date are null
                    if null, use omar.terms and get begin_date & end_date
                    */
                    if( $temp->from_date == null || $temp->to_date == null ){
                        $terms_table = Terms::term($temp->term_id)->first();
                        $temp->from_date = $terms_table->begin_date;
                        $temp->to_date = $terms_table->end_date;
                    }

                    if( $temp->course != null ){
                        array_push($events, $temp);
                    }
                }
            }
            
            $exam = str_replace('classes', 'final-exams', $class);
            $temp = Event::entities($exam)->term($term)->first();
            if( $temp != null ){
                array_push($events, $temp);
                // final exam will never be null
            }
        }
        return $events;
    }
}
?>
