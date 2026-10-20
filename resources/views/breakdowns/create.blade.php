
@extends('layouts.main')

@section('title', 'Report a Breakdown | AutoSphere')

@section('content')

<section class="max-w-3xl mx-auto px-6 py-12">

    <h1 class="text-3xl font-extrabold mb-3">
        Report a Breakdown
    </h1>

    <p class="text-slate-500 mb-8">
        Having trouble with your vehicle?
        Describe the problem and let the community help.
    </p>

    @if (session('success'))
        <div class="bg-green-100 text-green-800 rounded-lg p-4 mb-6">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST"
          action="{{ route('breakdowns.store') }}"
          class="bg-white rounded-xl border border-slate-200 p-8 space-y-6">

        @csrf

        <div>
            <label for="vehicle_model_id"
                   class="block font-semibold mb-2">
                Vehicle *
            </label>

            <select name="vehicle_model_id"
                    id="vehicle_model_id"
                    required
                    class="w-full rounded-lg border-slate-300">

                <option value="">Select your vehicle</option>

                @foreach ($vehicles as $vehicle)
                    <option value="{{ $vehicle->id }}"
                        @selected(old('vehicle_model_id') == $vehicle->id)>
                        {{ $vehicle->vehicleMake->name }}
                        {{ $vehicle->name }}
                    </option>
                @endforeach
            </select>

            @error('vehicle_model_id')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="engine_variant_id"
                   class="block font-semibold mb-2">
                Engine Variant (Optional)
            </label>

            <select name="engine_variant_id"
                    id="engine_variant_id"
                    class="w-full rounded-lg border-slate-300">

                <option value="">Not sure / Unknown</option>

                @foreach ($vehicles as $vehicle)
                    @foreach ($vehicle->generations as $generation)
                        @foreach ($generation->engineVariants as $engine)
                            <option value="{{ $engine->id }}"
                                    data-model="{{ $vehicle->id }}"
                                    @selected(old('engine_variant_id') == $engine->id)>
                                {{ $generation->name }} -
                                {{ $engine->name }}
                                ({{ $engine->engine_code }})
                            </option>
                        @endforeach
                    @endforeach
                @endforeach
            </select>

            @error('engine_variant_id')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="title" class="block font-semibold mb-2">
                What's the problem? *
            </label>

            <input type="text"
                   id="title"
                   name="title"
                   value="{{ old('title') }}"
                   required
                   maxlength="255"
                   placeholder="e.g. Engine cranks but won't start"
                   class="w-full rounded-lg border-slate-300">

            @error('title')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="description" class="block font-semibold mb-2">
                Describe the symptoms *
            </label>

            <textarea id="description"
                      name="description"
                      rows="6"
                      required
                      minlength="20"
                      placeholder="When did the problem start? What have you tried?"
                      class="w-full rounded-lg border-slate-300">{{ old('description') }}</textarea>

            @error('description')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="mileage" class="block font-semibold mb-2">
                Mileage (km)
            </label>

            <input type="number"
                   id="mileage"
                   name="mileage"
                   value="{{ old('mileage') }}"
                   min="0"
                   placeholder="e.g. 185000"
                   class="w-full rounded-lg border-slate-300">

            @error('mileage')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit"
                class="bg-accent hover:bg-blue-700 text-white
                       font-semibold px-8 py-3 rounded-lg">
            Publish Breakdown
        </button>
    </form>
</section>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const vehicleSelect = document.getElementById('vehicle_model_id');
    const engineSelect = document.getElementById('engine_variant_id');
    const engineOptions = Array.from(engineSelect.options).slice(1);

    function filterEngines() {
        const selectedVehicle = vehicleSelect.value;

        engineOptions.forEach(option => {
            option.hidden = option.dataset.model !== selectedVehicle;
            option.disabled = option.dataset.model !== selectedVehicle;
        });

        if (engineSelect.selectedOptions[0]?.disabled) {
            engineSelect.value = '';
        }
    }

    vehicleSelect.addEventListener('change', filterEngines);
    filterEngines();
});
</script>

@endsection
