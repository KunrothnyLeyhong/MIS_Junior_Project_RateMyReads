<!-- resources/views/regUser/updateBook.blade.php -->
@extends('regUser.layouts.app')

@section('content')
    <div id="app">
        <update-book-form :book-data="{{ json_encode($book) }}" :book-id="{{ $book->id }}"></update-book-form>
    </div>
@endsection
