<?php
declare(strict_types=1);

namespace Tests\Services;
use App\Contracts\FacultyContract;
use App\Services\FacultyService;
use Mockery;
use TestCase;

class FacultyServiceTest extends TestCase
{



    public function returns_all_office_hours_of_given_professor(){

        $response = $this->call('GET', '1.0/terms/2187/faculty/steven.fitzgerald');
        $this->assertEquals(200, $response->status());


    }

}

?>
