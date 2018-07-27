<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Services\StudentService;

class StudentServiceTest extends TestCase
{
    /**
     * this is an anotation
     *
     * @return void
     */

    /**
     * @test
     */
    public function test_some_stuff(){
        $arg = [
            'something',
            'somethingElse'
        ];
        $this->assertEquals('1', 1);
        //$this->assertEquals($arg, json_encode($arg));
    }

    /**
     * @test
     */
    public function gets_classes_table_from_studentService(){
        $term = '2153';
        // terms: 2153, 2157
        //members:000021541
        $email = 'nr_kim.goldberg-roth';

        $studentService = new StudentService();

//        $this->assertEquals(true, true);

        var_dump(var_dump($studentService->termClasses($term, $email)));
    }
}
