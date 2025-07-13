@extends('layout.master')

@section('content')
    <div class="flex-1 bg-[#B5E2FF] p-6">
        <div class="bg-white rounded-lg shadow-lg p-6 max-w-4xl mx-auto">
            @php
                $review = $report->reportable;
                $user = $review?->user;
                $book = $review?->book;
            @endphp
            <div class="mb-6">
                <a href="{{ route('report.reportreview') }}"
                    class="inline-block bg-blue-300 text-gray-800 px-4 py-2 rounded shadow hover:bg-blue-400 transition">
                    ←
                </a>
            </div>
            <div class="md:flex md:space-x-6">
                <!-- Book Cover -->
                <div class="flex justify-center md:block mb-4 md:mb-0">
                    @if ($book && $book->image)
                        <img src="{{ $book->image }}" alt="Book Cover" class="rounded shadow max-h-72">
                    @else
                        <div class="w-48 h-72 bg-gray-200 flex items-center justify-center rounded shadow">
                            <span class="text-gray-500 text-sm">No Cover</span>
                        </div>
                    @endif
                </div>

                <!-- Book Info -->
                <div>
                    <h4 class="text-xl font-bold mb-2">{{ $book->title ?? 'Unknown Title' }}</h4>
                    <p><span class="font-semibold">Written by:</span> {{ $book->author ?? 'Unknown' }}</p>
                    <p><span class="font-semibold">Genre:</span> {{ $book->genre ?? 'Unknown' }}</p>
                    <p><span class="font-semibold">Published in:</span> {{ $book->published_date ?? 'Unknown' }}</p>
                </div>
            </div>

            <hr class="my-6">

            <!-- Review Section -->
            <div class="flex items-center mb-4">

                <img src="{{ $user->profile_picture ?? asset('img/default_picture.avif') }}" alt="User Photo"
                    class="w-10 h-10 rounded-full mr-2" />
                <div>
                    <p class="font-semibold">{{ $user->first_name ?? 'Anonymous' }} {{ $user->last_name ?? '' }}</p>
                    <p class="text-sm text-gray-500">
                        {{ \Carbon\Carbon::parse($review->created_at ?? now())->format('jS F Y') }}
                    </p>
                </div>
            </div>

            <p class="text-gray-700 mb-6">{{ $review->review ?? 'No review found.' }}</p>

            <form method="POST" action="{{ route('report.reportreviewdetail.approve', $report->id) }}" class="inline-block">
    @csrf
    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Approve</button>
</form>

<form method="POST" action="{{ route('report.reportreviewdetail.reject', $report->id) }}" class="inline-block ml-3">
    @csrf
    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
        Reject
    </button>
</form>

        </div>
    </div>
@endsection