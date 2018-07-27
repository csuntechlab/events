<?php
/**
 * Created by PhpStorm.
 * User: Carlos Benavides
 * Date: 7/13/2018
 * Time: 11:24 AM
 */

namespace App\Http\Controllers;


use App\Contracts\ClassContract;
use App\ICal;
use Carbon\Carbon;
use Eluceo\iCal\Property\Event\RecurrenceRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClassController extends Controller
{
    protected $classContract;

    public function __construct(ClassContract $classContract)
    {
        $this->classContract = $classContract;
    }

    public function classInfo($term,$course_id)
    {
        return $this->classContract->classInfo($term,$course_id);
    }

    public function finalInfo($term,$course_id)
    {
        return $this->classContract->finalInfo($term , $course_id);
    }

    public function retrieveClassDetails($term,$course_id)
    {
        // original
//        $classDetails = $this->classContract->classInfo($term,$course_id);
//        $finalDetails = $this->classContract->finalInfo($term,$course_id);
        $classDetails = ["classEvents" => $this->classContract->classInfo($term,$course_id)];
        $finalDetails = ["finalEvent" => $this->classContract->finalInfo($term,$course_id)];

        $output = $classDetails + $finalDetails;
        return $output;
    }

    public function retrieveClassICS($term,$course_id)
    {
        // grab the SQL data for respective term + class id combo
        $output = $this->retrieveClassDetails($term,$course_id);
        // send the data to the service
        // will format and retrieve a class ICS
        return $this->classContract->ClassICS($output);
    }


//$output = $this->retrieveClassDetails($term,$course_id);
//
////        date_default_timezone_set('America/Los_Angeles');
//
//    // 1. Create new calendar
//$vCalendar = new \Eluceo\iCal\Component\Calendar('-//events @ META+LAB//Version 1//EN');
//
////        $created_at_calendar = date("Y-m-d H:i:s");
//
//    // 2. Create event(s)
//
//foreach ($output['classEvents'] as $event)
//{
//$course  = $event->details;
//
//$uid =  $course['classes_id'].'.'.$event['pattern_number'].'.vevent@metalab.csun.edu';
//
//    /**
//     *  dtStamp should be when the database was last updated
//     *  https://stackoverflow.com/questions/11594921/whats-the-difference-between-created-and-dtstamp-in-the-icalendar-format
//     */
//    // $dtStamp = '20180505T171003Z';
//    // modular ; maybe use that new \DateTime( $dtStamp ) when setting dtStamp
//$eventTime = date("Y-m-d H:i:s");
//$dtStamp = $eventTime;
//$lastModified = $eventTime;
//
//$class = 'PUBLIC';
//$transparent = 'OPAQUE'; // make modular
//$status = 'STATUS_'.'CONFIRMED';
//
//$categories = $event['type'];
//$summary = $course['subject'].' '.$course['catalog_number'].' ('.$course['class_number'].')';
//
//if($event['location_type']=='physical') {
//$location =  $event['location'];
//$locationAltrep ='http://academics.csun.edu/classrooms/' . $event['location'] . ':' . $event['location'];
//} else {
//    $location =  'ZOOM';
//    $locationAltrep = $event['online_url'];
//}
//$geo = null;
//
//$description = $course['description'];
//
///**
// *  $dtStart = $event[from_date] . ' ' . str_replace('h', '00Z', $event['start_time']) ;
// *  basically the same for end_time
// */
//$dtStart = '2018-08-08 ' . str_replace('h', '00Z', $event['start_time']) ;
//$dtEnd =  '2018-08-08 ' . str_replace('h', '00Z', $event['end_time']) ;
//
//$rrule = 'WEEKLY';
//$interval = '1';
//
//
///**
// * code for setting the until DATE + time
// */
//$until = '20181212T135000Z';
//// modular ; TODO: Maybe add omar.terms?
//// $until = $event['to_date'] . ' ' . $event['end_time']. 'Z';
//
//$byDay = $this->setMeetingDays($event['days'] );
//$vAlarmDescription =  $course['subject'].' '.$course['catalog_number'].' starts in 15 minutes';
//
//$vEvent = new \Eluceo\iCal\Component\Event();
//
//$vEvent
//    ->setUniqueId($uid)
//    ->setDtStamp( new \DateTime($dtStamp) ) //dtStamp 169
////                   ->setCreated( new \DateTime($created_at_calendar) ) // must create
//    ->setModified( new \DateTime($lastModified) ) // last Modified
//    ->setTrans('Transparent')
//    ->setStatus('CONFIRMED')
//    ->setCategories($categories)
//    ->setSummary( $summary )
//    ->setTimezoneString('America/Los_Angeles')
//    ->setLocation($location,$locationAltrep)
//    ->setDtStart( new \DateTime($dtStart )  )
//    ->setDtEnd(new \DateTime( $dtEnd ) )
//
//;
//
//
//$recurrenceRule = new \Eluceo\iCal\Property\Event\RecurrenceRule();
//$recurrenceRule->setFreq(\Eluceo\iCal\Property\Event\RecurrenceRule::FREQ_WEEKLY);
//$recurrenceRule->setUntil(new \DateTime( '2018-12-12 08:12:10' ));
//$recurrenceRule->setInterval(1); // final exam
//$recurrenceRule->setByDay($byDay);
////               $recurrenceRule->setUntil('2018-12-12');
//$vEvent->setRecurrenceRule($recurrenceRule);
//
//$vAlarm = new \Eluceo\iCal\Component\Alarm();
//
//$vAlarm->setTrigger('-PT15M');
//$vAlarm->setDescription($vAlarmDescription);
//$vAlarm->setAction('DISPLAY');
//
//$vEvent->addComponent($vAlarm);
//
//$vCalendar->addComponent($vEvent);
//$vEvent->setRecurrenceRule($recurrenceRule);
//$vEvent->setUseTimezone(true);
//}
//// 4. Set headers
//header('Content-Type: text/calendar; charset=utf-8');
//header('Content-Disposition: attachment; filename="cal2323.ics"');
//
//echo $vCalendar->render();
}