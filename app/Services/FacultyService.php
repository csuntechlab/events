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
        ->with('classEvents')
        ->get();

        return $classList;
    }
    
    public function getFinalExamTimes($term,$email)
    {
        $finalExamList = ClassMemberships::email($email)
        ->term($term)
        ->instructorRole()
        ->with('finalExamEvents')
        ->get();

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
        ->get();

        return $officeHours;
    }
    
}
?>