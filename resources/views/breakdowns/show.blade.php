@extends('layouts.main')

@section('title', $breakdown->title . ' | AutoSphere')

@section('content')

<section class="max-w-5xl mx-auto px-6 py-12">

    <a href="{{ route('breakdowns.index') }}"
       class="text-accent text-sm font-semibold">
        &larr; Back to Breakdown Help
    </a>

    @if (session('success'))
        <div class="bg-green-100 text-green-800
                    rounded-lg p-4 mt-6">
            {{ session('success') }}
        </div>
    @endif

    <article class="bg-white border border-slate-200
                    rounded-xl shadow-sm p-8 mt-8">

        <div class="flex justify-between items-start gap-4 mb-6">

            <div>
                <p class="text-accent font-semibold mb-2">
                    {{ $breakdown->vehicleModel->vehicleMake->name }}
                    {{ $breakdown->vehicleModel->name }}
                </p>

                <h1 class="text-3xl font-extrabold">
                    {{ $breakdown->title }}
                </h1>
            </div>

            <span @class([
                'text-xs font-semibold px-3 py-1 rounded-full',
                'bg-green-100 text-green-700' => $breakdown->status === 'resolved',
                'bg-amber-100 text-amber-700' => $breakdown->status === 'open',
            ])>
                {{ ucfirst($breakdown->status) }}
            </span>

        </div>

        <div class="flex flex-wrap gap-6 text-sm
                    text-slate-500 border-b pb-6 mb-8">

            <span>
                Posted by {{ $breakdown->user->name }}
            </span>

            <span>
                {{ $breakdown->created_at->diffForHumans() }}
            </span>

            @if ($breakdown->mileage !== null)
                <span>
                    {{ number_format($breakdown->mileage) }} km
                </span>
            @endif

        </div>

        @if ($breakdown->engineVariant)
            <div class="bg-surface rounded-lg p-4 mb-8">

                <p class="text-sm font-semibold mb-1">
                    Engine Configuration
                </p>

                <p class="text-slate-600">
                    {{ $breakdown->engineVariant->name }}
                    ({{ $breakdown->engineVariant->engine_code }})
                </p>

            </div>
        @endif

        <div>
            <h2 class="text-xl font-bold mb-4">
                Problem Description
            </h2>

            <p class="text-slate-700 leading-relaxed whitespace-pre-line">{{ $breakdown->description }}</p>
        </div>

    </article>

   
<!-- Community Solutions -->
<section class="bg-white border border-slate-200
                rounded-xl p-8 mt-8">

    <h2 class="text-2xl font-bold mb-6">
        Community Solutions
        <span class="text-slate-400 text-lg">
            ({{ $breakdown->solutions->count() }})
        </span>
    </h2>

    <!-- Existing Responses -->
    <div class="space-y-6">

        @forelse ($breakdown->solutions as $solution)

            <div class="border-b border-slate-100 pb-6">

                <div class="flex items-center justify-between
                            gap-4 mb-3">

                    <div>
                        <p class="font-semibold">
                            {{ $solution->user->name }}
                        </p>

                        <p class="text-xs text-slate-500">
                            {{ $solution->created_at->diffForHumans() }}
                        </p>
                    </div>

                    @if ($solution->is_accepted)
                        <span class="bg-green-100 text-green-700
                                     text-xs font-semibold
                                     px-3 py-1 rounded-full">
                            ✓ Accepted Solution
                        </span>
                    @endif

                </div>

                <p class="text-slate-700 leading-relaxed whitespace-pre-line">{{ $solution->body }}</p>

                {{-- Only the breakdown author can accept a solution --}}
                @auth
                    @if (
                        auth()->id() === $breakdown->user_id
                        && $breakdown->status === 'open'
                    )

                        <form method="POST"
                            action="{{ route('breakdowns.solutions.accept', [
                                'breakdown' => $breakdown,
                                'solution' => $solution
                            ]) }}"
                            class="mt-4">

                            @csrf
                            @method('PATCH')

                            <button type="submit"
                                    class="bg-green-600 hover:bg-green-700
                                        text-white text-sm font-semibold
                                        px-4 py-2 rounded-lg">

                                ✓ Accept Solution

                            </button>

                        </form>

                    @endif
                @endauth
            </div>

        @empty
            <p class="text-slate-500">
                No solutions suggested yet.
                Be the first to help!
            </p>
        @endforelse

    </div>

    <!-- Reply Form -->
    <div class="mt-10">

        <h3 class="text-xl font-bold mb-4">
            Suggest a Solution
        </h3>

        @auth

            <form method="POST"
                  action="{{ route('breakdowns.solutions.store', $breakdown) }}"
                  class="space-y-4">

                @csrf

                <div>
                    <textarea name="body"
                              rows="5"
                              required
                              minlength="10"
                              maxlength="5000"
                              placeholder="Share a possible diagnosis, troubleshooting step or repair solution..."
                              class="w-full rounded-lg border-slate-300">{{ old('body') }}</textarea>

                    @error('body')
                        <p class="text-red-600 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <button type="submit"
                        class="bg-accent hover:bg-blue-700
                               text-white font-semibold
                               px-6 py-3 rounded-lg">
                    Post Response
                </button>

            </form>

        @else

            <p class="text-slate-500">
                Want to help solve this breakdown?
                <a href="{{ route('login') }}"
                   class="text-accent font-semibold">
                    Log in
                </a>
                to contribute.
            </p>

        @endauth

    </div>

</section>


</section>

@endsection
