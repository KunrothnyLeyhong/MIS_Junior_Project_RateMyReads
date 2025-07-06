<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="absolute h-screen w-screen overflow-hidden">

    <!-- Optional Background Image -->
    <!--
    <img 
        src="{{ asset('assets/images/background.webp') }}" 
        alt="Background" 
        class="absolute top-0 left-0 w-full h-full object-cover z-0"
    />
    -->

    <div class="relative z-10 h-full flex items-center justify-center">

        <!-- Character Image -->
        <img 
            src="{{ asset('assets/images/adminlogin2.png') }}" 
            alt="Admin Character" 
            class="absolute left-[45%] top-[60%] transform -translate-y-[50%] scale-x-[-1] w-[900px] z-0 pointer-events-none"
        />

        <!-- Login Box -->
        <div class="relative bg-blue-200 p-8 rounded-lg w-full max-w-md shadow-lg z-20">
            <h2 class="text-2xl font-bold text-center mb-6">ADMIN LOG IN</h2>

            <!-- Error Message -->
            @if ($errors->any())
                <div class="text-red-600 text-sm text-center mb-4">
                    {{ $errors->first() }}
                </div>
            @endif

            @if (session('error'))
                <div class="text-red-600 text-sm text-center mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('adminlogin') }}">
                @csrf

                <!-- Email Input -->
                <div class="mb-4">
                    <input 
                        type="email" 
                        name="email" 
                        placeholder="Email" 
                        value="{{ old('email') }}"
                        class="w-full px-4 py-2 rounded-full shadow focus:outline-none" 
                        required
                    >
                </div>

                <!-- Password Input with Eye Toggle -->
                <div class="mb-4 relative">
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        placeholder="Password" 
                        class="w-full px-4 py-2 pr-10 rounded-full shadow focus:outline-none" 
                        required
                    >
                    <!-- Eye Icon -->
                    <span onclick="togglePassword()" class="absolute right-4 top-2.5 cursor-pointer text-gray-600">
                        <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13.875 18.825A10.05 10.05 0 0112 19
                                c-4.478 0-8.268-2.943-9.542-7
                                a9.987 9.987 0 012.497-4.177M6.354 6.354
                                a9.956 9.956 0 014.147-1.354m4.176.276
                                a9.968 9.968 0 014.144 2.24M9.879 9.879
                                A3 3 0 1114.12 14.12M15 12a3 3 0 00-3-3m0
                                0V5m0 4.5l5.5 5.5" />
                        </svg>
                    </span>
                </div>

                <!-- Submit Button -->
                <div class="text-center">
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded-full shadow"
                    >
                        LOGIN
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- SweetAlert Messages -->
    <script>
        @if($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: @json($errors->first()),
        });
        @endif

        @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: @json(session('success')),
        });
        @endif

        @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: @json(session('error')),
        });
        @endif
    </script>

    <!-- Show/Hide Password Script -->
    <script>
        function togglePassword() {
            const input = document.getElementById("password");
            const eyeIcon = document.getElementById("eyeIcon");

            if (input.type === "password") {
                input.type = "text";
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13.875 18.825A10.05 10.05 0 0112 19
                        c-4.478 0-8.268-2.943-9.542-7
                        a9.987 9.987 0 012.497-4.177M6.354 6.354
                        a9.956 9.956 0 014.147-1.354m4.176.276
                        a9.968 9.968 0 014.144 2.24M9.879 9.879
                        A3 3 0 1114.12 14.12M15 12a3 3 0 00-3-3m0
                        0V5m0 4.5l5.5 5.5" />
                `;
            } else {
                input.type = "password";
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M2.458 12C3.732 7.943 7.522 5 12 5
                           c4.478 0 8.268 2.943 9.542 7
                           -1.274 4.057-5.064 7-9.542 7
                           -4.478 0-8.268-2.943-9.542-7z" />
                `;
            }
        }
    </script>

</body>
</html>
