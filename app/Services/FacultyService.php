<?php
namespace App\Services;
use App\ClassMemberships;
use App\User;
use App\Event;
use App\Contracts\FacultyContract;
class FacultyService implements FacultyContract {

    public function getClassList($term,$email)
    {
        $user = User::email($email)->first();
        $classes = ClassMemberships::memberId($user->user_id)
            ->term($term)
            ->instructorRole()
            ->pluck('classes_id');

        $events = [];

        foreach( $classes as $class ){
            $temp = Event::class($class)
            ->with('course')
            ->get();
            array_push($events, $temp);
        }
        return $events;

    }
    
    public function getFinalExamTimes($term,$email)
    {
        $finalExamList = ClassMemberships::email($email)
        ->term($term)
        ->instructorRole()
        ->with('course','finalExamEvents')
        // ->get();
        ->first();

        return $finalExamList;
    }

    public function getOfficeHours($term,$email)
    {
        $userId = User::email($email)->first();

        $userId = str_replace("members:","",$userId['user_id']);

        $entities_id = 'office-hours:'.$term.':'.$userId; 

        $officeHours = Event::officeHours($entities_id)
        ->term($term)
        ->type('office-hours')
        // ->with('course')
        ->get();

        return $officeHours;
    }
    
}
?>