<?php

namespace App\Services;

use App\ClassMembership;
use App\Contracts\StudentContract;
use App\Event;

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

        $studentEntities = Registry::email($email)->get();

        $classMemberships = [];

        foreach($studentEntities as $entity){
            foreach (ClassMembership::member($entity['entities_id'])->term($term)->get() as $classMembership){
                $classMemberships[] = $classMembership;
            }
        }

        $myEvents = [];

        foreach ($classMemberships as $class) {
            // get all events for a specific class
            foreach (Event::entities($class['classes_id'])->get() as $myEvent) {
                $myEvent['summary'] = $class['label'];
                    /**/
                $myEvent['uid'] = $class['type'] . '.' . $class['term_id'] . '.' . $class['pattern_number'] . '.vevent@metalab.csun.edu';
                if($class['type'] == 'class'){
                    $myEvent['status'] = 'CONFIRMED';
                    $myEvent['transparent'] = 'OPAQUE';
                }else if($class['type'] == 'office-hours'){
                    $myEvent['status'] = 'TENTATIVE';
                    $myEvent['transparent'] = 'TRANSPARENT';
                }else if($class['type'] == 'finals'){
                    $myEvent['status'] = 'CONFIRMED';
                    $myEvent['transparent'] = 'OPAQUE';
                }

                // TODO: create rule array with ['frequency', 'interval', 'until', 'byDay']
                $rules = [
                    // where to get?
                    // e.g.: 'WEEKLY'
                    'frequency' => 'WEEKLY',
                    // pattern_number?
                    'interval' => $class['pattern_number'],
                    // dtStart
                    'until' => $class['rules'],
                    'byDay' => $class['rules']
                ];

                $myEvent['rules'] = $rules;
                $myEvent['from'] = $class['from'];
                $myEvent['to'] = $class['to'];
                // dt
                $myEvent['dtStamp'] = date('Y-m-d').time();
                $myEvent['categories'] = $class['categories'];
                $myEvent['location'] = $class['location'];
                // do we have a geo location in the db?
                $myEvent['geo'] = null;

                $myEvent['description'] = $class['description'];
                    /**/
//                 $myEvents[] = $myEvent;
             }
        }

        return $myEvents;
        //var_dump($classes->first()['email']);
    }
}