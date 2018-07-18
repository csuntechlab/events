<?php

use Illuminate\Database\Seeder;
use App\Event;

class eventsSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
        Event::create([
            'entities_id' => '12340',
            'term_id' => '2187',
            'pattern_number' => '1',
            'type' => 'office-hours',
            'label' => 'General Office Hours',
            'description' => 'some kind of description',
            'start_time' => '8:00',
            'end_time' => '11:00',
            'days' => 'M',
            'from_date' => '2018-07-11 00:00:00',
            'to_date' => '2018-08-11 00:00:00',
            'location_type' => 'physical',
            'location' => 'jacaranda',
            'is_byappointment' => true,
            'is_walkin' => true,
            'booking_url' => 'booking#',
            'online_label' => 'online#',
            'online_url' => 'onlineAddr',
        ]);
        /**/

        /**/
        for($i = 3; $i < 6; $i++){
            Event::create([
                'entities_id' => 'classes:2187:1234'.$i,
                'term_id' => '2187',
                'pattern_number' => '9999',
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
                'is_walkin' => '0',
                'booking_url' => 'bookMyOfficeHours.com',
                'online_label' => 'zoom',
                'online_url' => 'https://csun.zoom.us/j/5024885325',
            ]);
        }
        /**/

        /*
        Event::create([
            'entities_id' => '12340',
            'term_id' => '2187',
            'location' => 'jacaranda',
            'days' => 'M',
        ]);

        Event::create([
            'entities_id' => '12340',
            'term_id' => '2187',
            'location' => 'jacaranda',
            'days' => 'W',
        ]);

        Event::create([
            'entities_id' => '12341',
            'term_id' => '2187',
            'location' => 'jacaranda',
            'days' => 'F',
        ]);

        Event::create([
            'entities_id' => '12342',
            'term_id' => '2187',
            'location' => 'jacaranda',
            'days' => 'S',
        ]);

        Event::create([
            'entities_id' => '12343',
            'term_id' => '2187',
            'location' => 'jacaranda',
            'days' => 'F',
        ]);

        Event::create([
            'entities_id' => '12344',
            'term_id' => '2187',
            'location' => 'jacaranda',
            'days' => 'T',
        ]);

        Event::create([
            'entities_id' => '12344',
            'term_id' => '2187',
            'location' => 'jacaranda',
            'days' => 'Th',
        ]);

        Event::create([
            'entities_id' => '12345',
            'term_id' => '2187',
            'location' => 'jacaranda',
            'days' => 'F',
        ]);
        /**/
    }
}
