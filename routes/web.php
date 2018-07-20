<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});


// http://localhost:8888/metalab/calendar/public/1.0/terms/2187/faculty/nr_nerces.kazandjian

// $router->get('1.0/terms/{term}/faculty/{email}','FacultyController@getClassList');

$router->get('1.0/terms/{term}/faculty/{email}','FacultyController@getInstructorInfo');

// $router->get('/terms/{term}/faculty/{email}','FacultyController@getFinalExamTimes');

// without name
//$router->get('1.0/term/{term}/students/{email}', 'StudentController@termClasses');

// with name
// terms/2197/students/john.smith.302

$router->get('1.0/terms/{term}/students/{email}', [
    'as' => 'students.termClasses', 'uses' => 'StudentController@termClasses'
]);

