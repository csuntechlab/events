<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    //use DatabaseMigration
   /* public function testExample()
    {
        $this->get('/');

        $this->assertEquals(
            $this->app->version(), $this->response->getContent()
        );
    }
    //----------------------------------
    //you have to create the Gimme3 class
    protected $gimme3 = null;
    public function setup(){

        $this->gimme3 = new Gimme3;
    }

    public function can_get_3(){

        //$this->assertTrue(true);
        $val = $this->gimme3->give(); //you have to create the give() function in the Gimme class


        $this->assertEquals(3, $val); //so if you write'return 3' in give(), it is expecting
                                                //to get 3, so itll compare what the actual test got vs 3 and shows true/false

    }

    //--------------------------
    public function faculty_is_brought_up(){

        $this->call('faculty', [

                'professor' => 'schwartz' //match whats in the database
        ]);

        $this->assertResponseOk();

        $this->seeInDatabase('faculty', [

            'professor' => 'schwartz'

        ]);*/

   // }
}
