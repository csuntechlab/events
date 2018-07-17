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
        $this->retriever
            ->shouldReceive('course_details')
            ->with(2187,16258)
            ->andReturn(json_encode(['class_details' => [
                'Locate' => 'JD3504',
                'events' => [
                    'Class Start' =>'Aug 25,2018',
                    'Class End' => 'Dec 11,2018',
                    'Attendance' => [
                        'Friday' => '9:00 am to 12:15 pm'
                    ],
                    'Final Exam' => 'Dec 15,2018'
                ]
            ]]));

        $controller = new ClassController($this->retriever);
        $returnArray = [
            'Locate' => 'JD3504',
            'events' => [
                'Class Start' =>'Aug 25,2018',
                'Class End' => 'Dec 11,2018',
                'Attendance' => [
                    'Friday' => '9:00 am to 12:15 pm'
                ],
                'Final Exam' => 'Dec 15,2018'
            ]
        ];
        $output = $controller->courses(2187,16258);
        $this->assertEquals($output, json_encode(['class_details' =>$returnArray]));
    }

}