<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    public function run()
    {
        DB::table('countries')->insert([
[
        'name' => 'Kenya',
        'iso_code' => 'KEN',
        'continent' => 'Africa',
    ],
[
        'name' => 'United States',
        'iso_code' => 'USA',
        'continent' => 'North America',
    ],
[
        'name' => 'Germany',
        'iso_code' => 'DEU',
        'continent' => 'Europe',
    ],
[
        'name' => 'India',
        'iso_code' => 'IND',
        'continent' => 'Asia',
    ],
[
        'name' => 'Australia',
        'iso_code' => 'AUS',
        'continent' => 'Oceania',
    ],
[
        'name' => 'Brazil',
        'iso_code' => 'BRA',
        'continent' => 'South America',
    ],
[
        'name' => 'South Africa',
        'iso_code' => 'ZAF',
        'continent' => 'Africa',
    ],
[
        'name' => 'Canada',
        'iso_code' => 'CAN',
        'continent' => 'North America',
    ],
[
        'name' => 'Japan',
        'iso_code' => 'JPN',
        'continent' => 'Asia',
    ],
[
        'name' => 'United Kingdom',
        'iso_code' => 'GBR',
        'continent' => 'Europe',
    ]
        ]);
    }
}
