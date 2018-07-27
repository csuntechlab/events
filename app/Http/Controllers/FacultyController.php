<?php

namespace App\Http\Controllers;
use App\Contracts\FacultyContract;
use App\User;
use App\Event;
use App\ICal;

class FacultyController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $facultyRetriever;


    public function __construct(FacultyContract $facultyRetriever)
    {
        $this->facultyRetriever = $facultyRetriever;

    }



    public function getClassList($term,$email)
    {
        $data = [

            'term' => Event::where('term_id', $term)->first(),
            //'term' => Event::findOrFail($term),
            'email'=> User::where('email', $email.'@csun.edu')->first(),

        ];
        $classList = $this->facultyRetriever->getClassList($data);
        return  $classList;
    }


    public function getAllOfficeHours($term,$email){

        //find term first then find faculty in that term thru email
        //$faculty_id = User::email($email)->first();
        //$faculty_id = str_replace("members:","",$userId['user_id']);

        //$instructorInfo['officeHours'] = $this->getAllOfficeHours($term, $email);


        $facultyData = [
            'term' => Event::where('term_id', $term)->first(),
            //'term' => Event::findOrFail($term),
            'email'=> User::where('email', $email.'@csun.edu')->first(),

        ];


        $officeHours = $this->facultyRetriever->getAllOfficeHours($facultyData);
        /* $faculty = Faculty::with('term', 'office_hours.term')->find($id);*/

       // $ical = new ICal();
        //$controller = new Controller();


// return $facultyData;
      //  foreach ($officeHours as $officeHour){
        //    $event = $officeHour;
//sets global parm for office hours
           // $controller->setParamForOfficeHours($event,$email);
//gets ical param
            //$icalParam = $controller->getParam($event);
//adds ical event with param , boolean is for adding alarm
            //$ical->addEvent($icalParam,false);
      //  }


        //$ical->setFileName($email);
//generates an ics file for download
        //return $ical->generateICS();

         return json_encode($officeHours);
    }




}

