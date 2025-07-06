@extends('layout.master')

@section('content')

    <title>Registered User Profile Detail</title>
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>

    <div class="min-h-screen w-full bg-[#B5E2FF] flex items-center justify-center py-10">
        <div class="w-full max-w-4xl bg-white rounded-xl shadow-xl p-8">
            <h1 class="text-2xl font-bold text-center mb-8">Registered User Profile Detail</h1>

            <div class="flex flex-col items-center mb-10">
                <img src="{{ $user->profile_picture ?: asset("img/default_picture.avif") }}" alt="Profile"
                    class="rounded-full w-36 h-36 mb-4 shadow-md object-cover">
                <h2 class="text-xl font-bold">{{ $user->first_name }} {{ $user->last_name }}</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
                <div>
                    <label class="block text-sm font-medium mb-1">First Name</label>
                    <input type="text" value="{{ $user->first_name }}" readonly
                        class="block w-full border border-gray-300 rounded-md bg-gray-100 p-2">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Last Name</label>
                    <input type="text" value="{{ $user->last_name }}" readonly
                        class="block w-full border border-gray-300 rounded-md bg-gray-100 p-2">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Email</label>
                    <input type="email" value="{{ $user->email }}" readonly
                        class="block w-full border border-gray-300 rounded-md bg-gray-100 p-2">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Phone Number</label>
                    <input type="text" value="{{ $user->phone }}" readonly
                        class="block w-full border border-gray-300 rounded-md bg-gray-100 p-2">
                </div>
            </div>

            <div class="text-center flex justify-center gap-4">
                <a href="{{ route('user.addbook', $user->id) }}"
                    class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-6 rounded">
                    Next
                </a>
            </div>
        </div>
    </div>

@endsection