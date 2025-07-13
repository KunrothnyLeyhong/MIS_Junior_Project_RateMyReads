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

        {{-- Navbar --}}
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

        {{-- Sign Up Form --}}
        <main class="flex-grow pt-30">
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

        {{-- Login Form --}}
        <main class="flex-grow pt-30">
            <div class="min-h-screen flex items-center justify-center px-4">
                <div class="flex w-full max-w-6xl bg-gray-100 rounded-2xl overflow-hidden shadow-lg -mt-10">

                    <!-- Left Side: Login Form -->
                    <div class="w-1/2 p-10">

                        <h2 class="text-3xl font-bold text-center mb-6 py-4">SIGN UP</h2>

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <!-- 🔴 Validation Errors -->
                            @if ($errors->any())
                                <div class="mb-4 text-red-500">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li class="text-sm">{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <!-- First Name & Last Name -->
                            <div class="flex gap-4 mb-4 py-2">
                                <input type="text" name="first_name" placeholder="First Name *" required
                                    class="bg-white w-1/2 px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400 shadow">
                                <input type="text" name="last_name" placeholder="Last Name *" required
                                    class="bg-white w-1/2 px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400 shadow">
                            </div>

                            <!-- Email & Date of Birth -->
                            <div class="flex gap-4 mb-4 py-2">
                                <input type="email" name="email" placeholder="Email *" required
                                    class="bg-white w-1/2 px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400 shadow">

                                <input type="date" id="dob" name="dob" required
                                    class="bg-white w-1/2 px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400 shadow"
                                    max="{{ date('Y-m-d') }}" placeholder="Date of Birth">
                            </div>

                            <!-- Phone Number with Country Code (inline) -->
                            <div class="mb-4 py-2">
                                <div class="flex">
                                    <!-- Country Code Select -->
                                    <select name="country_code" required
                                        class="w-36 bg-white rounded-l-xl border border-r-0 border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400 px-4 py-3 shadow">
                                        <option value="+1">+1 (US)</option>
                                        <option value="+44">+44 (UK)</option>
                                        <option value="+855" selected>+855 (Cambodia)</option>
                                        <option value="+91">+91 (India)</option>
                                    </select>

                                    <!-- Phone Number -->
                                    <input type="tel" name="phone" id="phone" placeholder="Phone number"
                                        class="bg-white rounded-r-xl border border-l-0 border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400 px-4 py-3 w-full shadow">
                                </div>
                            </div>


                            <!-- Password -->
                            <div class="mb-4 py-2 relative">
                                <input type="password" id="password" name="password" placeholder="Create Password *"
                                    required
                                    class="bg-white w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400 pr-12 shadow">
                                <span id="togglePassword" onclick="togglePassword('password', 'togglePassword')"
                                    class="absolute right-4 top-4.5 cursor-pointer select-none text-xl">🙈</span>
                                <p class="text-xs text-gray-600 mt-1">
                                    Password must be at least 8 characters, include a number and a special character.
                                </p>
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-6 py-2 relative">
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    placeholder="Re-enter Password *" required
                                    class="bg-white w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400 pr-12 shadow">
                                <span id="togglePasswordConfirm"
                                    onclick="togglePassword('password_confirmation', 'togglePasswordConfirm')"
                                    class="absolute right-4 top-4.5 cursor-pointer select-none text-xl">🙈</span>
                            </div>

                            <!-- Sign up button -->
                            <div class="text-center mb-4 py-2">
                                <button type="submit"
                                    class="w-1/3 bg-blue-500 hover:bg-blue-600 text-white font-semibold px-8 py-3 rounded-full transition shadow">
                                    Sign up
                                </button>
                            </div>
                        </form>

                        <!-- Already have an account? -->
                        <p class="text-sm text-center">Already have an account?
                            <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Log in</a>
                        </p>

                    </div>

                    <!-- Right Side: Illustration -->
                    <div class="w-1/2 bg-gray-50 flex flex-col justify-center items-center p-10">
                        <img src="{{ asset('img/signupPic.png') }}" alt="Project progress" class="w-4/5 mb-6">
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        function togglePassword(inputId, toggleId) {
            const passField = document.getElementById(inputId);
            const toggle = document.getElementById(toggleId);

            if (passField.type === "password") {
                passField.type = "text";
                toggle.textContent = "👁️";
            } else {
                passField.type = "password";
                toggle.textContent = "🙈";
            }
        }
    </script>
</body>

</html>