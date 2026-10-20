<?php

namespace App\Http\Controllers;

use App\Models\Breakdown;
use App\Models\VehicleModel;
// use App\Models\EngineVariant;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class BreakdownController extends Controller
{
    public function create(): View
    {
        $vehicles = VehicleModel::with([
            'vehicleMake',
            'generations.engineVariants'
        ])->orderBy('name')->get();

        return view('breakdowns.create', compact('vehicles'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'vehicle_model_id' => [
                'required',
                'exists:vehicle_models,id',
            ],
            'engine_variant_id' => [
                'nullable',
                Rule::exists('engine_variants', 'id')
                    ->whereIn(
                        'vehicle_generation_id',
                        \App\Models\VehicleGeneration::where(
                            'vehicle_model_id',
                            $request->input('vehicle_model_id')
                        )->select('id')
                    ),
            ],
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:20',
            'mileage' => 'nullable|integer|min:0',
        ]);


        $breakdown = $request->user()->breakdowns()->create(
            array_merge($validated, ['status' => 'open'])
        );

        return redirect()
            ->route('breakdowns.show', $breakdown)
            ->with('success', 'Your breakdown has been posted!');

    }

    public function index(): View
    {
        $breakdowns = Breakdown::with([
            'user',
            'vehicleModel.vehicleMake',
            'engineVariant'
        ])
        ->latest()
        ->paginate(9);

        return view('breakdowns.index', compact('breakdowns'));
    }    

    public function show(Breakdown $breakdown): View
    {
        $breakdown->load([
            'user',
            'vehicleModel.vehicleMake',
            'engineVariant',
            'solutions.user',
        ]);

        return view('breakdowns.show', compact('breakdown'));
    }

}
