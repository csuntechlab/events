<?php
/**
 * Created by PhpStorm.
 * User: Carlos Benavides
 * Date: 7/15/2018
 * Time: 1:37 PM
 */
namespace Tests\Controllers;
use App\Contracts\ClassContract;
use App\Http\Controllers\ClassController;
use App\Services\ClassService;
use Mockery;

class ClassControllerTest extends \TestCase
{
    protected $retriever;
    public function setUp()
    {
        parent::setUp();
        $this->retriever = Mockery::spy(ClassContract::class);
    }

    /** @test */
    public function getCourseDetails_with_course_id()
    {
        $data = [
        'pattern_number'=> 1,
        'type' => "class",
        "label" => "Class Meeting Time",
        "description" => null,
        "start_time" => "0800h",
        "end_time" => "0825h",
        "days" => "MW",
        "from_date" => null,
        "to_date" => null,
        "location_type"=> "physical",
        "location "=> "AC210",
        "booking_url" => null,
        'online_label' => null,
        "online_url" => null,
        "get_details" => [
        "term_id" => 2153,
            "term"=> "Spring-2015",
            "course_id"=> 19009,
            "subject"=> "ART",
            "catalog_number"=> "100",
            "title"=> "Introduction to Art Processes",
            "section_number"=> "01"
            ]
        ];


        $this->retriever
            ->shouldReceive('classInfo')
            ->with(2187,16258)
            ->andReturn(json_encode($data));

        $controller = new ClassController($this->retriever);
        $output = $controller->classInfo(2187,16258);

        $this->assertEquals(json_encode($data), $output);
    }


    /**
     * @test
     */
    public function controller_test_the_final_info_retriever()
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

        $controller = new ClassController($this->retriever);
        $result = $controller->finalInfo(2187,16258);

        $this->assertEquals(json_encode($data),$result);
    }

}