<?php

namespace App\Services;

use App\ClassMembership;
use App\Contracts\StudentContract;
use App\Event;
use App\ICalFormatter;
use App\Registry;

class StudentService extends ICalFormatter implements StudentContract
{

    // TODO: finish function
    /**
     * @param $term
     * @param $email
     * @return array
     */
    public function termClasses($term, $email)
    {

        //$classMemberships = ClassMembership::email($email)->term($term)->get();

        $entity_id = Registry::email($email)->first()['entities_id'];

        //return $entity_id;

        if (!$entity_id) {
            return null;
        }

        if (explode(':', $entity_id)[0] != 'members') {
            return null;
        }

        $classIDs = ClassMembership::member($entity_id)->termID($term)->pluck('classes_id');

        // bedrock.events CHECK
        // omar.classes get courses

        //TODO: use this shit
        $json = [];
        foreach ($classIDs as $class) {
            $events[] = Event::entities($class)->get();
        }

        return $events;
    }

    private function throwAway($classIDs){
        $myEvents = [];

        // in case there is more than one event per class
        foreach ($classIDs as $classID) {
            // get all events for a specific class
            foreach (Event::entities($classID)->get() as $event) {
                $myEvent['summary'] = $event['label'];

                $myEvent['uid'] = $event['type'] . '.' . $event['term_id'] . '.' . $event['pattern_number'] . '.vevent@metalab.csun.edu';

                switch ($event['type']){
                    case 'class':
                        $myEvent['status'] = 'CONFIRMED';
                        $myEvent['transparent'] = 'OPAQUE';
                        break;
                    case 'office-hours':
                        $myEvent['status'] = 'TENTATIVE';
                        $myEvent['transparent'] = 'TRANSPARENT';
                        break;
                    case 'finals':
                        $myEvent['status'] = 'CONFIRMED';
                        $myEvent['transparent'] = 'OPAQUE';
                        break;
                }

                $to_date = '2018-08-08';// $event['to_date'];
                $from_date = '2018-12-12';// $event['from_date'];

                $start_time = str_replace('h', '00Z', $event['start_time']);
                $end_time = str_replace('h', '00Z', $event['end_time']);

                // TODO: create rule array with ['frequency', 'interval', 'until', 'byDay']
                $rules = [
                    // where to get?
                    // e.g.: 'WEEKLY'
                    'frequency' => 'WEEKLY',
                    // pattern_number?
                    'interval' => $event['pattern_number'],
                    // dtStart
                    'until' =>  $to_date . 'T' . $end_time
                ];

                $trans = array("M" => "MO,", "T" => "TU,", "W" => "WE,", "R" => "TH,", "F" => "FR,", "S" => "SA," );

                $dayICal = strtr($event['days'] , $trans);

                $rules['byDay'] = substr($dayICal, 0 ,-1);

                $myEvent['rules'] = $rules;
                // dtStart
                $myEvent['from'] = $from_date . 'T' . $start_time;
                // dtEnd
                $myEvent['to'] = $from_date . 'T' . $end_time;
                // dt
                $myEvent['dtStamp'] = $event['updated_at'];
                $myEvent['categories'] = $event['type'];

                // does not work:
                // https://academics.csun.edu/classrooms/JD3520
                // does work:
                // https://3dmap.csun.edu/?id=1100#!s/jd%201600?ct/25911,25835,24890,24880,0,22013,22231
                // prototype and best option:
                // http://www.sandbox.csun.edu/classrooms/EU103
                if($event['location_type'] == 'physical'){
                    $myEvent['link'] = 'https://academics.csun.edu/classrooms/'.$event['location'];
                    $myEvent['location'] = $event['location'];
                }else if($event['location_type'] == 'online'){
                    $myEvent['link'] = $event['online_url'];
                    $myEvent['location'] = $event['online_label'];
                }
                // do we have a geo location in the db?
                $myEvent['geo'] = null;

                $myEvent['description'] = $event['description'];

                // just to test one event
                $myEvents[] = $myEvent;
             }
        }

        return $myEvents;
        //var_dump($classes->first()['email']);
        /**/
    }
}