<?php
declare(strict_types=1);

namespace Tests\Services;
use App\Contracts\FacultyContract;
use App\Services\FacultyService;
use Mockery;
use TestCase;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
class FacultyServiceTest extends TestCase
{
    protected $retriever;

    public function setUp()
    {
        parent::setUp();
        $this->retriever = Mockery::spy(FacultyContract::class);
    }

    /**
     * Retrieve faculty member's classes and corresponding final exam hours for a given term
     * @test
     */
    public function test_get_class_and_final_exam_hours() {
        $facultyService = new FacultyService($this->retriever);

        $classesAndFinalsList = json_encode([
            [
                "entities_id" => "classes:2173:99992",
                "term_id" => 2173,
                "pattern_number" => 1,
                "type" => "class",
                "label" => "Class Meeting Time",
                "description" => null,
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
                "online_url" => null,
                "created_at" => "2017-05-01 21:32:56",
                "updated_at" => null,
                "course" => [
                    "session_code" => null,
                    "term" => "Spring-2017",
                    "class_number" => "99992",
                    "course_id" => 999992,
                    "subject" => "COMP",
                    "catalog_number" => "992",
                    "title" => "META DEVELOPMENT C",
                    "description" => null,
                    "units" => null,
                    "section_number" => "02",
                    "class_status" => "Open",
                    "class_type" => null,
                    "enrollment_cap" => null,
                    "enrollment_total" => null,
                    "waitlist_cap" => null,
                    "waitlist_total" => null
                ]
            ],
            [
                "entities_id" => "classes:2173:99993",
                "term_id" => 2173,
                "pattern_number" => 1,
                "type" => "class",
                "label" => "Class Meeting Time",
                "description" => null,
                "start_time" => "1100h",
                "end_time" => "1200h",
                "days" => "MW",
                "from_date" => null,
                "to_date" => null,
                "location_type" => "physical",
                "location" => "BP3100",
                "is_byappointment" => 0,
                "is_walkin" => 1,
                "booking_url" => null,
                "online_label" => null,
                "online_url" => null,
                "created_at" => "2017-05-01 21:32:56",
                "updated_at" => null,
                "course" => [
                    "session_code" => null,
                    "term" => "Spring-2017",
                    "class_number" => "99993",
                    "course_id" => 999993,
                    "subject" => "COMP",
                    "catalog_number" => "993",
                    "title" => "META DEVELOPMENT D",
                    "description" => null,
                    "units" => null,
                    "section_number" => "03",
                    "class_status" => "Open",
                    "class_type" => null,
                    "enrollment_cap" => null,
                    "enrollment_total" => null,
                    "waitlist_cap" => null,
                    "waitlist_total" => null
                ]
            ]
        ]);

        $this->retriever
            ->shouldReceive('getClassAndFinalExamTimes')
            ->with('2173','nerces.kazandjian')
            ->andReturn($classesAndFinalsList);
        
        $response = $facultyService->getClassAndFinalExamTimes('2173', 'nerces.kazandjian');

        $this->assertEquals($response, $classesAndFinalsList);

    }

}
