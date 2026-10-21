<?php

namespace App\Http\Controllers;

use App\Models\CommonFault;
use App\Models\VehicleModel;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CommonFaultController extends Controller
{
    public function index(Request $request): View
    {
        $faults = CommonFault::with([
            'vehicleModel.vehicleMake',
            'engineVariant'
        ])
        ->when($request->filled('vehicle_model_id'), function ($query) use ($request) {
            $query->where(
                'vehicle_model_id',
                $request->integer('vehicle_model_id')
            );
        })
        ->latest()
        ->paginate(9)
        ->withQueryString();

        $vehicles = VehicleModel::with('vehicleMake')
            ->orderBy('name')
            ->get();

        return view('common-faults.index', compact('faults', 'vehicles'));
    }



    public function show(CommonFault $fault): View
    {
        $fault->load([
            'vehicleModel.vehicleMake',
            'engineVariant',

            'breakdowns' => function ($query) {
                $query->with('user')->latest();
            },
        ]);

        return view('common-faults.show', compact('fault'));
    }

}
