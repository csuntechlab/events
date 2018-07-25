<?php

namespace App\Services;

use App\ClassMembership;
use App\Contracts\StudentContract;
use App\Event;
use App\Registry;

class StudentService implements StudentContract
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

        if(!$entity_id) {
            return null;
        }

        if(explode(':', $entity_id)[0] != 'members'){
            return null;
        }

        $classIDs = [];

        foreach (ClassMembership::member($entity_id)->term($term)->pluck('classes_id') as $classID){
            $classIDs[] = $classID;
        }

        //return $classIDs;

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

                // TODO: create rule array with ['frequency', 'interval', 'until', 'byDay']
                $rules = [
                    // where to get?
                    // e.g.: 'WEEKLY'
                    'frequency' => 'WEEKLY',
                    // pattern_number?
                    'interval' => $event['pattern_number'],
                    // dtStart
                    'until' => $event['rules'],
                    'byDay' => $event['rules']
                ];

                $myEvent['rules'] = $rules;
                // dtStart
                $myEvent['from'] = $event['from_date'] . 'T' . $event['start_time'];
                // dtEnd
                $myEvent['to'] = $event['from_date'] . 'T' . $event['end_time'];
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
                    $myEvent['location'] .= '"https://academics.csun.edu/classrooms/'.$event['location'].'":'.$event['location'];
                }else if($event['location_type'] == 'online'){
                    $myEvent['location'] .= '"'.$event['online_url'].'":'.$event['online_label'];
                }
                // do we have a geo location in the db?
                $myEvent['geo'] = null;

                $myEvent['description'] = $event['description'];

                // just to test one event
                return $myEvent;
//                 $myEvents[] = $myEvent;
             }
        }

        return json_encode($myEvents);
        //var_dump($classes->first()['email']);
        /**/
    }
}