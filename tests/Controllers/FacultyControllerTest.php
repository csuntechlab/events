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
                  "classes_id" => "classes:2173:99998",
                  "term_id" => "2173",
                  "members_id" => "members:000420312",
                  "role_position" => "Instructor",
                  "events" => 
                    [
                      [
                        "entities_id" => "classes:2173:99998",
                        "term_id" => 2173,
                        "pattern_number" => 1,
                        "type" => "class",
                        "label" => "Class Time",
                        "description" => "Comp 122",
                        "start_time" => "1100h",
                        "end_time" => "1200h",
                        "days" => "MW",
                        "from_date" => "2017-02-02",
                        "to_date" => "2017-06-01",
                        "location_type" => "NULL",
                        "location" => "NULL",
                        "is_byappointment" => 0,
                        "is_walkin" => 0,
                        "booking_url" => "NULL",
                        "online_label" => "NULL",
                        "online_url" => "NULL",
                        "created_at" => "2017-05-01 14:32:56",
                        "updated_at" => "2017-05-01 14:32:56"
                      ]
                    ]
                ]
            ]
        );

        $this->retriever
        ->shouldReceive('getClassList')
        ->with('2173','nr_nerces.kazandjian')
        ->andReturn($myClassList);

        //need to create controller after mocking param, wont know what to mock?
        $workingController = new FacultyController($this->retriever);
        // dd($workingController);
        
        $response = $workingController->getClassList('2173','nr_nerces.kazandjian');
        
        // dd($response);
        
        $this->assertEquals($myClassList, $response);       
        
    }

   /**
    * Retrieve a teachers Final-Exam hours for term 2187
    * @test
    */
    public function get_professor_final_exam_times()
    {
        $myClassList = json_encode(
            [   
                [
                  "classes_id" => "classes:2173:99998",
                  "term_id" => "2173",
                  "members_id" => "members:000420312",
                  "role_position" => "Instructor",
                  "events" => 
                    [
                      [
                        "entities_id" => "classes:2173:99998",
                        "term_id" => 2173,
                        "pattern_number" => 1,
                        "type" => "final-exam",
                        "label" => "final Exam Time",
                        "description" => "Comp 122",
                        "start_time" => "1100h",
                        "end_time" => "1200h",
                        "days" => "MW",
                        "from_date" => "2017-02-02",
                        "to_date" => "2017-06-01",
                        "location_type" => "NULL",
                        "location" => "NULL",
                        "is_byappointment" => 0,
                        "is_walkin" => 0,
                        "booking_url" => "NULL",
                        "online_label" => "NULL",
                        "online_url" => "NULL",
                        "created_at" => "2017-05-01 14:32:56",
                        "updated_at" => "2017-05-01 14:32:56"
                      ]
                    ]
                ]
            ]
        );

        $this->retriever
        ->shouldReceive('getFinalExamTimes')
        ->with('2187','steven.fitzgerald')
        ->andReturn($myClassList);

        $workingController = new FacultyController($this->retriever);
        
        $response = $workingController->getFinalExamTimes('2187','steven.fitzgerald');

        $this->assertEquals($myClassList,$response);

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
            ]
        );

        $this->retriever
        ->shouldReceive('getClassList')
        ->with('2173','nr_nerces.kazandjian')
        ->andReturn($officeHours);

        $workingController = new FacultyController($this->retriever);
        $response = $workingController->getClassList('2173','nr_nerces.kazandjian');
        
        $this->assertEquals($officeHours, $response);     
    }
   
   /**
    * Retrieve Instructor info:
    *   professor classes   
    *   final exam times
    *   professor office hours
    * @test
    */
   public function get_Instructor_Info()
   {
       $ical = new ICal(); 
       $ical->addEvent();  
       $ical->addEvent();  
    //    return $ical->generateICS();   

       $instructorInfo = json_encode(
        [
           "classList" =>    NULL,
           "finalExamTimes" =>     NULL,
           "officeHours" =>    NULL
        ]);
        // dd($instructorInfo);

       $this->retriever->shouldReceive('getInstructorInfo')
        ->with('2173','nr_nerces.kazandjian')
        ->andReturn($instructorInfo);

        $workingController = new FacultyController($this->retriever);
        
        $response = $workingController->getInstructorInfo('2173','nr_nerces.kazandjian');
        dd($response);

        $this->assertEquals($instructorInfo, $response);

   }

   /**
    * Create an ics with events
    * @test
    */
   public function make_An_Ics_File()
   {

    $instructorInfo = json_encode(
        [
           "classList" =>    NULL,
           "finalExamTimes" =>     NULL,
           "officeHours" =>    NULL
        ]);

       $this->retriever->shouldReceive('getInstructorInfo')
        ->with('2173','nr_nerces.kazandjian')
        ->andReturn($instructorInfo);

        $workingController = new FacultyController($this->retriever);
        
        $response = $workingController->getInstructorInfo('2173','nr_nerces.kazandjian');
        dd($response);

        $this->assertEquals($instructorInfo, $response);
   }
    
}

?>
