@extends('layout.master')

@section('content')
<div class="flex-1 bg-[#B5E2FF] p-6">

    <div class="bg-white rounded-lg shadow-lg p-6 max-w-4xl mx-auto">
        @php
            $comment = $report->reportable;
            $user = $comment?->user;
            $review = $comment?->review;
            $book = $review?->book;
        @endphp

        <div class="mb-6">
            <a href="{{ route('report.reportcomment') }}" class="inline-block bg-blue-300 text-gray-800 px-4 py-2 rounded shadow hover:bg-blue-400 transition">
                ← Back
            </a>
        </div>

        <div class="md:flex md:space-x-6">
            <!-- Book Cover -->
            <div class="flex justify-center md:block mb-4 md:mb-0">
                @if ($book && $book->cover_image)
                    <img src="{{ $book->cover_image }}" alt="Book Cover" class="rounded shadow max-h-72">
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

        <!-- Comment Section -->
        <div class="flex items-center mb-4">
            <img src="https://via.placeholder.com/40" class="rounded-full w-10 h-10 mr-3" alt="User">
            <div>
                <p class="font-semibold">{{ $user->first_name ?? 'Anonymous' }} {{ $user->last_name ?? '' }}</p>
                <p class="text-sm text-gray-500">
                    {{ \Carbon\Carbon::parse($comment->created_at ?? now())->format('jS F Y') }}
                </p>
            </div>
        </div>

        <p class="text-gray-700 mb-6">{{ $comment->message ?? 'No comment found.' }}</p>

        <!-- Action Buttons -->
        <form method="POST" action="{{ route('report.reportcommentdetail.approve', $report->id) }}" class="flex space-x-3">
            @csrf
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Approve</button>
            <a href="{{ route('report.reportcomment.reject', $report->id) }}" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Reject</a>
        </form>
    </div>
</div>
@endsection
