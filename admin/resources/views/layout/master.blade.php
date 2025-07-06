<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    @vite('resources/css/app.css') {{-- Your custom CSS will be loaded here --}}
</head>
<body class="flex flex-col min-h-screen overflow-x-hidden"> {{-- Tailwind classes for full height column layout --}}

    <header class="header">
        @include('layout.header')
    </header>

    <div class="flex flex-1"> {{-- Tailwind: flex-1 makes this div fill remaining vertical space --}}
        <aside class="sidebar">
            @include('layout.sidebar')
        </aside>
            {{-- This is where the specific page content (like books.blade.php) will be inserted --}}
            @yield('content')
    </div>
</body>
</html>