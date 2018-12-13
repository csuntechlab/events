<?php

// http://localhost:8888/metalab/calendar/public/1.0/terms/2153/faculty/shahriar.abachi
// http://localhost:8888/metalab/calendar/public/1.0/terms/2173/faculty/nerces.kazandjian


// $router->get('1.0/terms/{term}/faculty/{email}','FacultyController@getClassList');

$router->get('terms/{term}/faculty/{email}','FacultyController@getInstructorInfo');

// $router->get('/terms/{term}/faculty/{email}','FacultyController@getFinalExamTimes');


// Classes route

//$router->get('1.0/terms/{term}/classes/{course_id}', [
//    'as' => 'class', 'uses' => 'ClassController@courses'
//]);
$router->get('terms/{term}/classes/{course_id}', [
    'as' => 'class', 'uses' => 'ClassController@classInfo'
]);

// $router->get('1.0/terms/{term}/faculty/{email}','FacultyController@getClassList');
// $router->get('/terms/{term}/faculty/{email}','FacultyController@getFinalExamTimes');


$router->get('test','ClassController@test');

// without name
//$router->get('1.0/term/{term}/students/{email}', 'StudentController@termClasses');

// with name
// terms/2197/students/john.smith.302


$router->get('terms/{term}/students/{email}', [
    'as' => 'students.termClasses', 'uses' => 'StudentController@termClasses'
]);