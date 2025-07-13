@extends('regUser.layouts.app')

@section('content')
<div id="app">
<library-status
  status="{{ $status }}"
  :initial-books='@json($initialBooks)'
    back-url="/library"

></library-status>

</div>

<!-- <script src="{{ mix('js/app.js') }}"></script> -->

@endsection
