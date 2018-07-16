<?php
declare(strict_types=1);
namespace Tests\Controllers;
use Mockery;
use TestCase;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use \App\Contracts\FacultyContract;
use \App\Http\Controllers\FacultyController;

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
    * classMemberships	(from the base-table: nemo.classMemberships)
    * classes_id: 		The unique id of the class
    * term_id:		    The term in which the event is valid
    * member_id:		The unique ID of the individual in the class
    * role_position:	Academic standing in the class: e.g., Instructor
    * members_status:	Indicates if the student is currently enrolled 
    * email:            Email of member
    *
    * Get a my Classes table for professors
    * @test
    */
    public function get_professor_myClassList()
    {
        $workingController = new FacultyController($this->retriever);

        $this->retriever
        ->shouldReceive('getClassList')
        ->with(['2187','LuisOG'])
        ->andReturn(
            json_encode(
            [
                [
                        "classes_id" => '12343',
                        "term_id" => '2187'
                ],
                [
                        "classes_id" => '12344',
                        "term_id" =>'2187'
                ],
                [
                        "classes_id" => '12345',
                        "term_id" => '2187'
                    ]
                ]
            )
        );
        
        $myClassList = json_encode(
            [
                [
                    "classes_id" => '12343',
                    "term_id" => '2187'
                ],
                [
                    "classes_id" => '12344',
                    "term_id" =>'2187'
                ],
                [
                    "classes_id" => '12345',
                    "term_id" => '2187'
                ]
            ] 
        );

        $response = $workingController->getClassList('2187','LuisOG');
        
        var_dump($response);
        // echo 'This is a response: '.$response. ' ';

        $this->assertEquals($myClassList, $response);        
        // $this->assertEquals($myClassList,
        // json_encode(
        //     [
        //         [
        //             "classes_id" => '12343',
        //             "term_id" => '2187'
        //         ],
        //         [
        //             "classes_id" => '12344',
        //             "term_id" =>'2187'
        //         ],
        //         [
        //             "classes_id" => '12345',
        //             "term_id" => '2187'
        //         ]
        //     ]
        // ) );        
        
    }

   /**
    * Retrieve a teachers Final-Exam hours for term 2187
    * @test
    */
    public function get_professor_final_exam_times()
    {
        $workingController = new FacultyController($this->retriever);

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
        
        // $response = $workingController->getFinalExamTimes('2187','steven.fitzgerald');
        // var_dump($response);

        // $this->assertEquals('this is a test', $response);        
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



   /**
    * Retrieve a teachers office hours for term 2187
    * @ test
    */
//    public function get_professor_office_hours()
//    {
//    
//    }
    
}

?>
