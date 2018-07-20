<?php

use App\Contracts\ClassContract;
use App\Http\Controllers\ClassController;
use App\Services\ClassService;

/**
 * Created by PhpStorm.
 * User: Carlos Benavides
 * Date: 7/14/2018
 * Time: 2:27 PM
 */

class classTest extends TestCase
{

    public $retriever;
    public function setUp()
    {
        parent::setUp();
        $this->retriever = Mockery::spy(ClassContract::class);
    }


    /**
     * @test
     */
    public function test_the_final_method()
    {
        $data = [
            'pattern_number'=> 1,
            'type' => "final",
            "label" => "Final Meeting Time",
            "description" => null,
            "start_time" => "1000h",
            "end_time" => "1225h",
            "days" => "TH",
            "from_date" => "2018-12-15",
            "to_date" => "2018-12-15",
            "location_type"=> "physical",
            "location "=> "Not AC210",
            "booking_url" => "Prob wont need this...",
            'online_label' => "And this...",
            "online_url" => "or this...",
        ];

        $this->retriever
             ->shouldReceive('finalInfo')
             ->with(2187,16258)
             ->andReturn(json_encode($data));

        $this->assertEquals(json_encode($data),$this->retriever->finalInfo(2187,16258));
    }

    /**
     * @test
     */
    public function test_the_url_with_a_given_course_id_return_course_id()
    {
        $this->retriever
            ->shouldReceive('isValidCourseId')
            ->with(2187)
            ->andReturn(2187);

        $result = 2187;
        $output = $this->retriever->isValidCourseId(2187);
        $this->assertEquals($result,$output);
    }

    /**
     * @test
     */
    public function test_the_url_with_a_given_term_id_return_term_id()
    {
        $this->retriever
            ->shouldReceive('isValidTermId')
            ->with(16258)
            ->andReturn(16258);

        $result = 16258;
        $output = $this->retriever->isValidTermId(16258);
        $this->assertEquals($result,$output);
    }

    /**
     * @test
     */
    public function test_classes_route_GET_expect_200()
    {
        $response = $this->call('GET', '1.0/terms/2323/classes/12345'); // searches for term 2323, and course id 12345
        $this->assertEquals(200, $response->status());
    }
}