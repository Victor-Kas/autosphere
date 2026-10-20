
@extends('layouts.main')

@section('title', 'Vehicle Catalogue | AutoSphere')

@section('content')

    <section class="max-w-7xl mx-auto px-6 py-12">

        <h1 class="text-4xl font-extrabold mb-3">
            Explore Vehicles
        </h1>

        <p class="text-slate-500 mb-10">
            Discover manufacturers, models, generations and engines.
        </p>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">

            @forelse ($makes as $make)
                <div class="bg-white rounded-xl shadow-sm
                            border border-slate-200 p-6">

                    <h2 class="text-2xl font-bold text-accent mb-1">
                        {{ $make->name }}
                    </h2>

                    <p class="text-sm text-slate-500 mb-5">
                        {{ $make->country }}
                    </p>

                    @foreach ($make->vehicleModels as $model)
                        <div class="border-t border-slate-100 py-4">

                            <h3 class="font-bold text-lg">
                                <a href="{{ route('vehicles.show', [
                                    'make' => $make->slug,
                                    'model' => $model->slug
                                ]) }}"
                                class="hover:text-accent transition">
                                    {{ $model->name }} &rarr;
                                </a>
                            </h3>

                            @foreach ($model->generations as $generation)
                                <div class="mt-3 pl-3 border-l-2 border-blue-200">

                                    <p class="text-sm font-semibold">
                                        {{ $generation->name }}
                                    </p>

                                    <p class="text-xs text-slate-500">
                                        {{ $generation->start_year }}
                                        -
                                        {{ $generation->end_year ?? 'Present' }}
                                    </p>

                                    @foreach ($generation->engineVariants as $engine)
                                        <p class="text-sm text-slate-600 mt-2">
                                            🔧 {{ $engine->name }}
                                            <span class="text-xs text-slate-400">
                                                ({{ $engine->engine_code }})
                                            </span>
                                        </p>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>

            @empty
                <p class="text-slate-500">
                    No vehicles found in our catalogue.
                </p>
            @endforelse

        </div>
    </section>

@endsection
