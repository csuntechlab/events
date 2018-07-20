<?php
declare(strict_types=1);

namespace Tests\Controllers;
use App\Contracts\FacultyContract;
use App\Http\Controllers\FacultyController;
use Mockery;
use PHPUnit\Framework\TestCase;


class FacultyControllerTest extends TestCase
{
    protected $retriever;

    public function setUp()
    {
        parent::setUp();
        $this->retriever = Mockery::spy(FacultyContract::class);
    }

    public function tearDown(){

        Mockery::close();
    }

    public function professor(){

        $response = $this->call('GET', '1.0/terms/2187/faculty/steven.fitzgerald');
        $this->assertEquals(200, $response->status());


    }

    /**
     * @test
     */

    public function returns_all_office_hours_of_given_professor(){

        $officeHours = json_encode(
            [
                [
                    "entities_id" => "office-hours:2187:000420312",
                    "term_id" => '2187',
                    "pattern_number" => '1',
                    "type" => "office-hours",
                    "label" => "General Office Hours",
                    "description" => "",
                    "start_time" => "11:00 AM",
                    "end_time" => "12:00 PM",
                    "days" => "WF",
                    "from_date" => 'null',
                    "to_date" => 'null',
                    "location_type" => "physical",
                    "location" => "HOME",
                    "is_byappointment" => '0',
                    "is_walkin" => '1',
                    "booking_url" => 'null',
                    "online_label" => 'null',
                    "online_url" => 'null',
                    "created_at" => "2018-07-18 16:24:03",
                    "updated_at" => "2018-07-18 16:24:03"
                ]
            ]);


        $this->retriever
            ->shouldReceive('getAllOfficeHours')
            ->with('2185','nr_nerces.kazandjian@csun.edu')
            ->andReturn($officeHours);

       // $test = new FacultyController($this->retriever);


        $response = $this->retriever->getAllOfficeHours('2185','nr_nerces.kazandjian@csun.edu');
        dd($response);

        //$response = $this->retriever->getAllOfficeHours('2187','nr_nerces.kazandjian@csun.edu');
        $this->assertEquals($officeHours, $response);


    }

    /**
     * Go to faculty member's page
     * Reach ... terms/2187/faculty/steven.fitzgerald
     * @test
     */

    public function get_professor_myClassList()
    {
        $controller = new FacultyController($this->retriever);
        $this->retriever
            ->shouldReceive('getClassList')
            ->with('2187','steven.fitzgerald')
            ->andReturn(
                [
                    [
                        'classes_id' => '1234561',
                        'events' => [
                            'entities_id' => 'entity:id',
                            'term_id' => '2187'
                        ]
                    ],
                    [
                        'classes_id' => '1234561',
                        'events' => [
                            'entities_id' => 'entity:id',
                            'term_id' => '2187'
                        ]
                    ],
                    [
                        'classes_id' => '1234561',
                        'events' => [
                            'entities_id' => 'entity:id',
                            'term_id' => '2187'
                        ]
                    ]
                ]
            );

        $myClassList =
            [
                [
                    'classes_id' => '1234561',
                    'events' => [
                        'entities_id' => 'entity:id',
                        'term_id' => '2187'
                    ]
                ],
                [
                    'classes_id' => '1234561',
                    'events' => [
                        'entities_id' => 'entity:id',
                        'term_id' => '2187'
                    ]
                ],
                [
                    'classes_id' => '1234561',
                    'events' => [
                        'entities_id' => 'entity:id',
                        'term_id' => '2187'
                    ]
                ]
            ];

        $response = $controller->getClassList('2187','steven.fitzgerald');
        $this->assertEquals($myClassList, $response);


    }
    /**
     * Retrieve a teachers Final-Exam hours for term 2187
     * @test
     */
    public function get_professor_final_exam_times()
    {
        $controller = new FacultyController($this->retriever);
        $this->retriever
            ->shouldReceive('getFinalExamTimes')
            ->with('2187','steven.fitzgerald')
            ->andReturn(
                [
                    [
                        'classes_id' => '1234561',
                        'events' => [
                            'entities_id' => 'entity:id',
                            'term_id' => '2187'
                        ]
                    ],
                    [
                        'classes_id' => '1234561',
                        'events' => [
                            'entities_id' => 'entity:id',
                            'term_id' => '2187'
                        ]
                    ],
                    [
                        'classes_id' => '1234561',
                        'events' => [
                            'entities_id' => 'entity:id',
                            'term_id' => '2187'
                        ]
                    ]
                ]
            );

        $myClassList =
            [
                [
                    'classes_id' => '1234561',
                    'events' => [
                        'entities_id' => 'entity:id',
                        'term_id' => '2187'
                    ]
                ],
                [
                    'classes_id' => '1234561',
                    'events' => [
                        'entities_id' => 'entity:id',
                        'term_id' => '2187'
                    ]
                ],
                [
                    'classes_id' => '1234561',
                    'events' => [
                        'entities_id' => 'entity:id',
                        'term_id' => '2187'
                    ]
                ]
            ];


        $this->assertEquals($myClassList,
            [
                [
                    'classes_id' => '1234561',
                    'events' => [
                        'entities_id' => 'entity:id',
                        'term_id' => '2187'
                    ]
                ],
                [
                    'classes_id' => '1234561',
                    'events' => [
                        'entities_id' => 'entity:id',
                        'term_id' => '2187'
                    ]
                ],
                [
                    'classes_id' => '1234561',
                    'events' => [
                        'entities_id' => 'entity:id',
                        'term_id' => '2187'
                    ]
                ]
            ]);
    }

}

?>
