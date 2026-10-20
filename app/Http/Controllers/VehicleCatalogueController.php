<?php

namespace App\Http\Controllers;

use App\Models\VehicleMake;
use App\Models\VehicleModel;
use Illuminate\View\View;

class VehicleCatalogueController extends Controller
{
    public function index(): View
    {

        $makes = VehicleMake::with(['vehicleModels.generations.engineVariants'])->orderBy('name')->get();

        return view('vehicles.index', compact('makes'));
    }


    public function show(string $make, string $model): View
    {
        $vehicle = VehicleModel::with([
            'vehicleMake',
            'generations.engineVariants'
        ])
        ->where('slug', $model)
        ->whereHas('vehicleMake', function ($query) use ($make) {
            $query->where('slug', $make);
        })
        ->firstOrFail();

        return view('vehicles.show', compact('vehicle'));
    }

}
