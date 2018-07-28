<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use App\Event;
use App\User;
use App\Classes;
use \Carbon\Carbon;

class Controller extends BaseController
{
    public function exportICS($events){
        $ics = "BEGIN: VCALENDAR\n"
        ."VERSION:2.0\n"
        ."CALSCALE:GREGORIAN\n"
        ."PRODID:-//events @ META+LAB//Version 1//EN\n"
        ."METHOD:PUBLISH\n";

        $ics .= $this->addEventsToICS($events);

        return $ics;
    }

    public function addEventsToICS($events){
        $ics = "";
        foreach( $events as $event ){
            $classes = $event->info;
            $ics .= "BEGIN:VEVENT\n";
            $ics .= "\tUID:" . $event->entities_id . $event->pattern_number . ".vevent@metalab.csun.edu\n";
            $ics .= "\tDTSTAMP:" . ($event->updated_at == NULL ? ";" : date('Ymd\THis\Z', $event->updated_at)) . "\n";
            $ics .= "\tCREATED:" . Carbon::now() . "\n"; // when ics file was created
            $ics .= "\tLAST-MODIFIED" . ($event->updated_at == NULL ? ";" : ":" . date('Ymd\THis\Z', $event->updated_at)) . "\n";
            $ics .= "\tCLASS:PUBLIC\n";
            $ics .= "\tTRANSP:OPAQUE\n";
            $ics .= "\tSTATUS:CONFIRMED\n";
            $ics .= "\tCATEGORIES:" . ucfirst($event->type) . "\n";
            $ics .= "\tSUMMARY:" . $classes->subject . " " . $classes->catalog_number . "(" . $classes->class_number . ")" . "\n";
            $ics .= "\tLOCATION:" . $event->location;
            $ics .= ";ALTREP=" . '"http://academics.csun.edu/classrooms/' . $event->location . '":' . $event->location . "\n";
            $ics .= "\tGEO:34.2373175;-118.533936\n";
            $ics .= "\tDESCRIPTION" . ($classes->description == NULL ? ";" : ":" . $classes->description) . "\n";
            $ics .= "\tDTSTART;TZID=America/Los_Angeles:";
        }
        return $ics;
    }
}
