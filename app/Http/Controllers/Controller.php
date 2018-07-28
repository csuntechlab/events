<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use App\Event;
use App\User;
use App\Classes;
use \Carbon\Carbon;

use Eluceo\iCal\Property\Event\RecurrenceRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\ICal;

class Controller extends BaseController
{

}
