
@extends('layouts.main')

@section('title', $vehicle->vehicleMake->name . ' ' . $vehicle->name . ' | AutoSphere')

@section('content')

<section class="max-w-7xl mx-auto px-6 py-12">

    <a href="{{ route('vehicles.index') }}"
       class="text-accent text-sm font-semibold">
        &larr; Back to Vehicle Catalogue
    </a>

    <div class="mt-8 mb-12">
        <p class="text-accent font-semibold uppercase tracking-widest">
            {{ $vehicle->vehicleMake->name }}
        </p>

        <h1 class="text-5xl font-extrabold mt-2">
            {{ $vehicle->name }}
        </h1>

        <p class="text-slate-500 mt-4">
            Explore generations, engine configurations,
            reviews and community repair knowledge.
        </p>
    </div>

    <h2 class="text-2xl font-bold mb-6">
        Generations & Engines
    </h2>

    <div class="grid md:grid-cols-2 gap-6">

        @forelse ($vehicle->generations as $generation)

            <div class="bg-white rounded-xl border
                        border-slate-200 shadow-sm p-6">

                <h3 class="text-xl font-bold">
                    {{ $generation->name }}
                </h3>

                <p class="text-slate-500 text-sm mt-2">
                    {{ $generation->start_year }}
                    -
                    {{ $generation->end_year ?? 'Present' }}
                </p>

                <div class="border-t mt-5 pt-5">

                    <h4 class="font-semibold mb-3">
                        Engine Options
                    </h4>

                    @forelse ($generation->engineVariants as $engine)
                        <div class="bg-surface rounded-lg p-4 mb-3">
                            <p class="font-semibold">
                                {{ $engine->name }}
                            </p>

                            <p class="text-sm text-slate-500">
                                {{ $engine->engine_code }}
                                &bull; {{ $engine->fuel_type }}
                            </p>
                        </div>
                    @empty
                        <p class="text-sm text-slate-500">
                            Engine information coming soon.
                        </p>
                    @endforelse

                </div>
            </div>

        @empty
            <p class="text-slate-500">
                Generation information coming soon.
            </p>
        @endforelse

    </div>

    <div class="grid md:grid-cols-3 gap-6 mt-12">

        @foreach ([
            ['title' => 'Owner Reviews', 'icon' => '⭐'],
            ['title' => 'Breakdown Help', 'icon' => '🔧'],
            ['title' => 'Spare Parts', 'icon' => '⚙️']
        ] as $feature)

            <div class="bg-white rounded-xl border
                        border-slate-200 p-6">

                <div class="text-3xl mb-4">
                    {{ $feature['icon'] }}
                </div>

                <h3 class="font-bold text-lg">
                    {{ $feature['title'] }}
                </h3>

                <p class="text-slate-500 text-sm mt-2">
                    Coming soon to AutoSphere.
                </p>
            </div>

        @endforeach

    </div>

    <!-- Vehicle Knowledge Base -->
    <div class="bg-primary text-white rounded-xl
                p-8 mt-12 flex flex-wrap justify-between
                items-center gap-6">

        <div>
            <h2 class="text-2xl font-bold mb-2">
                Common Faults & Repairs
            </h2>

            <p class="text-slate-300">
                Explore documented mechanical problems
                associated with this vehicle.
            </p>
        </div>

        <a href="{{ route('common-faults.index', [
            'vehicle_model_id' => $vehicle->id
        ]) }}"
        class="bg-accent hover:bg-blue-700
                px-6 py-3 rounded-lg font-semibold">
            Explore Common Faults &rarr;
        </a>

    </div>

</section>

@endsection
