@extends('regUser.layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto mt-40 mb-30">
        <!-- Header -->
        <div class="flex items-center justify-between space-x-6 px-20 py-6">
            <!-- Profile Picture -->
            <img src="{{ $user->profile_picture ?? asset('img/default_picture.avif') }}" alt="User Image"
                class="w-40 h-40 rounded-full object-cover" />

            <!-- Name & Info -->
            <div class="flex-1 px-10">
                <h2 class="text-2xl font-bold pb-3">{{ $user->first_name }} {{ $user->last_name }}</h2>
                <div class="flex space-x-4 text-sm text-black">
                    <p class="font-semibold">Activity</p>
                    <p>Joined {{ $user->created_at->format('F jS, Y') }}</p>
                </div>
            </div>

            <!-- Edit Links -->
            <div class="text-sm text-[#45B6FE] space-x-4">
                <a href="{{ url('profile/edit') }}" class="hover:underline">(edit profile)</a>
                <a href="{{ url('change_password') }}" class="hover:underline">(change password)</a>
            </div>
        </div>

        <!-- Library Status -->
        <h2 class="font-bold text-lg mb-3 mt-13">{{ strtoupper($user->first_name) }}’S LIBRARY</h2>
        <div class="grid grid-cols-3 gap-4 text-center border-t pt-7">
            <div>Currently Reading ({{ $currentlyReadingCount }})</div>
            <div>Want to Read ({{ $wantToReadCount }})</div>
            <div>Read ({{ $readCount }})</div>
        </div>

        <!-- Recent Library Activity -->
        <div class="mt-20">
            <h2 class="font-bold text-lg">{{ strtoupper($user->first_name) }}’S RECENT LIBRARY ACTIVITY</h2>

            @if ($recentActivity)
                <div class="space-y-6 py-5">
                    <div class="bg-[#B5E2FF] p-4 rounded-xl">
                        <p class="text-md mb-2 px-4 sm:px-8 md:px-20 py-3">
                            {{ $user->first_name }} added a book to
                            @php
                                $validStatuses = ['current', 'want', 'read'];
                            @endphp

                            @if(in_array($recentActivity->status, $validStatuses))
                                <a href="{{ route('library.status', $recentActivity->status) }}" class="text-[#0890F4] underline">
                                    {{ ucwords(str_replace('_', ' ', $recentActivity->status)) }}
                                </a>
                            @else
                                <span class="text-gray-500">
                                    {{ ucwords(str_replace('_', ' ', $recentActivity->status)) }}
                                </span>
                            @endif

                        </p>

                        <div class="flex flex-col lg:flex-row justify-between items-center gap-6 px-20 py-5">
                            <!-- Book Info -->
                            <div class="flex items-center gap-13">
                                <img src="{{ $recentActivity->book->image }}" class="h-40 object-cover rounded"
                                    alt="{{ $recentActivity->book->title ?? 'Book Image' }}" />
                                <div>
                                    <p class="font-semibold">{{ $recentActivity->book->title ?? 'Unknown Title' }}</p>
                                    <p class="text-sm">By {{ $recentActivity->book->author ?? 'Unknown Author' }}</p>

                                    @php
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
                                    <div class="flex items-center space-x-2">
                                        {!! renderStars($averageRating ?? 0) !!}
                                        <span class="text-gray-700 font-semibold text-sm">
                                            {{ number_format($averageRating ?? 0, 1) }}/5
                                        </span>
                                    </div>




                                </div>
                            </div>

                            <!-- Review Link -->
                            <div class="px-20">
                                <p class="text-sm font-medium mb-2">Rate this Book</p>
                                <a href="{{ url('/books/' . $recentActivity->book->id . '/write-review') }}"
                                    class="text-lg text-[#0890F4] underline hover:text-blue-700">
                                    Write a Review
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <p>No recent activity found.</p>
            @endif
        </div>

        <!-- Reviewed Books -->
        <div class="mt-10">
            <h2 class="font-bold text-lg mb-4">{{ strtoupper($user->first_name) }}’S BOOKS REVIEWED</h2>
            <div id="reviewedBooksGrid" class="grid grid-cols-5 gap-4 border-t pt-10">
                @foreach ($reviewedBooks as $index => $book)
                    <div class="text-center pr-5 reviewed-book-item" style="{{ $index >= 5 ? 'display:none;' : '' }}">
                        <img src="{{ $book['image']}}" class="w-full object-cover rounded shadow" alt="{{ $book['title'] }}">
                        <p class="mt-2 font-semibold text-sm">{{ $book['title'] }}</p>
                        <p class="text-xs text-gray-500">By {{ $book['author'] }}</p>


                        <div class="flex justify-center mt-1">
                            @php
                                $rating = round($book['rating'] ?? 0);
                            @endphp
                            <span class="text-gray-700 font-semibold text-sm pr-2">
                                {{ number_format($book['rating'] ?? 0, 1) }}/5
                            </span>
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= $rating)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-yellow-400" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.957a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.37 2.455a1 1 0 00-.364 1.118l1.286 3.957c.3.921-.755 1.688-1.54 1.118l-3.37-2.455a1 1 0 00-1.175 0l-3.37 2.455c-.784.57-1.838-.197-1.54-1.118l1.286-3.957a1 1 0 00-.364-1.118L2.063 9.384c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69l1.286-3.957z" />
                                    </svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-300" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.957a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.37 2.455a1 1 0 00-.364 1.118l1.286 3.957c.3.921-.755 1.688-1.54 1.118l-3.37-2.455a1 1 0 00-1.175 0l-3.37 2.455c-.784.57-1.838-.197-1.54-1.118l1.286-3.957a1 1 0 00-.364-1.118L2.063 9.384c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69l1.286-3.957z" />
                                    </svg>
                                @endif
                            @endfor
                        </div>
                    </div>
                @endforeach
            </div>
            @if(count($reviewedBooks) > 5)
                <p id="toggleShowText" class="mt-6 text-[#45B6FE] underline cursor-pointer select-none">Show More</p>
            @endif
        </div>


    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleText = document.getElementById('toggleShowText');
        const books = document.querySelectorAll('.reviewed-book-item');
        const initialVisible = 5;

        if (!toggleText) return;  // No toggle if less than or equal 5 books

        toggleText.addEventListener('click', function () {
            const isShowingAll = toggleText.textContent === 'Hide';

            if (isShowingAll) {
                // Hide extra books, show only initialVisible
                books.forEach((book, idx) => {
                    book.style.display = idx < initialVisible ? 'block' : 'none';
                });
                toggleText.textContent = 'Show More';
            } else {
                // Show all books
                books.forEach(book => {
                    book.style.display = 'block';
                });
                toggleText.textContent = 'Hide';
            }
        });
    });
</script>