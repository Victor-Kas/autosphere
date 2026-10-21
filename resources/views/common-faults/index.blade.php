@extends('layouts.main')

@section('title', 'Common Vehicle Faults | Autosphere')


@section('content')


<section class="max-w-7xl mx-auto px-6 py-12">

    <!-- Page Header -->
    <div class="mb-10">
        <h1 class="text-4xl font-extrabold mb-3">
            Common Vehicle Faults
        </h1>

        <p class="text-slate-500">
            Explore common mechanical problems, symptoms,
            possible causes and repair information.
        </p>
    </div>

    <!-- Vehicle Filter -->
    <form method="GET"
          action="{{ route('common-faults.index') }}"
          class="bg-white rounded-xl border border-slate-200
                 p-6 mb-10 flex flex-wrap items-end gap-4">

        <div class="flex-1 min-w-[220px]">
            <label for="vehicle_model_id"
                   class="block font-semibold mb-2">
                Filter by Vehicle
            </label>

            <select name="vehicle_model_id"
                    id="vehicle_model_id"
                    class="w-full rounded-lg border-slate-300">

                <option value="">All Vehicles</option>

                @foreach ($vehicles as $vehicle)
                    <option value="{{ $vehicle->id }}"
                        @selected(request('vehicle_model_id') == $vehicle->id)>
                        {{ $vehicle->vehicleMake->name }}
                        {{ $vehicle->name }}
                    </option>
                @endforeach

            </select>
        </div>

        <button type="submit"
                class="bg-accent hover:bg-blue-700
                       text-white font-semibold
                       px-6 py-3 rounded-lg">
            Apply Filter
        </button>

        <a href="{{ route('common-faults.index') }}"
           class="text-slate-500 px-4 py-3">
            Clear
        </a>
    </form>    

    <!-- Fault Cards -->
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">

        @forelse ($faults as $fault)

            <article class="bg-white rounded-xl border
                            border-slate-200 shadow-sm p-6">

                <p class="text-accent font-semibold text-sm">
                    {{ $fault->vehicleModel->vehicleMake->name }}
                    {{ $fault->vehicleModel->name }}
                </p>

                <h2 class="text-xl font-bold mt-3 mb-4">
                    <a href="{{ route('common-faults.show', $fault) }}"
                    class="hover:text-accent transition">
                        {{ $fault->title }} &rarr;
                    </a>
                </h2>

                @if ($fault->engineVariant)
                    <p class="text-sm text-slate-500 mb-5">
                        Engine:
                        {{ $fault->engineVariant->name }}
                        ({{ $fault->engineVariant->engine_code }})
                    </p>
                @endif

                <div class="space-y-5 text-sm">

                    <div>
                        <h3 class="font-bold mb-1">
                            Symptoms
                        </h3>
                        <p class="text-slate-600">
                            {{ $fault->symptoms }}
                        </p>
                    </div>

                    <div>
                        <h3 class="font-bold mb-1">
                            Possible Causes
                        </h3>
                        <p class="text-slate-600">
                            {{ $fault->possible_causes ?? 'Not yet documented.' }}
                        </p>
                    </div>

                    <div>
                        <h3 class="font-bold mb-1">
                            Recommended Repair
                        </h3>
                        <p class="text-slate-600">
                            {{ $fault->recommended_repair ?? 'Not yet documented.' }}
                        </p>
                    </div>

                </div>

                <!-- Verification Status -->
                <div class="border-t border-slate-100 mt-6 pt-4">

                    @php
                        $status = $fault->verification_status;
                    @endphp

                    <span @class([
                        'text-xs font-semibold px-3 py-1 rounded-full',
                        'bg-slate-100 text-slate-600' => $status === 'unverified',
                        'bg-blue-100 text-blue-700' => $status === 'community_confirmed',
                        'bg-green-100 text-green-700' => $status === 'manufacturer_verified',
                    ])>
                        {{ ucwords(str_replace('_', ' ', $status)) }}
                    </span>

                </div>

            </article>

        @empty

            <div class="md:col-span-2 lg:col-span-3
                        bg-white rounded-xl p-12 text-center">

                <h2 class="text-xl font-bold mb-3">
                    No Common Faults Found
                </h2>

                <p class="text-slate-500">
                    We haven't documented any common faults
                    for this vehicle yet.
                </p>

            </div>

        @endforelse

    </div>

    <!-- Pagination -->
    <div class="mt-10">
        {{ $faults->links() }}
    </div>

    <p class="text-xs text-slate-500 mt-10">
        Automotive fault information is provided for reference.
        Unverified entries are not confirmed diagnoses or
        manufacturer-approved repair instructions.
    </p>

</section>

@endsection
