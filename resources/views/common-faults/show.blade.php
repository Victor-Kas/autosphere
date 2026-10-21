
@extends('layouts.main')

@section('title', $fault->title . ' | AutoSphere')

@section('content')

<section class="max-w-5xl mx-auto px-6 py-12">

    <a href="{{ route('common-faults.index') }}"
       class="text-accent text-sm font-semibold">
        &larr; Back to Common Faults
    </a>

    <article class="bg-white border border-slate-200
                    rounded-xl shadow-sm p-8 mt-8">

        <!-- Vehicle Information -->
        <div class="mb-8">

            <p class="text-accent font-semibold mb-3">
                {{ $fault->vehicleModel->vehicleMake->name }}
                {{ $fault->vehicleModel->name }}
            </p>

            <h1 class="text-3xl md:text-4xl font-extrabold mb-5">
                {{ $fault->title }}
            </h1>

            @if ($fault->engineVariant)
                <p class="text-slate-500">
                    Engine:
                    {{ $fault->engineVariant->name }}
                    ({{ $fault->engineVariant->engine_code }})
                </p>
            @endif

            <div class="mt-5">
                <span @class([
                    'text-xs font-semibold px-3 py-2 rounded-full',
                    'bg-slate-100 text-slate-600' => $fault->verification_status === 'unverified',
                    'bg-blue-100 text-blue-700' => $fault->verification_status === 'community_confirmed',
                    'bg-green-100 text-green-700' => $fault->verification_status === 'manufacturer_verified',
                ])>
                    {{ ucwords(str_replace('_', ' ', $fault->verification_status)) }}
                </span>
            </div>
        </div>

        <hr class="border-slate-200 mb-8">

        <!-- Symptoms -->
        <div class="mb-10">
            <h2 class="text-xl font-bold mb-4">
                🔍 Common Symptoms
            </h2>

            <p class="text-slate-700 leading-relaxed whitespace-pre-line">{{ $fault->symptoms }}</p>
        </div>

        <!-- Possible Causes -->
        <div class="mb-10">
            <h2 class="text-xl font-bold mb-4">
                ⚙️ Possible Causes
            </h2>

            <p class="text-slate-700 leading-relaxed whitespace-pre-line">{{ $fault->possible_causes ?? 'Not yet documented.' }}</p>
        </div>

        <!-- Recommended Repair -->
        <div class="mb-10">
            <h2 class="text-xl font-bold mb-4">
                🔧 Diagnostic & Repair Guidance
            </h2>

            <div class="bg-surface rounded-lg p-6">
                <p class="text-slate-700 leading-relaxed whitespace-pre-line">{{ $fault->recommended_repair ?? 'Not yet documented.' }}</p>
            </div>
        </div>

        <!-- Disclaimer -->
        <div class="bg-blue-50 border border-blue-200
                    rounded-lg p-5 mb-8">

            <p class="text-blue-900 text-sm">
                <strong>Important:</strong>
                This information is provided for reference only.
                Community-submitted and unverified information
                should not be treated as a confirmed diagnosis
                or manufacturer-approved repair procedure.
            </p>
        </div>

        <!-- Vehicle Hub Link -->
        <a href="{{ route('vehicles.show', [
            'make' => $fault->vehicleModel->vehicleMake->slug,
            'model' => $fault->vehicleModel->slug
        ]) }}"
           class="inline-block bg-accent hover:bg-blue-700
                  text-white font-semibold px-6 py-3 rounded-lg">

            Explore Vehicle Hub &rarr;
        </a>

    </article>

    <!-- Related Community Discussions -->
    <div class="bg-white border border-slate-200
                rounded-xl shadow-sm p-8 mt-8">

        <h2 class="text-2xl font-bold mb-3">
            Related Community Discussions
        </h2>

        <p class="text-slate-500 mb-6">
            See how other vehicle owners have discussed
            similar problems.
        </p>

        <div class="space-y-4">

            @forelse ($fault->breakdowns as $breakdown)

                <div class="border border-slate-200
                            rounded-lg p-5">

                    <div class="flex justify-between
                                items-start gap-4">

                        <h3 class="font-bold text-lg">
                            <a href="{{ route('breakdowns.show', $breakdown) }}"
                            class="hover:text-accent">
                                {{ $breakdown->title }}
                            </a>
                        </h3>

                        <span @class([
                            'text-xs font-semibold px-3 py-1 rounded-full',
                            'bg-green-100 text-green-700' => $breakdown->status === 'resolved',
                            'bg-amber-100 text-amber-700' => $breakdown->status === 'open',
                        ])>
                            {{ ucfirst($breakdown->status) }}
                        </span>

                    </div>

                    <p class="text-sm text-slate-500 mt-3">
                        Posted by {{ $breakdown->user->name }}
                        &bull;
                        {{ $breakdown->created_at->diffForHumans() }}
                    </p>

                    <p class="text-sm text-slate-600 mt-3">
                        {{ \Illuminate\Support\Str::limit($breakdown->description, 160) }}
                    </p>

                    <a href="{{ route('breakdowns.show', $breakdown) }}"
                    class="inline-block text-accent
                            font-semibold text-sm mt-4">
                        View Discussion &rarr;
                    </a>

                </div>

            @empty

                <p class="text-slate-500">
                    No related community discussions yet.
                </p>

            @endforelse

        </div>
    </div>

</section>

@endsection
