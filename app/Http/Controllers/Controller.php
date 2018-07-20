<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    //
    public function getParam($class, $course, $event)
    {
        $icsInfo = [];
        $icsInfo['uid'] = $class['classes_id'].$event['patten_number'].'.vevent@metalab.csun.edu'; 
        //fix later hard coding
        $icsInfo['dtStamp'] = '20180505T171003Z';
        $icsInfo['created'] = '20180505T170922Z';
        $icsInfo['lastModified'] = '20180505T171003Z';
        $icsInfo['class'] = 'public';
        $icsInfo['transpartent'] = 'OPAQUE';
        $icsInfo['status'] = 'CONFIRMED';
        $icsInfo['catagories'] = $event['type']; 
        $icsInfo['summary'] = $course['subject'].' '.$course['catalog_number'].' ('.$course['class_number'].')';
        $icsInfo['locationAltRep'] = 
        'http://academics.csun.edu/classrooms/'.$event['location'].':'.$event['location'];
        $icsInfo['geo'] = '34.2373175;-118.533936'; 
        $icsInfo['desription'] = null;
        $icsInfo['dtstart'] = 'America/Los_Angeles:20180827T135000';
        $icsInfo['dtend'] = 'America/Los_Angeles:20180827T135000';
        $icsInfo['rRule'] = 'weekly';
        $icsInfo['interval'] = '1';
        $icsInfo['until'] = '20181212T135000Z';
//change later if satement 
        $icsInfo['byDay'] = 'MO,WE'; 

        //add vlarms later

        return $icsInfo;

    }
}
