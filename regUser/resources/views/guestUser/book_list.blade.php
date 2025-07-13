@extends('guestUser.layouts.app')

@section('content')
  <div class="min-h-screen text-gray-900 pb-20 pt-30">

    {{-- ---------- HERO ---------- --}}
    <section class="p-4 sm:p-6 md:p-10 bg-[#B5E2FF] rounded-xl m-4 sm:m-6
       flex flex-col md:flex-row justify-around items-center">
    <div class="max-w-md">
      <h2 class="text-2xl font-bold py-3">Build Your Library<br>With Us!</h2>
      <p class="text-sm">Browse the books that are listed and<br>uncover stories you'll love!</p>
    </div>
    <div class="flex my-15 -space-x-20">
      <img src="/img/bookList1.png" class="md:h-50 object-contain -rotate-12" alt="">
      <img src="/img/bookList2.png" class="md:h-50 object-contain rotate-45" alt="">
    </div>
    </section>

    {{-- ---------- FILTER / SEARCH FORM ---------- --}}
    <form id="filterForm" method="GET" action="{{ route('guest.books') }}">
    {{-- SEARCH BAR --}}
    <div class="flex justify-end px-4 py-10">
      <div class="relative w-2/4 max-w-sm">
      <input type="text" name="search" id="searchBox" placeholder="Search book by title, genre, author"
        value="{{ request('search') }}" autocomplete="off" class="pl-10 pr-3 py-3 rounded-xl shadow-xl text-md w-full bg-white
       border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#96DEFF]" />
      <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round"
          d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 103.5 3.5a7.5 7.5 0 0013.65 13.65z" />
        </svg>
      </div>
      </div>
    </div>

    <div class="max-w-6xl mx-auto flex justify-between items-start gap-10">
<div class="bg-[#C5EAFF] p-6 w-[20%] h-fit rounded-md shadow-md">
      <section class="text-left">
        <h2 class="text-lg font-semibold mb-6 text-center">Filter by Genre</h2>
        <div class="flex flex-col gap-4">

        <a href="{{ route('guest.books', ['search' => request('search')]) }}" class="genre-btn {{ request('genre') ? 'bg-white text-[#7A7A7A]' : 'bg-[#34495e] text-white' }}
     text-left px-4 py-2 rounded-md hover:bg-[#34495e] hover:text-white transition-all">
          All
        </a>

        @foreach ($genres as $genre)
        <a href="{{ route('guest.books', ['genre' => $genre, 'search' => request('search')]) }}" class="genre-btn {{ request('genre') === $genre ? 'bg-[#34495e] text-white' : 'bg-white text-[#7A7A7A]' }}
         text-left px-4 py-2 rounded-md hover:bg-[#34495e] hover:text-white transition-all">
          {{ $genre }}
        </a>

      @endforeach
        </div>
      </section>
      </div>

      {{-- ---------- BOOK GRID ---------- --}}
      <main class="w-3/4 bg-[#B5E2FF] rounded-xl p-4">
      @if ($books->count())
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($books as $book)
      <a href="{{ url('g_book/' . $book->id) }}"
      class="bg-white p-4 rounded-xl shadow hover:shadow-lg transition block">
      <img src="{{ $book->image }}" class="mb-2 h-48 w-full object-cover rounded" alt="">
      <h3 class="font-bold text-lg text-center">{{ $book->title }}</h3>
      <p class="text-sm text-gray-600 text-center">By {{ $book->author }}</p>
      <p class="text-sm text-gray-600 text-center">Genre: {{ $book->genre }}</p>
      </a>
      @endforeach
      </div>
    @else
      <p class="text-center py-10 text-gray-700">No books found.</p>
    @endif

      {{-- ---------- PAGINATION ---------- --}}
      @if ($books->lastPage() > 1)
      <div class="flex justify-center items-center mt-8 mb-10">
        {{-- Prev --}}
        <a href="{{ $books->previousPageUrl() }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-full
      hover:bg-[#1c4966] hover:text-white transition
      {{ $books->onFirstPage() ? 'opacity-50 cursor-not-allowed' : '' }}">
        &lt;
        </a>

        {{-- Numbers --}}
        @for ($page = 1; $page <= $books->lastPage(); $page++)
        <a href="{{ $books->url($page) }}" class="mx-2 px-4 py-2 text-sm rounded-full
      {{ $page == $books->currentPage()
      ? 'bg-[#346d98] text-white'
      : 'bg-gray-100 text-gray-700 hover:bg-[#1c4966] hover:text-white' }}">
        {{ $page }}
        </a>
      @endfor

        {{-- Next --}}
        <a href="{{ $books->nextPageUrl() }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-full
      hover:bg-[#1c4966] hover:text-white transition
      {{ $books->currentPage() == $books->lastPage() ? 'opacity-50 cursor-not-allowed' : '' }}">
        &gt;
        </a>
      </div>
    @endif
      </main>
    </div>
    </form>
  </div>
@endsection

@push('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('filterForm');
    const search = document.getElementById('searchBox');

    const debounce = (fn, ms = 300) => {
      let t;
      return (...args) => {
      clearTimeout(t);
      t = setTimeout(() => fn.apply(this, args), ms);
      };
    };

    search.addEventListener('input', debounce(() => {
      console.log('Search input changed, submitting form...');
      form.submit();
    }));

    form.querySelectorAll('input[type="checkbox"]').forEach(cb => {
      cb.addEventListener('change', () => {
      console.log(`Checkbox ${cb.value} changed to ${cb.checked}, submitting form...`);
      form.submit();
      });
    });
    });

  </script>
@endpush