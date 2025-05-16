<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanySeeder extends Seeder
{
    public function run()
    {
        DB::table('companies')->insert([
[
        'name' => 'Hilton Hotels & Resorts',
        'type' => 'hotel',
    ],
[
        'name' => 'Marriott International',
        'type' => 'hotel',
    ],
[
        'name' => 'Hyatt Hotels Corporation',
        'type' => 'hotel',
    ],
[
        'name' => 'Toyota Motor Corporation',
        'type' => 'manufacturer',
    ],
[
        'name' => 'Ford Motor Company',
        'type' => 'manufacturer',
    ],
[
        'name' => 'Volkswagen Group',
        'type' => 'manufacturer',
    ],
[
        'name' => 'Hertz Global Holdings',
        'type' => 'rental',
    ],
[
        'name' => 'Enterprise Holdings',
        'type' => 'rental',
    ],
[
        'name' => 'Avis Budget Group',
        'type' => 'rental',
    ],
[
        'name' => 'Emirates',
        'type' => 'airline',
    ],
[
        'name' => 'Delta Air Lines',
        'type' => 'airline',
    ],
[
        'name' => 'Singapore Airlines',
        'type' => 'airline',
    ]
        ]);
    }
}
