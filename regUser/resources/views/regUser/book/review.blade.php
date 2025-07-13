@extends('regUser.layouts.app')

@section('content')
<div class=" bg-white pb-15 pt-30">

    <div class="text-center text-3xl font-bold mt-8">BOOK REVIEW</div>

    <div class="max-w-3xl mx-auto bg-[#B5E2FF] px-10 py-15 my-10 rounded-xl">
        <div class="flex space-x-8">
            {{-- Left: Book Image --}}
            <img src="{{ $book->image }}" alt="{{ $book->title }}" class="w-1/3 h-1/3 shadow-md rounded-xl">
            {{-- Right: Title, Author and Star Rating (Vue) --}}
            <div class="flex-1">
                <h2 class="text-xl font-semibold">{{ $book->title }}</h2>
                <a href="#" class="text-[#0890F4] hover:underline block mb-2">By {{ $book->author }}</a>

                {{-- Vue component: only star rating and comment box --}}
                <div id="review-app">
                    <review-form :book-id="{{ $book->id }}"></review-form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ mix('js/app.js') }}"></script>
@endpush