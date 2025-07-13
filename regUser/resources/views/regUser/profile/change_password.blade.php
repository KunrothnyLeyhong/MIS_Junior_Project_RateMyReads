@extends('regUser.layouts.app')

@section('content')
<div id="app">
  <change-password></change-password>
</div>
@endsection

@push('scripts')
<script src="{{ mix('js/app.js') }}"></script>
@endpush
