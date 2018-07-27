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
    public function test_assertTrue()
    {
        $this->assertEquals(true, true);
    }
    
}

?>
