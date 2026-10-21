<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CommonFault;
use App\Models\VehicleModel;
use App\Models\EngineVariant;

class CommonFaultSeeder extends Seeder
{
    public function run(): void
    {
        $faults = [
            [
                'make' => 'toyota',
                'model' => 'hilux',
                'engine_code' => '2KD-FTV',
                'title' => 'Difficulty Starting Engine',
                'symptoms' => 'Extended cranking, intermittent starting, or failure to start.',
                'possible_causes' => 'Battery condition, starter circuit problems, fuel delivery restrictions or air entering the fuel system.',
                'recommended_repair' => 'Perform systematic battery, starter and fuel-system diagnostics before replacing components.',
            ],
            [
                'make' => 'toyota',
                'model' => 'hilux',
                'engine_code' => '1KD-FTV',
                'title' => 'Engine Overheating',
                'symptoms' => 'Elevated coolant temperature, coolant loss or overheating under load.',
                'possible_causes' => 'Cooling system leaks, restricted radiator airflow, thermostat faults or water pump problems.',
                'recommended_repair' => 'Inspect the cooling system, pressure-test for leaks and identify the underlying fault.',
            ],
            [
                'make' => 'bmw',
                'model' => '3-series',
                'engine_code' => 'N20',
                'title' => 'Timing Chain Noise',
                'symptoms' => 'Unusual rattling or whining noises from the engine, particularly during startup.',
                'possible_causes' => 'Timing chain, tensioner or guide wear.',
                'recommended_repair' => 'Have the timing system inspected by a qualified technician before continued operation.',
            ],
            [
                'make' => 'audi',
                'model' => 'a4',
                'engine_code' => 'EA888',
                'title' => 'Excessive Engine Oil Consumption',
                'symptoms' => 'Frequent engine oil top-ups or unexpectedly falling oil levels.',
                'possible_causes' => 'External leaks, crankcase ventilation faults or internal engine wear.',
                'recommended_repair' => 'Perform an oil consumption assessment and inspect for leaks before identifying the appropriate repair.',
            ],
        ];

        foreach ($faults as $fault) {
            $vehicle = VehicleModel::where('slug', $fault['model'])
                ->whereHas('vehicleMake', function ($query) use ($fault) {
                    $query->where('slug', $fault['make']);
                })
                ->firstOrFail();

            $engine = EngineVariant::where('engine_code', $fault['engine_code'])
                ->whereHas('vehicleGeneration', function ($query) use ($vehicle) {
                    $query->where('vehicle_model_id', $vehicle->id);
                })
                ->firstOrFail();

            CommonFault::updateOrCreate(
                [
                    'vehicle_model_id' => $vehicle->id,
                    'engine_variant_id' => $engine->id,
                    'title' => $fault['title'],
                ],
                [
                    'symptoms' => $fault['symptoms'],
                    'possible_causes' => $fault['possible_causes'],
                    'recommended_repair' => $fault['recommended_repair'],
                    'verification_status' => 'unverified',
                ]
            );
        }
    }
}
