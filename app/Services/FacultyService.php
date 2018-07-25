<?php
namespace App\Services;

use App\Contracts\FacultyContract;
use App\User;
use App\ClassMemberships;
use App\Event;

class FacultyService implements FacultyContract {



    public function getAllOfficeHours($facultyData){


        //find term first then find faculty in that term thru email
        $faculty_id = $facultyData['email'];
        $faculty_term = $facultyData['term']->term_id;

          //  return $faculty_id->user_id;
            $faculty_id = str_replace("members:","",$faculty_id->user_id);

        //$faculty_id = User::findOrFail($facultyData['term'])->find($facultyData['email']);

        $entities_id = 'office-hours:'.$faculty_term.':'.$faculty_id;
        $officeHours = Event::officeHours($entities_id)
            ->term($faculty_term)
            ->type('office-hours')
            ->get();


       // foreach ($officeHours as $officeHour) {

           // $this->officeHoursData = [

               // 'office_hours' => $officeHours->office_hours;
            //];
            //officeHour = Event::officeHours($new_id_from_strReplace)


        //echo $officeHour['term_id'];



      //  }
       // dd($officeHours->term);
        return $officeHours;
       // return $this->jsonResponse();
    }
}
?>