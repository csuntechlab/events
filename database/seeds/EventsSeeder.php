<?php

use Illuminate\Database\Seeder;

use App\Event;

class EventsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            for($i = 3; $i < 6; $i++){
                Event::create([
                    'entities_id' => 'classes:2187:1234'.$i,
                    'term_id' => '2187',
                    'meeting_number' => '9999',
                    'type' => 'class',
                    'label' => 'Class',
                    'description' => 'This is a description',
                    'start_time' => ($i+4).':00 am',
                    'end_time' => ($i+8).':00 am',
                    'days' => 'Mo_We',
                    'from_date' => '07-02-2018',
                    'to_date' => '09-02-2018',
                    'location_type' => 'physical',
                    'location' => 'JD2215',
                    'is_byappointment' => '0',
                    'is_walking' => '0',
                    'booking_url' => 'bookMyOfficeHours.com',
                    'online_label' => 'zoom',
                    'online_url' => 'https://csun.zoom.us/j/5024885325',
                ]);                
            }
        
    }
}

