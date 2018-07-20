j<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class StudentTest extends TestCase
{
    /**
     * this is an anotation
     *
     * @return void
     */

//    protected $student = null;

    public function setUp(){
        parent::setUp();
//        $studentService = new \App\Services\StudentService();
//        $this->student = new \App\Http\Controllers\StudentController($studentService);
    }

    /**
     * @test
     */
    public function gets_classes_table_from_studentService(){
        $term = '2197';
        $email = 'john.smith.302';

        $studentService = new \App\Services\StudentService();

        $this->assertEquals($studentService->termClasses($term, $email), );

        //var_dump($studentController->classes('some.email'));
    }

    /**
     * @test
     */
    public function gets_classes_table_from_studentService(){
        // create array to represent our mocked database table for studentServices.
        $mockedTable = [
            'key1' => 'value1',
            'key2' => 'value2'
        ];

        $mockStudentService = Mockery::mock('App\Services\StudentService');

        $mockStudentService->shouldReceive('termClasses')->andReturn($mockedTable);

        $studentController = new \App\Http\Controllers\StudentController($mockStudentService);

        $this->assertEquals($mockedTable, $mockStudentService->termClasses('fall', 'some.email'));

        //var_dump($studentController->classes('some.email'));
    }

    /**
     * @test
     */
    public function testing_mockery(){
        $mock = Mockery::mock('\App\Services\StudentService');

        $mock->shouldReceive('termClasses')->once()->andReturn('1');

        var_dump($mock->termClasses('fall', 'some.email'));
    }
}
