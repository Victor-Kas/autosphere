
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'AutoSphere')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-surface font-sans text-primary">

    <!-- Navigation -->
    <nav class="bg-primary text-white">
        <div class="max-w-7xl mx-auto px-6 py-5
                    flex items-center justify-between">

            <a href="{{ route('home') }}"
               class="text-2xl font-extrabold">
                Auto<span class="text-blue-500">Sphere</span>
            </a>

            <div class="hidden md:flex items-center gap-8 text-sm">
                <a href="{{ route('home') }}"
                   class="hover:text-blue-400">
                    Home
                </a>

                <a href="{{ route('vehicles.index') }}"
                   class="hover:text-blue-400">
                    Explore Vehicles
                </a>

                <a href="{{ route('breakdowns.index') }}"
                class="hover:text-blue-400">
                    Breakdown Help
                </a>

                <a href="#"
                   class="hover:text-blue-400">
                    Spare Parts
                </a>
            </div>

            <div class="flex items-center gap-4 text-sm">
                @auth
                    <a href="{{ route('dashboard') }}"
                       class="bg-accent hover:bg-blue-700
                              px-5 py-2.5 rounded-lg font-semibold">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="hidden sm:inline">
                        Log In
                    </a>

                    <a href="{{ route('register') }}"
                       class="bg-accent hover:bg-blue-700
                              px-5 py-2.5 rounded-lg font-semibold">
                        Join AutoSphere
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-primary text-slate-400
                   text-center py-8 text-sm">
        &copy; {{ date('Y') }} AutoSphere.
        Built for the automotive community.
    </footer>

</body>
</html>
