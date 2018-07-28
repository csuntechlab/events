<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Http\Controllers\StudentController;
use App\ICal;

class StudentControllerTest extends TestCase
{
    /**
     * this is an anotation
     *
     * @return void
     */

    /**
     * @test
     */
    public function testing_mockery(){
        $mock = Mockery::mock('\App\Contracts\StudentContract');

        $mock->shouldReceive('termClasses')->once()->andReturn('1');

        $mock->termClasses('fall', 'some.email');
        $this->assertTrue(true);
        //var_dump($mock->termClasses('fall', 'some.email'));
    }

    /**
     * @test
     */
    public function termClasses_converts_array_to_a_json(){

        $events = [6];
        for($i = 0; $i < 6; $i++) {
            $events[$i] = [
                'entities_id' => 'classes:2187:1234' . $i,
                'term_id' => '2187',
                'pattern_number' => '9999',
                'type' => 'class',
                'label' => 'Class',
                'description' => 'This is a description',
                'start_time' => ($i + 4) . ':00 am',
                'end_time' => ($i + 8) . ':00 am',
                'days' => 'Mo_We',
                'from_date' => '07-02-2018',
                'to_date' => '09-02-2018',
                'location_type' => 'physical',
                'location' => 'JD2215',
                'is_byappointment' => '0',
                'is_walkin' => '0',
                'booking_url' => 'bookMyOfficeHours.com',
                'online_label' => 'zoom',
                'online_url' => 'https://csun.zoom.us/j/5024885325',
            ];
        }

        $mockStudentService = Mockery::mock('\App\Services\StudentService');

        $mockStudentService->shouldReceive('termClasses')->once()->andReturn($events);

        $studentController = new StudentController($mockStudentService);

        $this->assertJson($studentController->termClasses('3124', 'me.me'));
    }
}
