@extends('regUser.layouts.app')

@section('content')
<div id="app">
  <book-detail :book-id="{{ $book->id }}"></book-detail>
</div>
@endsection


@push('scripts')
<script src="{{ mix('js/app.js') }}"></script>
@endpush

