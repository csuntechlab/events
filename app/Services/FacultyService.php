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
        return 'this is a test';
    }

    public function getOfficeHours($term,$email)
    {
        $userId = User::email($email)->first();

        $userId = str_replace("members:","",$userId['user_id']);

        $entities_id = 'office-hours:'.$term.':'.$userId; 

        $officeHours = Event::officeHours($entities_id)
        ->term($term)
        ->get();

        return $officeHours;
    }
    
}
?>