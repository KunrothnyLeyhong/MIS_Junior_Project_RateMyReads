@extends('guestUser.layouts.app')

@section('content')

  <main class=" mx-[60px] py-20 pt-30">
    <!-- Hero Section -->
    <section class="flex justify-around gap-20 bg-[#B5E2FF] my-[40px] rounded-[20px] py-[40px] px-[60px] items-center">
    <div>
      <h1 class="text-[32px] mb-[10px] leading-[1.4] text-black font-bold">Welcome to <br><span
        class="text-black font-bold">RateMyReads</span>
      </h1>
      <p class="mb-[20px] text-black">Find out what your next read are<br>by browsing through our website!</p>
    </div>
    <div class="max-w-[400px]">
      <img src="{{ asset('img/regUser_homepage_picture.png') }}" alt="Hero Art">
    </div>
    </section>

    <!-- Genre Title -->
    <!-- <div class="flex justify-end items-center mt-[30px] mb-[20px]">

      <input class="p-[10px] rounded-[8px] border-1 border-[#ccc] border-solid w-[250px]" type="text"
      placeholder="Search Books by Genre" />
    </div> -->

    <!-- Genre Section -->
    <section class="my-[20px] w-full gap-[30px] overflow-hidden grid grid-cols-[60px_1fr] p-[30px] rounded-[15px]">
    <!-- Rotated Button -->
    <div class="flex items-center rounded-[15px] overflow-hidden justify-center">
      <button
      class="bg-[#B5E2FF] text-[20px] text-black px-[80px] font-bold py-[20px] rounded-[15px] transform -rotate-90 whitespace-nowrap">
      Browse by Genre
      </button>
    </div>

    <div class="grid grid-cols-2 grid-rows-2 gap-[20px] justify-center">
      <div
      class="flex items-center gap-[15px] p-[20px] rounded-[15px] text-black transition-transform duration-[200ms] transform hover:scale-102 shadow-genres-card bg-[#FFA7DC]">
      <img class="aspect-square h-[70px]  object-cover flex-shrink-0" src="{{ asset('img/romance-genre.png') }}"
        alt="Romance">
      <div class="flex flex-col">
        <h3 class="mb-[6px] text-[18px] font-semibold">Romance</h3>
        <p class="text-sm text-black">Explores the emotional journey of relationships, personal growth in love,
        and connection between
        individuals.</p>
      </div>
      </div>
      <div
      class="flex items-center gap-[15px] p-[20px] rounded-[15px] text-black transition-transform duration-[200ms] transform hover:scale-102 shadow-genres-card bg-[#76E97B]">
      <img class="aspect-square h-[70px]  object-cover flex-shrink-0" src="{{ asset('img/fantasy-genre.png') }}"
        alt="Fantasy">
      <div class="flex flex-col">
        <h3 class="mb-[6px] text-[18px] font-semibold">Fantasy</h3>
        <p class="text-sm text-black">Takes place in imaginative worlds, filled with magic, mystical creatures,
        and adventures beyond the
        ordinary.</p>
      </div>
      </div>
      <div
      class="flex items-center gap-[15px] p-[20px] rounded-[15px] text-black transition-transform duration-[200ms] transform hover:scale-102 shadow-genres-card bg-[#75B7FF]">
      <img class="aspect-square h-[70px]  object-cover flex-shrink-0" src="{{ asset('img/crime-genre.png') }}"
        alt="Crime">
      <div class="flex flex-col">
        <h3 class="mb-[6px] text-[18px] font-semibold">Non-Fiction</h3>
        <p class="text-sm text-blck">Explores real-life crimes, investigations, and the ethical dilemmas surrounding them, offering factual insights from multiple perspectives.</p>
      </div>
      </div>
      <div
      class="flex items-center gap-[15px] p-[20px] rounded-[15px] text-black transition-transform duration-[200ms] transform hover:scale-102 shadow-genres-card bg-[#FF6969]">
      <img class="aspect-square h-[70px]  object-cover flex-shrink-0" src="{{ asset('img/mystery-genre.png') }}"
        alt="Mystery">
      <div class="flex flex-col">
        <h3 class="mb-[6px] text-[18px] font-semibold">Mystery</h3>
        <p class="text-sm text-black">Builds suspense through hidden clues, investigations, and the gradual
        unravelment of secrets or
        solutions.</p>
      </div>
      </div>
    </div>

    </section>

    <section class="bg-[#B5E2FF] my-[40px] px-[40px] py-[40px] rounded-[15px]">
    <h2 class="mb-[40px] text-[24px] font-semibold">Top Rated Books of the Week</h2>

    <div class="grid grid-cols-5 gap-[40px] overflow-x-auto pb-[20px]">

      @foreach ($books as $book)
      <a href="{{ url('g_book/' . $book->id) }}">

      <div class="text-center flex-shrink-0">
      <img src="{{ $book->image ?? asset('img/default_picture.avif') }}" alt="{{ $book->title }}"
      class="w-50 h-50 object-cover rounded-[10px]" />
      <h3 class="text-[18px] mt-[10px] font-semibold">{{ $book->title }}</h3>
      <p class="text-[14px] text-black">By {{ $book->author }}</p>
      <p class="flex items-center text-[16px] font-semibold mt-[5px] px-12">
  <span>
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#FFD700" class="bi bi-star-fill" viewBox="0 0 16 16">
      <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
    </svg>
  </span>
  @if ($book->reviews->count() > 0)
    <span class="ml-1">{{ number_format($book->reviews->avg('rating'), 1) }} / 5</span>
  @else
    <span class="ml-1">0.0/5</span>
  @endif
</p>

      </div>
      </a>
    @endforeach

    </div>
    </section>

  </main>


@endsection