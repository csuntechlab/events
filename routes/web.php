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

// Classes route

//$router->get('/classes/{course_id}', 'ClassController@courses');
//$router->get('1.0/terms/{term}/faculty/{email}’,’FacultyController@getClassList');

$router->get('1.0/terms/{term}/classes/{course_id}', [
    'as' => 'class', 'uses' => 'ClassController@courses'
]);