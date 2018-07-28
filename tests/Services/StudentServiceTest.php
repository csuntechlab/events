<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Services\StudentService;

class StudentServiceTest extends TestCase
{
    protected $term = '2153';
    protected $email = 'luis.guzman';
    protected $members_id = 'members:105434158';
    protected $class_id = 'classes:2153:15447';
    protected $studentService;

    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->studentService = new StudentService();
    }
    /**
     * this is an anotation
     *
     * @return void
     */

    /**
     * @test
     */
    public function gets_classes_table_from_studentService(){
        $this->assertNotNull($this->studentService->termClasses($this->term, $this->email));
    }

    /**
     * @test
     */
    public function get_a_user_by_email(){
         $this->assertNotNull($this->studentService->user($this->email));
    }

    /**
     * @test
     */
    public function get_classesID_by_userID_and_termID(){
        $this->assertNotNull($this->studentService->classesID($this->members_id, $this->term));
    }

    /**
     * @test
     */
    public function user_is_a_student_in_class(){
        $this->assertTrue($this->studentService->is_a_student($this->members_id, $this->class_id));
    }
}
