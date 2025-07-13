@extends('regUser.layouts.app')

@section('content')
<div id="app">
    <!-- This div is where your Vue component will mount -->
    <view-book-page :initial-books="{{ json_encode($books) }}"></view-book-page>
</div>
@endsection

@push('scripts')
    <script src="{{ mix('js/app.js') }}"></script>  <!-- Ensure Vue.js is bundled correctly -->
@endpush
