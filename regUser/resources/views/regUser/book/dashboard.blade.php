@extends('regUser.layouts.app') <!-- assuming you have a layout -->

@section('content')
    <div id="app">
        <dashboard 
            :total-books="{{ $totalBooks }}" 
            :pending-books="{{ $pendingBooks }}"
            :approved-books="{{ $acceptedBooks }}">
        </dashboard>

        <!-- You can pass more data if needed, e.g., passing pendingBooks or acceptedBooks -->
    </div>
@endsection