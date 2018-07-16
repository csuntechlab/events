<?php
/**
 * Created by PhpStorm.
 * User: Carlos Benavides
 * Date: 7/15/2018
 * Time: 1:37 PM
 */
namespace Tests\Controllers;
use App\Contracts\ClassContract;
use App\Http\Controllers\ClassController;
use App\Services\ClassService;
use Mockery;

class ClassControllerTest extends \TestCase
{
    protected $retriever;
    protected $controller;
    public function setUp()
    {
        parent::setUp();
        $this->retriever = Mockery::spy(ClassContract::class);
        $this->controller = new ClassController($this->retriever);
    }

    /**
     * @test
     */
    public function test_the_url_with_a_given_course_id_return_args()
    {
        $this->retriever
            ->shouldReceive('courses')
            ->withArgs([2187,16258])
            ->andReturn([2187,16258]);

        $result = [2187, 16258];
        $output = $this->retriever->courses(2187,16258);
        $this->assertEquals($result,$output);
    }

}