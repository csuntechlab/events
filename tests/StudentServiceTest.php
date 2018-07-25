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
    public function gets_classes_table_from_studentService(){
        $term = '2153';
        // terms: 2153, 2157
        //members:000021541
        $email = 'nr_kim.goldberg-roth';

        $studentService = new StudentService();

//        $this->assertEquals(true, true);

        var_dump($studentService->termClasses($term, $email));
    }
}
