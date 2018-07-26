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
        $days = 'MTWRFS';
        $daysArray = str_split($days);

        $trans = array(“M” => “MO“, “T” => “TU“, “W” => “WE“, “R” => “TH“, “F” => “FR“, “S” => “SA” );

        $dayICal = strtr($days, $trans);

//        $days = preg_split("/\s*/", 'MTWRFS');
//        array_shift($days);
//        array_pop($days);
//        $days = implode(',', $days);

        var_dump(
            $dayICal
            //$days
            //$days[1]
            //array_shift($days)
            //preg_split("/\s*/", 'MTWRFS')
        );
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
