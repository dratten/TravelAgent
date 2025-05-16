<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AirportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('airports')->insert([
            [
                'name' => 'Jomo Kenyatta International Airport',
                'iata_code' => 'NBO',
                'city' => 'Nairobi',
                'country_id' => 1, // Make sure this matches a valid country ID
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Heathrow Airport',
                'iata_code' => 'LHR',
                'city' => 'London',
                'country_id' => 2, // Make sure this matches a valid country ID
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'John F. Kennedy International Airport',
                'iata_code' => 'JFK',
                'city' => 'New York',
                'country_id' => 3, // Make sure this matches a valid country ID
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
