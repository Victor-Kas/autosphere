@extends('layouts.main')

@section('title', 'Breakdown Help | AutoSphere')


@section('content')

<section class="max-w-7xl mx-auto px-6 py-12">

    <div class="flex flex-wrap justify between items-center gap-6 mb-10">

        <div>
            <h1 class="text-4xl font-extrabold mb-3">
                Breakdown Help
            </h1>
        
            <p class="text-slate-500">
                Having trouble with your vehicle? Browse through the reported breakdowns and find community powered solutions.
            </p>
        </div>

        <a href="{{route('breakdowns.create')}}" class="bg-accent hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg">
            Report a Breakdown
        </a>

    </div>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
    
        @forelse ($breakdowns as $breakdown)
            <article class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 flex flex-col">
                <div class="flex justify-between items-center mb-5">
                    <span class="text-sm font-semibold text-accent">
                        {{$breakdown->vehicleModel->vehicleMake->name}}
                        {{$breakdown->vehicleModel->name}}
                    </span>
                    <span @class([
                        'text-xs font-semibold px-3 py-1 rounded-full',
                        'bg-green-100 text-green-700' => $breakdown->status === 'resolved',
                        'bg-amber-100 text-amber-700' => $breakdown->status === 'open',
                    ])>
                        {{ ucfirst($breakdown->status) }}
                    </span>
                </div>

                <h2 class="text-xl font-bold mb-3">
                    <a href="{{ route('breakdowns.show', $breakdown) }}"
                       class="hover:text-accent">
                        {{ $breakdown->title }}
                    </a>
                </h2>
                <p class="text-slate-500 text-sm leading-relaxed mb-6">
                    {{ \Illuminate\Support\Str::limit($breakdown->description, 140) }}
                </p>
                <div class="mt-auto border-t border-slate-100 pt-4">

                    <p class="text-xs text-slate-500 mb-3">
                        Posted by {{ $breakdown->user->name }}
                        &bull;
                        {{ $breakdown->created_at->diffForHumans() }}
                    </p>

                    <a href="{{ route('breakdowns.show', $breakdown) }}"
                       class="text-accent font-semibold text-sm">
                        View Discussion &rarr;
                    </a>

                </div>
            </article>
        @empty
            <div class="md:col-span-2 lg:col-span-3 bg-white rounded-xl p-12 text-center">

                <h2 class="text-xl font-bold mb-3">
                    No breakdowns reported yet.
                </h2>

                <p class="text-slate-500">
                    Be the first member to ask the community for help!
                </p>

            </div>
        @endforelse
    </div>  

    <div class="mt-10">
        {{ $breakdowns->links() }}
    </div>

</section>

@endsection