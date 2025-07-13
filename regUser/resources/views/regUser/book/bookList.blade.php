@extends('regUser.layouts.app')

@section('content')
<div id="app">
    <book-lists></book-lists>
</div>
@endsection

@push('scripts')
<script src="{{ mix('js/app.js') }}"></script>
@endpush
