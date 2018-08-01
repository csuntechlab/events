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


       /* $facultyData = [
            'term' => Event::where('term_id', $term)->first(),
            //'term' => Event::findOrFail($term),
            'email'=> User::where('email', $email.'@csun.edu')->first(),

        ];*/

//        return $facultyData;


        return $this->facultyRetriever->getAllOfficeHours($term,$email);


//        dd($facultyData);
//
       // return $officeHours;
    }




}

