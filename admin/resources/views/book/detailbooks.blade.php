@extends('layout.master')
@section('content')
    <title>Book Details</title>

    <script src="https://cdn.tailwindcss.com"></script>

    @php
        // Define star SVG icons as in your second template
        $fullStar = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#FFD700" class="bi bi-star-fill" viewBox="0 0 16 16">
              <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
            </svg>';
        $halfStar = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#FFD700" class="bi bi-star-half" viewBox="0 0 16 16">
              <path d="M5.354 5.119 7.538.792A.52.52 0 0 1 8 .5c.183 0 .366.097.465.292l2.184 4.327 4.898.696A.54.54 0 0 1 16 6.32a.55.55 0 0 1-.17.445l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256a.5.5 0 0 1-.146.05c-.342.06-.668-.254-.6-.642l.83-4.73L.173 6.765a.55.55 0 0 1-.172-.403.6.6 0 0 1 .085-.302.51.51 0 0 1 .37-.245zM8 12.027a.5.5 0 0 1 .232.056l3.686 1.894-.694-3.957a.56.56 0 0 1 .162-.505l2.907-2.77-4.052-.576a.53.53 0 0 1-.393-.288L8.001 2.223 8 2.226z"/>
            </svg>';
        $emptyStar = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#FFD700" class="bi bi-star" viewBox="0 0 16 16">
              <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.56.56 0 0 0-.163-.505L1.71 6.745l4.052-.576a.53.53 0 0 0 .393-.288L8 2.223l1.847 3.658a.53.53 0 0 0 .393.288l4.052.575-2.906 2.77a.56.56 0 0 0-.163.506l.694 3.957-3.686-1.894a.5.5 0 0 0-.461 0z"/>
            </svg>';

        function renderStars($rating, $fullStar, $halfStar, $emptyStar)
        {
            $stars = '';
            $fullStars = floor($rating);
            $fraction = $rating - $fullStars;

            if ($fraction >= 0.75) {
                $fullStars += 1;
                $halfStarFlag = false;
            } elseif ($fraction >= 0.25) {
                $halfStarFlag = true;
            } else {
                $halfStarFlag = false;
            }

            for ($i = 1; $i <= 5; $i++) {
                if ($i <= $fullStars) {
                    $stars .= $fullStar;
                } elseif ($i == $fullStars + 1 && $halfStarFlag) {
                    $stars .= $halfStar;
                } else {
                    $stars .= $emptyStar;
                }
            }
            return $stars;
        }

        $avgRating = $book->rating ?? 0;
    @endphp

    <div class="p-8 flex-1 bg-[#CFE8FF] min-h-screen px-4">
        <div class="max-w-5xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="md:flex">
                {{-- Clickable Cover Image Upload --}}
                <div class="md:w-1/3 bg-gray-100 p-6 flex items-center justify-center">
                    <form action="{{ route('book.uploadCover', $book->id) }}" method="POST" enctype="multipart/form-data"
                        id="coverForm">
                        @csrf
                        @method('PUT')
                        <input type="file" name="image" id="coverInput" class="hidden"
                            onchange="document.getElementById('coverForm').submit()" required>
                        <label for="coverInput" class="cursor-pointer group relative">
                            <img src="{{ $book->image }}" alt="{{ $book->title }}"
                                class="rounded-lg shadow-md w-full h-auto object-cover transition-transform duration-300 group-hover:scale-105 group-hover:opacity-80">
                            <div
                                class="absolute bottom-2 right-2 bg-black bg-opacity-50 text-white text-xs px-2 py-1 rounded hidden group-hover:block">
                                Click to Change
                            </div>
                        </label>
                    </form>
                </div>

                {{-- Book Info --}}
                <div class="md:w-2/3 p-8">
                    <h2 class="text-4xl font-extrabold mb-2 text-gray-800">{{ $book->title }}</h2>
                    <p class="text-lg text-gray-600 mb-4">By <span class="font-medium">{{ $book->author }}</span></p>

                    {{-- Rating --}}
                    <div class="grid grid-cols-3 gap-3 items-center mb-4">
                        <div class="flex items-center gap-3">
                            <div class="text-yellow-400 flex col-span-1">
                                {!! renderStars($avgRating, $fullStar, $halfStar, $emptyStar) !!}
                            </div>
                            <span
                                class="text-xl font-semibold text-gray-800 col-span-1">{{ number_format($avgRating, 1) }}/5</span>
                        </div>

                        <div class="text-sm text-blue-600 hover:underline col-span-1">
                            {{ $reviewsAndRatingsCount }} Reviews and Ratings
                        </div>
                    </div>



                    {{-- Description --}}
                    <p class="text-gray-700 mb-6 leading-relaxed whitespace-pre-line">{{ $book->description }}</p>

                    {{-- Book Metadata --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-2 text-sm text-gray-800">
                        <p><span class="font-semibold">Genre:</span> {{ $book->genre }}</p>
                        <p><span class="font-semibold">Publish Date:</span> {{ $book->published_date }}</p>
                        <p><span class="font-semibold">Hardcover:</span> {{ $book->pages }} pages</p>
                        <p><span class="font-semibold">User Reviews:</span> {{ number_format($avgRating, 1) }} out of 5
                            Stars</p>
                    </div>

                    {{-- Back Button --}}
                    <div class="mt-8">
                        <a href="{{ route('book.listbooks') }}"
                            class="inline-block px-5 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow hover:bg-blue-700 transition">
                            ← Back to All Books
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection