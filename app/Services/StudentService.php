<?php

namespace App\Services;
use App\Contracts\StudentContract;
use App\Models\ClassMembership;
use App\Models\Event;

class StudentService implements StudentContract
{

    // TODO: finish function
    public function termClasses($term, $email)
    {
        $classMemberships = ClassMembership::email($email)->term($term)->get();

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
                    'frequency' => '',
                    // pattern_number?
                    'interval' => $class['pattern_number'],
                    // dtStart
                    'until' => $class['rules'],
                    'byDay' => $class['rules']
                ];

                $myEvent['rules'] = $rules;
                $myEvent['from'] = $class['from'];
                $myEvent['to'] = $class['to'];
                $myEvent['dtStamp'] = $class['dtStamp'];
                $myEvent['categories'] = $class['categories'];
                $myEvent['location'] = $class['location'];
                $myEvent['geo'] = $class['geo'];

                $myEvent['description'] = $class['description'];
                    /**/
//                 $myEvents[] = $myEvent;
             }
        }

        return $myEvents;
        //var_dump($classes->first()['email']);
    }
}