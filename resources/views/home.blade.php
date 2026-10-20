
@extends('layouts.main')

@section('title', 'AutoSphere | Every Vehicle Has a Story')

@section('content')

    <!-- Hero -->
    <section class="relative bg-primary text-white
                    min-h-[520px] flex items-center">

        <div class="absolute inset-0 bg-cover bg-center"
             style="background-image:
                    linear-gradient(to right,
                    rgba(15,23,42,0.98),
                    rgba(15,23,42,0.55)),
                    url('{{ asset('images/hero-car.jpg') }}');">
        </div>

        <div class="relative max-w-7xl mx-auto
                    px-6 py-24 w-full">

            <div class="max-w-2xl">
                <p class="text-blue-400 font-semibold
                          uppercase tracking-widest mb-5">
                    Built for drivers. Powered by community.
                </p>

                <h1 class="text-4xl md:text-6xl
                           font-extrabold leading-tight">
                    Every Vehicle Has a Story.
                    <span class="text-blue-500">
                        Share Yours.
                    </span>
                </h1>

                <p class="mt-7 text-lg text-slate-300 leading-relaxed">
                    Discover honest vehicle reviews, get breakdown
                    assistance, share repair solutions and find
                    the right spare parts.
                </p>

                <div class="mt-10 flex flex-wrap gap-4">
                    <a href="{{ route('vehicles.index') }}"
                       class="bg-accent hover:bg-blue-700
                              px-8 py-3 rounded-lg font-semibold">
                        Explore Vehicles →
                    </a>

                    <a href="#features"
                       class="border border-slate-400
                              hover:bg-white/10 px-8 py-3
                              rounded-lg font-semibold">
                        Explore AutoSphere
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section id="features" class="max-w-7xl mx-auto px-6 py-20">

        <div class="text-center mb-12">
            <h2 class="text-3xl font-extrabold">
                Everything Automotive. One Community.
            </h2>

            <p class="text-slate-500 mt-3">
                Your vehicle knowledge hub starts here.
            </p>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            @foreach ([
                [
                    'title' => 'Vehicle Reviews',
                    'description' => 'Discover real ownership experiences, performance insights and reliability reviews.',
                    'icon' => '🚙'
                ],
                [
                    'title' => 'Breakdown Help',
                    'description' => 'Get troubleshooting advice and practical repair solutions from the community.',
                    'icon' => '🔧'
                ],
                [
                    'title' => 'Spare Parts',
                    'description' => 'Discover compatible replacement parts and authorised suppliers.',
                    'icon' => '⚙️'
                ]
            ] as $feature)

                <div class="bg-white rounded-2xl shadow-sm
                            border border-slate-200 p-8
                            hover:shadow-lg transition">

                    <div class="text-4xl mb-6">
                        {{ $feature['icon'] }}
                    </div>

                    <h3 class="text-xl font-bold mb-3">
                        {{ $feature['title'] }}
                    </h3>

                    <p class="text-slate-500 leading-relaxed">
                        {{ $feature['description'] }}
                    </p>
                </div>

            @endforeach
        </div>
    </section>

@endsection
