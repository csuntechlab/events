<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
<<<<<<< HEAD
        $this->call('classMembershipsSeeder');
=======
        // $this->call('UsersTableSeeder');
        $this->call('classMembershipsSeeder');
        $this->call('eventsSeeder');
>>>>>>> origin/ET-56
    }
}
