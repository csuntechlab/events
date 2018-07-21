<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    //
    public function getParam($course, $event)
    {
        $uid = $course['classes_id'].$event['patten_number'].'.vevent@metalab.csun.edu'; 
        
        $summary = $course['subject'].' '.$course['catalog_number'].' ('.$course['class_number'].')';

        $altRep = 'http://academics.csun.edu/classrooms/'.$event['location'].':'.$event['location'];

        $icsInfo = [];
        $icsInfo['uid'] = $uid;
        $icsInfo['dtStamp'] = '20180505T171003Z';
        $icsInfo['created'] = '20180505T170922Z';
        $icsInfo['lastModified'] = '20180505T171003Z';
        $icsInfo['class'] = 'public';
        $icsInfo['transpartent'] = 'OPAQUE';
        $icsInfo['status'] = 'CONFIRMED';
        $icsInfo['catagories'] = $event['type']; 
        $icsInfo['summary'] = $summary;
        $icsInfo['locationAltRep'] = $altRep;
        $icsInfo['geo'] = '34.2373175;-118.533936'; 
        $icsInfo['desription'] = null;
        $icsInfo['dtstart'] = 'America/Los_Angeles:20180827T130000';
        $icsInfo['dtend'] = 'America/Los_Angeles:20180827T135000';
        $icsInfo['rRule'] = 'weekly';
        $icsInfo['interval'] = '1';
        $icsInfo['until'] = '20181212T135000Z';
//change later if satement 
        $icsInfo['byDay'] = 'MO,WE'; 

        $icsInfo['vAlarmDescription'] =  $course['subject'].' '.$course['catalog_number'].' starts in 15 minutes';

        // dd($icsInfo);
        return $icsInfo;

    }
}
