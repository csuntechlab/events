<?php
declare(strict_types=1);
namespace Tests\Controllers;
use Mockery;
use TestCase;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use \App\Contracts\FacultyContract;
use \App\Http\Controllers\FacultyController;
use App\ICal;
class FacultyControllerTest extends TestCase
{ 

  /**
   * https://api.metalab.csun.edu/events/1.0/terms/2187/
   * 
   * terms/2187 === 2018 7th session aka Fall
   * 
   * /faculty/steven.fitzgerald
   * steven.fitzgerald == steven.fitzgerald@csun.edu
   * 
   * 1. Reach ... terms/2187/faculty/steven.fitzgerald
   * 2. Retrieve a teachers class hours for term 2187
   * 3. Retrieve a teachers Final-Exam hours for term 2187
   * 4. Retrieve a teachers office hours for term 2187
   * 
   */

   protected $retriever; 

   public function setUp()
    {
        parent::setUp();
        $this->retriever = Mockery::spy(FacultyContract::class);
    }
   
   /**
    * Go to faculty member's page
    * Reach ... terms/2187/faculty/steven.fitzgerald
    * @test
    */
   public function go_to_faculty_member_page()
   {
       $response = $this->call('GET', '1.0/terms/2187/faculty/steven.fitzgerald');
       $this->assertEquals(200, $response->status());
   }

   /**
    * Get a my Classes table for professors
    * @test
    */
    public function get_professor_myClassList()
    {
        $myClassList = json_encode(
            [
                [
                    "classes_id" => "classes:2173:99992",
                    "term_id" => "2173",
                    "course" => 
                        [
                            "classes_id" => "classes:2173:99992",
                            "term_id" => 2173,
                            "class_number" => "99992",
                            "subject" => "COMP",
                            "catalog_number" => "992",
                            "description" => null
                        ],
                    "events" => 
                    [
                        [
                            "entities_id" => "classes:2173:99992",
                            "term_id" => 2173,
                            "pattern_number" => 1,
                            "type" => "class",
                            "label" => "Class Meeting Time",
                            "start_time" => "0900h",
                            "end_time" => "0945h",
                            "days" => "MW",
                            "from_date" => null,
                            "to_date" => null,
                            "location_type" => "physical",
                            "location" => "ED1100",
                            "is_byappointment" => 0,
                            "is_walkin" => 1,
                            "booking_url" => null,
                            "online_label" => null,
                            "online_url" => null
                        ]
                    ]
                ]
            ]
        );

        $this->retriever
        ->shouldReceive('getClassList')
        ->with('2173','nerces.kazandjian')
        ->andReturn($myClassList);

        //need to create controller after mocking param, wont know what to mock?
        $workingController = new FacultyController($this->retriever);
        
        $response = $workingController->getClassList('2173','nerces.kazandjian');
        
        $this->assertEquals($myClassList, $response);       
        
    }

   /**
    * Retrieve a teachers office hours for term 2187
    * @test
    */
    public function get_professor_office_hours()
    {
        $officeHours = json_encode( 
            [
                [
                    "entities_id" => "office-hours:2173:000420312",
                    "term_id" => 2173,
                    "pattern_number" => 1,
                    "type" => "office-hours",
                    "label" => "General Office Hours",
                    "start_time" => null,
                    "end_time" => null,
                    "days" => null,
                    "from_date" => null,
                    "to_date" => null,
                    "location_type" => "physical",
                    "location" => null,
                    "is_byappointment" => 1,
                    "is_walkin" => 0,
                    "booking_url" => null,
                    "online_label" => null,
                    "online_url" => null,
                    "course" => null
                ]
            ]
        );

        $this->retriever
        ->shouldReceive('getClassList')
        ->with('2173','nerces.kazandjian')
        ->andReturn($officeHours);

        $workingController = new FacultyController($this->retriever);
        $response = $workingController->getClassList('2173','nerces.kazandjian');
        
        $this->assertEquals($officeHours, $response);     
    }
   
   /**
    * Retrieve Instructor info:
    *   professor classes   
    *   final exam times
    *   professor office hours
    * @ test
    */
   public function get_Instructor_Info()
   {

       $instructorInfo =
        [
           "classList" =>  
                [
                    [
                        "classes_id" => "classes:2173:99992",
                        "term_id" => "2173",
                        "course" => 
                            [
                                "classes_id" => "classes:2173:99992",
                                "term_id" => 2173,
                                "class_number" => "99992",
                                "subject" => "COMP",
                                "catalog_number" => "992",
                                "description" => null
                            ],
                        "events" => 
                        [
                            [
                                "entities_id" => "classes:2173:99992",
                                "term_id" => 2173,
                                "pattern_number" => 1,
                                "type" => "class",
                                "label" => "Class Meeting Time",
                                "start_time" => "0900h",
                                "end_time" => "0945h",
                                "days" => "MW",
                                "from_date" => null,
                                "to_date" => null,
                                "location_type" => "physical",
                                "location" => "ED1100",
                                "is_byappointment" => 0,
                                "is_walkin" => 1,
                                "booking_url" => null,
                                "online_label" => null,
                                "online_url" => null
                            ]
                        ]
                    ]
                ],
           "officeHours" =>    
                    [
                        [
                            "entities_id" => "office-hours:2173:000420312",
                            "term_id" => 2173,
                            "pattern_number" => 1,
                            "type" => "office-hours",
                            "label" => "General Office Hours",
                            "start_time" => null,
                            "end_time" => null,
                            "days" => null,
                            "from_date" => null,
                            "to_date" => null,
                            "location_type" => "physical",
                            "location" => null,
                            "is_byappointment" => 1,
                            "is_walkin" => 0,
                            "booking_url" => null,
                            "online_label" => null,
                            "online_url" => null,
                            "course" => null
                        ]
                    ]
        ];

        // var_dump($instructorInfo);

       $this->retriever->shouldReceive('getInstructorInfo')
        ->with('2173','nerces.kazandjian')
        ->andReturn($instructorInfo);

        $workingController = new FacultyController($this->retriever);
        
        $response = $workingController->getInstructorInfo('2173','nerces.kazandjian');
        // dd($response);

        $this->assertEquals($instructorInfo, $response) ;

   }

   /**
    * Create an ics with events
    * @ test
    */
   public function make_An_Ics_File()
   {

    $instructorInfo = json_encode(
        [
           "classList" =>    NULL,
           "officeHours" =>    NULL
        ]);

       $this->retriever->shouldReceive('getInstructorInfo')
        ->with('2173','nerces.kazandjian')
        ->andReturn($instructorInfo);

        $workingController = new FacultyController($this->retriever);
        
        $response = $workingController->getInstructorInfo('2173','nerces.kazandjian');
        // dd($response);

        $this->assertEquals($instructorInfo, $response);
   }
}

?>
