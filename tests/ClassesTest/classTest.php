<?php

use App\Contracts\ClassContract;
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

    /** @test */
    public function getCourseDetails_with_course_id()
    {
        $this->retriever
            ->shouldReceive('course_details')
            ->withArgs([2187,16258])
            ->andReturn(\json_encode(['class_details' => [
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
        $output = $this->retriever->course_details(2187,16258);
        $this->assertEquals($output, \json_encode(['class_details' =>$returnArray]));
    }

    /**
     * @test
     */
    public function test_classes_route_GET_expect_200()
    {
        $response = $this->call('GET', '1.0/terms/2323/classes/4324234'); // (goes to '/classes/3')
        $this->assertEquals(200, $response->status());
    }


    public function test_term_validate()
    {
        $this->retriever
            ->shouldReceive('isValidTermId')
            ->withArgs([2187])
            ->andReturn(true);
        $course_id = 12345;
        $output = $this->retriever->isValidTermId(2187);
        $this->assertTrue($output);
    }

}