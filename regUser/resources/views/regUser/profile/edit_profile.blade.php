@extends('regUser.layouts.app')

@section('content')
<div id="app">
    <edit-profile :user="{{ json_encode($user) }}"></edit-profile>
</div>
@endsection
