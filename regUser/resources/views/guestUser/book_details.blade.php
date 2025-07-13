@extends('guestUser.layouts.app')

@section('content')
  <div class="container mx-auto px-6 py-10 pt-36">
    <!-- Book Overview -->
    <div class="flex flex-col md:flex-row gap-15">
    <div>
      <div class="bg-[#B2E2FF] p-4 rounded-lg mb-6">
      <img src="{{ $book->image }}" alt="Book Image"
        class="w-full md:w-64 h-auto object-cover rounded-xl shadow-md" />
      </div>
    </div>

    <div class="flex-1 space-y-4">
      <h1 class="text-3xl font-bold leading-tight">{{ $book->title }}</h1>
      <p class="text-lg text-[#0890F4] font-medium">By {{ $book->author }}</p>

      <!-- Average Rating -->
      @php
    $average = $book->reviews->avg('rating');
    function renderStars($rating)
    {
      $fullStar = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#FFD700" class="bi bi-star-fill" viewBox="0 0 16 16">
      <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
      </svg>';

      $halfStar = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#FFD700" class="bi bi-star-half" viewBox="0 0 16 16">
      <path d="M5.354 5.119 7.538.792A.52.52 0 0 1 8 .5c.183 0 .366.097.465.292l2.184 4.327 4.898.696A.54.54 0 0 1 16 6.32a.55.55 0 0 1-.17.445l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256a.5.5 0 0 1-.146.05c-.342.06-.668-.254-.6-.642l.83-4.73L.173 6.765a.55.55 0 0 1-.172-.403.6.6 0 0 1 .085-.302.51.51 0 0 1 .37-.245zM8 12.027a.5.5 0 0 1 .232.056l3.686 1.894-.694-3.957a.56.56 0 0 1 .162-.505l2.907-2.77-4.052-.576a.53.53 0 0 1-.393-.288L8.001 2.223 8 2.226z"/>
      </svg>';

      $emptyStar = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#FFD700" class="bi bi-star" viewBox="0 0 16 16">
      <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.56.56 0 0 0-.163-.505L1.71 6.745l4.052-.576a.53.53 0 0 0 .393-.288L8 2.223l1.847 3.658a.53.53 0 0 0 .393.288l4.052.575-2.906 2.77a.56.56 0 0 0-.163.506l.694 3.957-3.686-1.894a.5.5 0 0 0-.461 0z"/>
      </svg>';

      $stars = '';

      $full = floor($rating);
      $fraction = $rating - $full;

      // Handle floating point correctly
      if (round($fraction, 2) >= 0.75) {
      $full++;
      $half = 0;
      } elseif (round($fraction, 2) >= 0.25) {
      $half = 1;
      } else {
      $half = 0;
      }

      for ($i = 0; $i < 5; $i++) {
      if ($i < $full) {
      $stars .= $fullStar;
      } elseif ($half === 1) {
      $stars .= $halfStar;
      $half = 0; // only one half star
      } else {
      $stars .= $emptyStar;
      }
      }

      return $stars;
    }
    @endphp
      <div class="flex items-center gap-5 mb-4">
      <div class="text-lg font-semibold text-black">
        {{ number_format($average, 1) }} / 5
      </div>
      <div class="flex items-center gap-1">
        {!! renderStars($average ?? 0) !!}
      </div>

      <div class="text-sm text-[#0890F4] underline">
        {{ $book->reviews->count() }} Ratings & Reviews
      </div>
      </div>

      <div class="mt-4">
      <h3 class="text-lg font-semibold mb-2">Book Description</h3>
      <p class="text-gray-700 text-base leading-relaxed">{{ $book->description }}</p>
      </div>

      <div class="mt-4">
      <h3 class="text-lg font-semibold mb-2">Genre</h3>
      <span class="inline-block bg-gray-200 text-gray-800 px-3 py-1 rounded-full text-sm">
        {{ $book->genre }}
      </span>
      </div>

      <div class="mt-4">
      <h3 class="text-lg font-semibold mb-2">Book Details</h3>
      <p><strong class="text-[#0890F4]">Publisher:</strong> {{ optional($book->publisher)->first_name ?? 'Unknown' }}
        {{ optional($book->publisher)->last_name ?? '' }}
      </p>
      <p><strong class="text-[#0890F4]">Published Date:</strong> {{ $book->published_date }}</p>
      <p><strong class="text-[#0890F4]">Hardcover:</strong> {{ $book->pages }} pages</p>
      </div>
    </div>
    </div>

    <!-- Reviews -->
    <div class="my-12">
    <h2 class="text-xl font-semibold mb-4">Ratings and Reviews</h2>

    <div class="border-t pt-7">
      <h3 class="text-lg font-semibold mb-4">COMMUNITY REVIEW</h3>
      <div class="flex items-center gap-5 mb-4">
      <p class="text-2xl font-semibold">{{ number_format($average, 1) }} / 5</p>
      <div class="flex items-center gap-1">
        {!! renderStars($average ?? 0) !!}
      </div>
      <p class="text-sm text-[#0890F4] underline">{{ $book->reviews->count() }} Ratings & Reviews</p>
      </div>

      @for ($i = 5; $i >= 1; $i--)
      @php
      $count = $book->reviews->where('rating', $i)->count();
      $percent = $book->reviews->count() ? ($count / $book->reviews->count()) * 100 : 0;
      @endphp
      <div class="flex items-center gap-2 text-sm mb-1">
      <span>{{ $i }} star</span>
      @php
      $color = match (true) {
      $i >= 3 => 'bg-[#26A541]', // Green
      $i == 2 => 'bg-[#FF9F00]', // Orange
      $i == 1 => 'bg-[#FF0000]', // Red
      default => 'bg-[#D9D9D9]'
      };
      @endphp

      <div class="w-48 bg-[#D9D9D9] rounded h-2">
        <div class="h-2 rounded {{ $color }}" style="width: {{ $percent }}%"></div>
      </div>

      </div>
    @endfor
    </div>

    <div class="pt-10 space-y-4">
      @forelse ($book->reviews as $review)
      <div class="bg-[#96DEFF] rounded-2xl p-6 shadow-md">
      <div class="flex items-center gap-10">
      <div>
      <img src="{{ $review->user->profile_picture ?? '/img/default_picture.avif' }}"
        class="rounded-full w-12 h-12 object-cover mb-2" />
      <h3 class="text-sm font-semibold">{{ $review->user->first_name }} {{ $review->user->last_name }}</h3>
      </div>
      <div class="flex-1">
      <p class="text-sm text-[#0890F4] font-medium">{{ $review->created_at->format('F j, Y') }}</p>
      <p class="text-black text-base mt-1 whitespace-pre-line">{{ $review->review }}</p>

      </div>
      </div>
      </div>
    @empty
      <p class="text-gray-500">No reviews yet.</p>
    @endforelse
    </div>
    </div>
  </div>
@endsection