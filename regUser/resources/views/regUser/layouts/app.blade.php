<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'RateMyReads') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css?family=Gantari:400,600,700" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    

    <!-- Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen">
    {{-- Preloader --}}
    <div id="app" class="flex flex-col min-h-screen">

        {{-- Navbar --}}
        @include('regUser.layouts.navbar')

        {{-- Main Content --}}
        <main class="flex-grow">
            <div class="max-w-7xl mx-auto px-4">
                @yield('content')
            </div>
        </main>

        {{-- Footer --}}
        @include('regUser.layouts.footer')

    </div>
    
    @stack('scripts')

</body>
</html>
