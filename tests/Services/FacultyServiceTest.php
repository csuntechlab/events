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

    public function
    

}
