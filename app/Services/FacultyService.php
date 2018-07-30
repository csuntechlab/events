<?php
namespace App\Services;

use App\Contracts\FacultyContract;
use App\User;
use App\ClassMemberships;
use App\Event;
use Eluceo\iCal\Property\Event\RecurrenceRule;
use App\ICalFormatter;

class FacultyService extends ICalFormatter implements FacultyContract
{


    public function getAllOfficeHours($facultyData)
    {


        $faculty_id = $facultyData['email'];
        $faculty_term = $facultyData['term']->term_id;

//        dd($faculty_id);

        //  return $faculty_id->user_id;
        $faculty_id = str_replace("members:", "", $faculty_id->user_id);


        $entities_id = 'office-hours:' . $faculty_term . ':' . $faculty_id;
        $officeHours = Event::officeHours($entities_id)
            ->term($faculty_term)
            ->type('office-hours')
            ->get();

//        dd($officeHours);


        $vCalendar = new \Eluceo\iCal\Component\Calendar('-//events @ META+LAB//Version 1//EN');

        foreach ($officeHours as $officeHour) {
//            dd($officeHour);
//             if( $officeHours['days'] != 'A' && $officeHours['days'] != '-' && $officeHours['days'] != 'NULL' && $officeHours['is_byappointment'] != 1 ){
            $this->setParamForOfficeHours($officeHour, $facultyData['email']->email);
            $this->setParamByEvent($officeHour);

            $this->setParmBySpecifications('CONFIRMED', 'OPAQUE', 'PUBLIC', 'WEEKLY', '1');

            $vEvent = $this->setEvent();
//            dd($vEvent);

            $vCalendar->addComponent($vEvent);
//             }
        }
        $this->setFileName($facultyData['email']->email);

//        dd($facultyData);
        return $vCalendar->render();

    }

}
?>