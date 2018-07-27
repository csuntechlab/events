<?php
/**
 * Created by PhpStorm.
 * User: Carlos Benavides
 * Date: 7/13/2018
 * Time: 5:27 PM
 */

namespace App\Services;

use App\Classes;
use App\ICal;
use App\ICalFormatter;
use Illuminate\Support\Facades\Validator;
use App\Contracts\ClassContract;

class ClassService extends ICalFormatter implements ClassContract
{

    public function isValidCourseId($course_id)
    {
        $data = ['course_id' => $course_id];
        $validator = Validator::make($data, [
            'course_id' => 'digits:5'
        ]);
//            $this->validate($course_id,[
//                'course_id' => 'digits:5'
////                 $course_id => 'required|exists:posts,id',
//            ]);
//      TEMP code!!!
        if ($validator->fails()) {
            return $validator->errors();
        }
    }

    public function course_details($term,$course_id)
    {
        return [
            'Locate' => 'Classroom',
            'events' => [
                'Class Start' =>'Date 1',
                'Class End' => 'Date 2',
                'Attendance' => [
                    'Friday' => 'Day'
                ],
                'Final Exam' => 'Final Day'
            ]
         ];
    }

    public function classInfo($term, $course_id)
    {
        $queryBuilder = "classes:{$term}:{$course_id}";
        $result = Classes::Classes_id($queryBuilder)
            ->where('type','class')
            ->with('details')
            ->get();
        return $result;
    }

    public function finalInfo($term,$course_id)
    {
        $queryBuilder = "classes:{$term}:{$course_id}";

        $result = Classes::Final($queryBuilder)
                    ->where('type','final-exam')
                    ->first();
        return $result;
    }

    public function isValidTermId($termId)
    {
        $data = ['course_id' => $termId];

        $validator = Validator::make($data, [
            'course_id' => 'digits:4'
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }
    }

    public function ClassICS($output)
    {
        $fileName;
        $potentialFinalDetails;

        $vCalendar = new \Eluceo\iCal\Component\Calendar('-//events @ META+LAB//Version 1//EN');


        foreach ($output['classEvents'] as $event)
        {
            if( $event['days'] != 'A' && $event['days'] != '-' && $event['days'] != 'NULL' ){

                $this->setParamForClass($event,$event->details);
                $this->setParamByEvent($event);

                $this->setParamBySpecifications('CONFIRMED','OPAQUE', 'PUBLIC', 'WEEKLY', '1');
                $vEvent = $this->setEvent();

                $vEvent->addComponent( $this->setVAlarm() );

                $vCalendar->addComponent( $vEvent );

                $fileName = 'classes.'.$event->details->term_id.'.'.$event->details->course_id.'.'.$event->pattern_number;
                $potentialFinalDetails = $event->details;
            }
        }

        // if a final exists
        if(!empty($output['finalEvent']))
        {
            $event = $output['finalEvent'];
            if( $event['days'] != 'A' && $event['days'] != '-' && $event['days'] != 'NULL' ){
                $this->setParamForFinal($event, $potentialFinalDetails);
                $this->setParamByEvent($event);

                $this->setParamBySpecifications('CONFIRMED','OPAQUE', 'PUBLIC', 'DAILY', '1');
                //need to change

                $vEvent = $this->setEvent();

                $vEvent->addComponent( $this->setVAlarm() );

                $vCalendar->addComponent( $vEvent );
            }
        }
        $this->setFileName( $fileName );
        return $vCalendar->render();
    }
}

// old for each classes
//                //csac
//                $this->setParamForClassAndFinal($event,$event->details);
//                $this->setOpaqueAndConfirmed();
//
//                $vEvent = new \Eluceo\iCal\Component\Event();
//
//                $vEvent = $this->setEvent($event);
//                $vAlarm = new \Eluceo\iCal\Component\Alarm();
//
//                $vEvent->addComponent( $this->setVAlarm() );
//
//
//                $vEvent->addComponent($vAlarm);
//
//                $vCalendar->addComponent($vEvent);

// old final details

//                $this->setParamForFinal($event,$potentialFinalDetails);
//                $this->setParamBySpecifications('CONFIRMED','OPAQUE', 'PUBLIC', 'WEEKLY', '1');
//                $this->setParamByEvent($event);
//                $vEvent = new \Eluceo\iCal\Component\Event();
//
//                $vEvent = $this->setEvent($vEvent, $event, true);
//                $vAlarm = new \Eluceo\iCal\Component\Alarm();
//                $vAlarm = $this->setVAlarm($vAlarm);
//                $vEvent->addComponent($vAlarm);
//                $vCalendar->addComponent($vEvent);