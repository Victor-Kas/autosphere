<?php

namespace Database\Seeders;

use App\Models\VehicleMake;
use App\Models\VehicleModel;
use Illuminate\Database\Seeder;

class VehicleCatalogueSeeder extends Seeder
{

    public function run(): void
    {
        $vehicles = [
            [
                'name' => 'Toyota',
                'slug' => 'toyota',
                'country' => 'Japan',
                'models' => [
                    'Hilux' => 'hilux',
                    'Corolla' => 'corolla',
                    'Land Cruiser' => 'land-cruiser',
                ],
            ],
            [
                'name' => 'BMW',
                'slug' => 'bmw',
                'country' => 'Germany',
                'models' => [
                    '3 Series' => '3-series',
                    '5 Series' => '5-series',
                ],
            ],
            [
                'name' => 'Audi',
                'slug' => 'audi',
                'country' => 'Germany',
                'models' => [
                    'A4' => 'a4',
                    'A6' => 'a6',
                ],
            ],

        ];
        
        foreach ($vehicles as $vehicle) {
            $make = VehicleMake::updateOrCreate(
                ['slug' => $vehicle['slug']],
                [
                    'name' => $vehicle['name'],
                    'country' => $vehicle['country'],
                ]
            );

            foreach ($vehicle['models'] as $name => $slug) {
                $make->vehicleModels()->updateOrCreate(
                    ['slug' => $slug],
                    ['name' => $name]
                );
            }
        }

        
        $generations = [
            [
                'make' => 'toyota',
                'model' => 'hilux',
                'name' => '7th Generation (AN10/AN20/AN30)',
                'start_year' => 2004,
                'end_year' => 2015,
                'engines' => [
                    ['name' => '2.5L D-4D', 'engine_code' => '2KD-FTV', 'fuel_type' => 'Diesel'],
                    ['name' => '3.0L D-4D', 'engine_code' => '1KD-FTV', 'fuel_type' => 'Diesel'],
                ],
            ],
            [
                'make' => 'toyota',
                'model' => 'hilux',
                'name' => '8th Generation (AN120/AN130)',
                'start_year' => 2015,
                'end_year' => null,
                'engines' => [
                    ['name' => '2.4L GD-6', 'engine_code' => '2GD-FTV', 'fuel_type' => 'Diesel'],
                    ['name' => '2.8L GD-6', 'engine_code' => '1GD-FTV', 'fuel_type' => 'Diesel'],
                ],
            ],
            [
                'make' => 'bmw',
                'model' => '3-series',
                'name' => 'F30',
                'start_year' => 2011,
                'end_year' => 2019,
                'engines' => [
                    ['name' => '320i 2.0L Turbo', 'engine_code' => 'N20', 'fuel_type' => 'Petrol'],
                ],
            ],
            [
                'make' => 'audi',
                'model' => 'a4',
                'name' => 'B9',
                'start_year' => 2015,
                'end_year' => 2024,
                'engines' => [
                    ['name' => '2.0L TFSI', 'engine_code' => 'EA888', 'fuel_type' => 'Petrol'],
                ],
            ],
        ];

        foreach ($generations as $data) {
            $model = VehicleModel::whereHas('vehicleMake', function ($query) use ($data) {
                $query->where('slug', $data['make']);
            })
            ->where('slug', $data['model'])
            ->firstOrFail();

            $generation = $model->generations()->updateOrCreate(
                ['name' => $data['name']],
                [
                    'start_year' => $data['start_year'],
                    'end_year' => $data['end_year'],
                ]
            );

            foreach ($data['engines'] as $engine) {
                $generation->engineVariants()->updateOrCreate(
                    [
                        'name' => $engine['name'],
                        'engine_code' => $engine['engine_code'],
                    ],
                    ['fuel_type' => $engine['fuel_type']]
                );
            }
        }

    }
}
