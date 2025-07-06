@extends('layout.master')
@section('content')

<title>Profile</title>
<link rel="stylesheet" href="{{ asset('assets/css/app.css')}}">

<main class="flex-1 bg-[#B5E2FF] p-10">
    <div class="bg-white p-6 rounded shadow-md max-w-4xl mx-auto min-h-[500px]">
        <h2 class="text-xl font-semibold text-center mb-6">Change Password</h2>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
        @elseif(session('error'))
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">{{ session('error') }}</div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('adminprofile.password.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-4">

                {{-- Old Password --}}
                <div>
                    <label class="text-sm text-gray-600">Old Password</label>
                    <div class="relative">
                        <input type="password" id="old_password" name="old_password" class="w-full p-2 rounded bg-gray-100 border pr-10" required />
                        <span onclick="togglePassword('old_password', this)" class="absolute right-3 top-3 cursor-pointer">
                            <!-- Eye SVG (visible by default) -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 eye-off-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.987 9.987 0 012.497-4.177M6.354 6.354a9.956 9.956 0 014.147-1.354m4.176.276a9.968 9.968 0 014.144 2.24M9.879 9.879A3 3 0 1114.12 14.12M15 12a3 3 0 00-3-3m0 0V5m0 4.5l5.5 5.5" />
                            </svg>
                        </span>
                    </div>
                </div>

                {{-- New Password --}}
                <div>
                    <label class="text-sm text-gray-600">New Password</label>
                    <div class="relative">
                        <input type="password" id="new_password" name="new_password" class="w-full p-2 rounded bg-gray-100 border pr-10" required />
                        <span onclick="togglePassword('new_password', this)" class="absolute right-3 top-3 cursor-pointer">
                            <!-- Eye SVG -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 eye-off-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.987 9.987 0 012.497-4.177M6.354 6.354a9.956 9.956 0 014.147-1.354m4.176.276a9.968 9.968 0 014.144 2.24M9.879 9.879A3 3 0 1114.12 14.12M15 12a3 3 0 00-3-3m0 0V5m0 4.5l5.5 5.5" />
                            </svg>
                        </span>
                    </div>
                </div>

                {{-- Confirm Password --}}
                <div>
                    <label class="text-sm text-gray-600">Confirm Password</label>
                    <div class="relative">
                        <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="w-full p-2 rounded bg-gray-100 border pr-10" required />
                        <span onclick="togglePassword('new_password_confirmation', this)" class="absolute right-3 top-3 cursor-pointer">
                            <!-- Eye SVG -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 eye-off-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.987 9.987 0 012.497-4.177M6.354 6.354a9.956 9.956 0 014.147-1.354m4.176.276a9.968 9.968 0 014.144 2.24M9.879 9.879A3 3 0 1114.12 14.12M15 12a3 3 0 00-3-3m0 0V5m0 4.5l5.5 5.5" />
                            </svg>
                        </span>
                    </div>
                </div>

            </div>

            <div class="flex justify-center mt-6">
                <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded hover:bg-green-600">Update</button>
            </div>
        </form>
    </div>
</main>

{{-- Toggle Script --}}
<script>
    function togglePassword(fieldId, iconElement) {
        const input = document.getElementById(fieldId);
        const isPassword = input.type === 'password';

        input.type = isPassword ? 'text' : 'password';

        // Swap icon (optional: replace SVG path to show eye-off)
        iconElement.innerHTML = isPassword
            ? `<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 eye-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M2.458 12C3.732 7.943 7.522 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.478 0-8.268-2.943-9.542-7z" />
               </svg>`
            : `<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 eye-off-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.987 9.987 0 012.497-4.177M6.354 6.354a9.956 9.956 0 014.147-1.354m4.176.276a9.968 9.968 0 014.144 2.24M9.879 9.879A3 3 0 1114.12 14.12M15 12a3 3 0 00-3-3m0 0V5m0 4.5l5.5 5.5" />
               </svg>`;
    }
</script>

@endsection
