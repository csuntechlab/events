<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function getClassParam($output)
    {
        $icsInfo['uid']= 'classes.'.$output->details->term_id.'.'.$output->details->course_id.'.'.$output->pattern_number;
        //fix later hard coding
//        dd($output->start_time.$output->end_time);
        $icsInfo['dtStamp'] = date('Ymd').'T'.date('His').'Z';
        $icsInfo['created'] = date('Ymd').'T'.date('His').'Z';
        $icsInfo['lastModified'] = date('Ymd').'T'.date('His').'Z';
        $icsInfo['class'] = 'public';
        $icsInfo['transparent'] = 'OPAQUE';
        $icsInfo['status'] = 'CONFIRMED';
        $icsInfo['categories'] = $output['type'];
        $icsInfo['summary'] = $output->details->subject.' '.$output->details->catalog_number;
        $icsInfo['locationAltRep'] =
            '"http://academics.csun.edu/classrooms/'.$output->location.'":'.$output->location;
        $icsInfo['geo'] = '34.2373175;-118.533936';
        $icsInfo['description'] = null;
        $stringer = str_replace('h', '', $output->start_time);
        $icsInfo['dtstart'] = 'America/Los_Angeles:20180827T130000';
        $icsInfo['dtend'] = 'America/Los_Angeles:20180827T135000';
        $icsInfo['rRule'] = 'WEEKLY';
        $icsInfo['interval'] =1;
        $icsInfo['until'] = '20181212T135000Z';
        $icsInfo['pattern'] = $output->details->section_number;
//change later if satement
        $icsInfo['byDay'] ='Mo,We';
        //add vlarms later
        return $icsInfo;
    }
}
