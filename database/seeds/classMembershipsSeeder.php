<?php

use Illuminate\Database\Seeder;

use App\ClassMemberships;

class classMembershipsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < 6; $i++) { 
        	# code...
    		ClassMemberships::create([
    			'classes_id' => '1234'.$i,
    			'term_id' => '2187',
    			'member_id' => 'member:23456',
    			'role_position' => 'Student',
    			'member_status' => 'Enrolled',
    			'email' => 'student_1_@email.com'
    		]);
				}

				for ($i=0; $i < 6; $i++) { 
        	# code...
    		ClassMemberships::create([
    			'classes_id' => '1234'.$i,
    			'term_id' => '2187',
    			'member_id' => 'member:23457',
    			'role_position' => 'Student',
    			'member_status' => 'Enrolled',
    			'email' => 'student_2_@email.com'
    		]);
				}

				for ($i=0; $i < 6; $i++) { 
        	# code...
    		ClassMemberships::create([
    			'classes_id' => '1234'.$i,
    			'term_id' => '2187',
    			'member_id' => 'member:23458',
    			'role_position' => 'Student',
    			'member_status' => 'Enrolled',
    			'email' => 'student_3_@email.com'
    		]);
				}
				for ($i=0; $i < 2; $i++) { 
        	# code...
    		ClassMemberships::create([
    			'classes_id' => '1234'.$i,
    			'term_id' => '2187',
    			'member_id' => 'member:23459',
    			'role_position' => 'Instructor',
    			'member_status' => 'Enrolled',
    			'email' => 's.f@csun.edu'
    		]);
				}

				for ($i=3; $i < 6; $i++) { 
        	# code...
    		ClassMemberships::create([
    			'classes_id' => '1234'.$i,
    			'term_id' => '2187',
    			'member_id' => 'member:234510',
    			'role_position' => 'Instructor',
    			'member_status' => 'Enrolled',
    			'email' => 'LuisOG@csun.edu'
    		]);
        }
    }
}
