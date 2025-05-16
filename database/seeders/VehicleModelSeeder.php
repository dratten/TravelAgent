<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VehicleModels;
use App\Models\Companies;

class VehicleModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $manufacturers = Companies::where('type', 'manufacturer')->get();

        if ($manufacturers->isEmpty()) {
            $this->command->warn('No companies found. Seed the companies table first.');
            return;
        }

        $vehicleModels = [
            'Corolla',
            'Civic',
            'Model S',
            'Mustang',
            'CX-5',
            'X5',
            'A4',
            'Camry',
            'Accord',
            'Rav4',
        ];

        foreach ($vehicleModels as $model) {
            VehicleModels::create([
                'name' => $model,
                'manufacturer_id' => $manufacturers->random()->id,
            ]);
        }
    }
}
