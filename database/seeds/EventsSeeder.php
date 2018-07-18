<?php

use Illuminate\Database\Seeder;

use App\Event;

class EventsSeeder extends Seeder
{
    protected $table = 'bedrock.events';
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // for($i = 3; $i < 6; $i++){
            Event::create([
                'entities_id' => 'classes:2173:99998',
                'term_id' => '2173',
                'pattern_number' => '1',
                'type' => 'class',
                'label' => 'Class Time',
                'description' => 'Comp 122',
                'start_time' => '1100h',
                'end_time' => '1200h',
                'days' => 'MW',
                'from_date' => '2017-02-02 14:32:56',
                'to_date' => '2017-06-01 14:32:56',
                'location_type' => 'NULL',
                'location' => 'NULL',
                'is_byappointment' => 'NULL',
                'is_walkin' => 'NULL',
                'booking_url' => 'NULL',
                'online_label' => 'NULL',
                'online_url' => 'NULL',
                'created_at' => '2017-05-01 14:32:56',
                'updated_at' => '2017-05-01 14:32:56',
            ]);
    }
}

