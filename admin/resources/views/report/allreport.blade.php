@extends('layout.master')
@section('content')
<title>All Reports</title>
<link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
<script src="https://cdn.tailwindcss.com"></script>

<main class="flex-1 bg-[#B5E2FF] p-10 min-h-screen">
    <h1 class="text-3xl font-bold text-gray-800 mb-2">⚠️ All Reports</h1>
    <p class="text-gray-600 mb-10">Here are the 2 categories of reports you can review</p>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 place-items-center">
        <!-- Reported Comments Square -->
        <div class="bg-white rounded-lg shadow hover:shadow-lg transition w-80 h-80 flex flex-col items-center justify-center p-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-gray-800 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 4H7a2 2 0 01-2-2V6a2 2 0 012-2h7l5 5v11a2 2 0 01-2 2z" />
            </svg>
            <a href="/report/reportcomment"
               class="w-full bg-blue-700 text-white text-center py-3 rounded-lg text-lg font-semibold hover:bg-blue-800">
                Reported Comments
            </a>
        </div>

        <!-- Reported Reviews Square -->
        <div class="bg-white rounded-lg shadow hover:shadow-lg transition w-80 h-80 flex flex-col items-center justify-center p-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-gray-800 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6m4 6v-4m-7 6h14a2 2 0 002-2V7a2 2 0 00-2-2h-5l-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
            </svg>
            <a href="/report/reportreview"
               class="w-full bg-blue-700 text-white text-center py-3 rounded-lg text-lg font-semibold hover:bg-blue-800">
                Reported Reviews
            </a>
        </div>
    </div>
</main>
@endsection
