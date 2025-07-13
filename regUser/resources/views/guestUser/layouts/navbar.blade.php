<nav class="fixed top-0 left-0 w-full z-50 bg-white shadow-md p-5">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
        <!-- Logo -->
        <a href="{{ url('/') }}" class="text-2xl font-extrabold text-black">
            RateMyReads
        </a>

        <!-- Navigation Links -->
        <div class="hidden md:flex space-x-10 text-black text-md font-semibold">
            <a href="{{ url('/') }}" class="hover:underline {{ Request::is('/') ? 'font-bold' : '' }}">Home</a>
            <a href="{{ url('/about') }}" class="hover:underline {{ Request::is('about') ? 'font-bold' : '' }}">About
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
                        class="hover:underline {{ Route::currentRouteName() === 'register' ? 'font-bold' : '' }}">Sign Up</a>
                @endif
                @if (Route::has('login'))
                    <a href="{{ route('login') }}"
                        class="hover:underline {{ Route::currentRouteName() === 'login' ? 'font-bold' : '' }}">Log In</a>
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

<script>
    function toggleDropdown() {
        const dropdown = document.getElementById('dropdown-menu');
        dropdown.classList.toggle('hidden');
    }

    window.onclick = function (event) {
        if (!event.target.closest('.relative')) {
            const dropdown = document.getElementById('dropdown-menu');
            if (!dropdown.classList.contains('hidden')) {
                dropdown.classList.add('hidden');
            }
        }
    }
</script>