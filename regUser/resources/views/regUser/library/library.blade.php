@extends('regUser.layouts.app')

@section('content')
    <div class="max-w-7xl p-4 mb-15 mx-10 pt-35">

        {{-- Hero Section --}}
        <section
            class="p-4 sm:p-6 md:p-10 bg-[#B5E2FF] rounded-xl mb-20 flex flex-col md:flex-row justify-around items-center">
            <div class="max-w-md">
                <h2 class="text-2xl font-bold py-3">Discover The Books<br>In Your Library</h2>
                <p class="text-sm">Your bookshelf awaits – see what<br>you’ve collected so far!</p>
            </div>
            <div class="flex my-15 md:my-0">
                <img src="/img/library.png" class="h-60 md:h-80 object-contain" alt="Library Image">
            </div>
        </section>

        <!-- {{-- Search Bar --}}
                <div class="mt-6 flex justify-end">
                    <div id="search-app" class="w-full sm:w-1/2">
                        <search-bar></search-bar>
                    </div>
                </div> -->

        @php
            $sections = [
                'current' => 'Current Read',
                'want' => 'Want to Read',
                'read' => 'Read',
            ];
            $sectionColors = [
                'current' => 'bg-[#B5E2FF]',    
                'want' => 'bg-[#96DEFF]',      
                'read' => 'bg-[#6FD7FF]',     
            ];
        @endphp

        @php
    $fullStar = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#FFD700" class="bi bi-star-fill" viewBox="0 0 16 16">
  <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
</svg>';
    $halfStar = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#FFD700" class="bi bi-star-half" viewBox="0 0 16 16">
  <path d="M5.354 5.119 7.538.792A.52.52 0 0 1 8 .5c.183 0 .366.097.465.292l2.184 4.327 4.898.696A.54.54 0 0 1 16 6.32a.55.55 0 0 1-.17.445l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256a.5.5 0 0 1-.146.05c-.342.06-.668-.254-.6-.642l.83-4.73L.173 6.765a.55.55 0 0 1-.172-.403.6.6 0 0 1 .085-.302.51.51 0 0 1 .37-.245zM8 12.027a.5.5 0 0 1 .232.056l3.686 1.894-.694-3.957a.56.56 0 0 1 .162-.505l2.907-2.77-4.052-.576a.53.53 0 0 1-.393-.288L8.001 2.223 8 2.226z"/>
</svg>';
    $emptyStar = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#FFD700" class="bi bi-star" viewBox="0 0 16 16">
  <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.56.56 0 0 0-.163-.505L1.71 6.745l4.052-.576a.53.53 0 0 0 .393-.288L8 2.223l1.847 3.658a.53.53 0 0 0 .393.288l4.052.575-2.906 2.77a.56.56 0 0 0-.163.506l.694 3.957-3.686-1.894a.5.5 0 0 0-.461 0z"/>
</svg>';

    function renderStars($rating, $fullStar, $halfStar, $emptyStar) {
    $stars = '';
    $fullStars = floor($rating);
    $fraction = $rating - $fullStars;

    // Round fraction to determine half or full star
    if ($fraction >= 0.75) {
        // Count this as a full star
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

@endphp


        @foreach($sections as $key => $title)
            <div class="mt-10">
                <h3 class="text-lg font-semibold mb-4">{{ $title }}</h3>
                <div class="{{ $sectionColors[$key] ?? 'bg-gray-200' }} px-10 py-6 rounded-xl">
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4">
                        @php
                            $filteredBooks = $books->filter(function ($book) use ($key) {
                                return strtolower($book->status) === strtolower($key);
                            })->take(5);
                        @endphp

                        @if($filteredBooks->isEmpty())
                            <p class="text-sm italic">No books in this category yet.</p>
                        @else
                            @foreach($filteredBooks as $book)
                                <a href="{{ route('books.detail', $book->id) }}" class="text-center bg-white p-4 rounded-lg shadow-md">
    <img src="{{ $book->image }}" alt="{{ $book->title }}" class="w-full mx-auto rounded">
    <h4 class="text-sm font-medium mt-2">{{ $book->title }}</h4>
    <p class="text-xs text-gray-500">By {{ $book->author }}</p>
    <div class="text-yellow-400 text-sm inline-flex space-x-0.5">
        @php
            $avgRating = $ratings->get($book->id, 0);
            echo renderStars($avgRating, $fullStar, $halfStar, $emptyStar);
        @endphp
    </div>
    <p class="text-xs text-gray-600 mt-1">{{ number_format($avgRating, 1) }}/5</p>
</a>

                            @endforeach
                        @endif
                    </div>
                    <div class="mt-2 text-right text-xs">
                        <a href="{{ route('library.status', $key) }}" class="text-blue-500 hover:underline">See more >></a>
                    </div>
                </div>
            </div>
        @endforeach



    </div>
@endsection