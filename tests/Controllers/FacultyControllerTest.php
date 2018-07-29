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
    public $retriever;

    public function setUp()
    {
        parent::setUp();
        $this->retriever = Mockery::spy(FacultyContract::class);
    }

    /**
     * Retrieve faculty member's classes and corresponding final exam hours for a given term
     * @test getClassAndFinalExamHours function in FacultyController
     */
    public function test_get_class_and_final_exam_times(){
        $controller = new FacultyController($this->retriever);

        $this->retriever
            ->shouldReceive('getClassAndFinalExamTimes')
            ->once();
        
        $controller->getClassAndFinalExamTimes('2173','nerces.kazandjian');
    } 
}

?>
