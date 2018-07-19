<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class DatabaseTest extends TestCase
{
    /**
     * this is an anotation
     *
     * @return void
     */

    /**
     * @test
     */
    public function gets_classes_table_from_studentService(){
        $term = '2197';
        $email = 'john.smith.302';

        $studentService = new \App\Services\StudentService();

//        $this->assertEquals($studentService->termClasses($term, $email), );

        var_dump($studentService->termClasses($term, $email));
    }
}
