<?php
namespace App\Services;

use App\ClassMemberships;
use App\User;

use App\Event;
use App\Contracts\FacultyContract;

class FacultyService implements FacultyContract {

    public function getClassList($term,$email)
    {
        $classList = ClassMemberships::email($email)
        ->term($term)
        ->instructorRole()
        // ->with('course', 'classEvents')
        ->with('course', 'events')
        ->get();

        return $classList;
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
        ->with('course')
        ->get();

        return $officeHours;
    }

    public function getInstructorInfo($term,$email)
    {
        $instructorInfo['classList'] = ClassMemberships::email($email)
        ->term($term)
        ->instructorRole()
        ->with('course', 'events')
        ->get();

        $userId = User::email($email)->first();

        $userId = str_replace("members:","",$userId['user_id']);

        $entities_id = 'office-hours:'.$term.':'.$userId; 

        $instructorInfo['officeHours'] = Event::officeHours($entities_id)
        ->term($term)
        ->type('office-hours')
        ->get();

        return $instructorInfo;
    }
    
}
?>