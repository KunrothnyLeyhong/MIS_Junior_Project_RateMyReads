<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'RateMyReads') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet" />

    <!-- Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="flex flex-col min-h-screen bg-[#B5E2FF]">

    {{-- App Wrapper --}}
    <div id="app">

        <nav class="fixed top-0 left-0 w-full z-50 bg-[#B5E2FF] shadow-md p-5">
            <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
                <!-- Logo -->
                <a href="{{ url('/') }}" class="text-2xl font-extrabold text-black">
                    RateMyReads
                </a>

                <!-- Navigation Links -->
                <div class="hidden md:flex space-x-10 text-black text-md font-semibold">
                    <a href="{{ url('/') }}" class="hover:underline {{ Request::is('/') ? 'font-bold' : '' }}">Home</a>
                    <a href="{{ url('/about') }}"
                        class="hover:underline {{ Request::is('about') ? 'font-bold' : '' }}">About
                        Us</a>
                    <a href="{{ url('/g_books') }}"
                        class="hover:underline {{ Request::is('g_books') ? 'font-bold' : '' }}">Books</a>
                    <a href="{{ url('/contact') }}"
                        class="hover:underline {{ Request::is('contact') ? 'font-bold' : '' }}">Contact Us</a>

                </div>
                <div class="hidden md:flex space-x-10 text-black text-md font-semibold">

                    @guest
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="hover:underline {{ Route::currentRouteName() === 'register' ? 'font-bold' : '' }}">Sign
                                Up</a>
                        @endif
                        @if (Route::has('login'))
                            <a href="{{ route('login') }}"
                                class="hover:underline {{ Route::currentRouteName() === 'login' ? 'font-bold' : '' }}">Log
                                In</a>
                        @endif
                    @else
                            <div class="relative">
                                <button onclick="toggleDropdown()" class="hover:underline">
                                    {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
                                </button>
                                <div id="dropdown-menu" class="absolute hidden right-0 mt-2 bg-white rounded shadow-lg">
                                    <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                        class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                        Logout
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endguest
                </div>
            </div>
        </nav>

        <main class="flex-grow pt-35">
            <div class="min-h-screen flex items-center justify-center bg-[#B5E2FF] px-4">
                <div class="flex w-full max-w-6xl bg-gray-50 rounded-2xl overflow-hidden shadow-lg -mt-20">


                    <!-- Left Side: Illustration-->
                    <div class="w-1/2 bg-gray-100 flex flex-col justify-center items-center p-10">
                        <img src="{{ asset('img/loginPic.png') }}" alt="Project progress" class="mb-6">
                    </div>

                    <!-- Right Side: Login Form -->
                    <div class="w-1/2 p-15">
                        <h2 class="text-3xl font-bold mb-6">LOG IN</h2>
                        <form method="POST" action="{{ route('login') }}" class="p-6 rounded-xl">
                            @csrf

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <!-- Email -->
                            <div class="mb-4 py-2">
                                <input id="email" type="email" name="email" value="{{ old('email') }}"
                                    class="bg-white w-full px-4 py-3 rounded-xl border  focus:outline-none focus:ring-2 focus:ring-blue-300 placeholder-gray-500 shadow @error('email') border-red-500 @enderror"
                                    placeholder="Email" required autocomplete="email" autofocus>
                                @error('email')
                                    <p class="text-sm text-red-500 mt-1 text-left">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-4 py-2 relative">
                                <input id="password" type="password" name="password"
                                    class="bg-white w-full px-4 py-3 rounded-xl border focus:outline-none focus:ring-2 focus:ring-blue-300 placeholder-gray-500 shadow @error('password') border-red-500 @enderror"
                                    placeholder="Password" required autocomplete="current-password">
                                <span id="togglePassword" onclick="togglePassword()"
                                    class="absolute right-6 top-5.5 cursor-pointer">🙈</span>
                                @error('password')
                                    <p class="text-sm text-red-500 mt-1 text-left">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <div class="flex justify-center mb-4 py-3">
                                <button type="submit"
                                    class="w-1/2 bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 rounded-full transition duration-200">
                                    Login
                                </button>
                            </div>

                            <!-- Register Link -->
                            <p class="text-sm">Don’t have an account?
                                <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Create
                                    account</a>
                            </p>
                        </form>
                    </div>


                </div>
            </div>
        </main>

    </div>

    <script>
        function togglePassword() {
            const passField = document.getElementById("password");
            const toggle = document.getElementById("togglePassword");

            if (passField.type === "password") {
                passField.type = "text";
                toggle.textContent = "👁️"; // Show eye when password is visible
            } else {
                passField.type = "password";
                toggle.textContent = "🙈"; // Show monkey when password is hidden
            }
        }

    </script>
</body>

</html>