<?php
use Illuminate\Database\Seeder;
use App\ClassMembership;

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
            ClassMembership::create([
                'classes_id' => '1234'.$i,
                'term_id' => '2187',
                'member_id' => 'member:23456',
                'role_position' => 'Student',
                'member_status' => 'Enrolled',
                'email' => 'student_1_@my.csun.edu'
            ]);
        }
        for ($i=0; $i < 6; $i++) {
            # code...
            ClassMembership::create([
                'classes_id' => '1234'.$i,
                'term_id' => '2187',
                'member_id' => 'member:23457',
                'role_position' => 'Student',
                'member_status' => 'Enrolled',
                'email' => 'student_2_@my.csun.edu'
            ]);
        }
        for ($i=0; $i < 6; $i++) {
            # code...
            ClassMembership::create([
                'classes_id' => '1234'.$i,
                'term_id' => '2187',
                'member_id' => 'member:23458',
                'role_position' => 'Student',
                'member_status' => 'Enrolled',
                'email' => 'student_3_@my.csun.edu'
            ]);
        }
        for ($i=0; $i < 2; $i++) {
            # code...
            ClassMembership::create([
                'classes_id' => '1234'.$i,
                'term_id' => '2187',
                'member_id' => 'member:23459',
                'role_position' => 'Instructor',
                'member_status' => 'Enrolled',
                'email' => 's.f@my.csun.edu'
            ]);
        }
        for ($i=3; $i < 6; $i++) {
            # code...
            ClassMembership::create([
                'classes_id' => '1234'.$i,
                'term_id' => '2187',
                'member_id' => 'member:234510',
                'role_position' => 'Instructor',
                'member_status' => 'Enrolled',
                'email' => 'LuisOG@my.csun.edu'
            ]);
        }
    }
}