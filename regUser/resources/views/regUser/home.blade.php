@extends('regUser.layouts.app')

@section('content')

  <div id="app">
    <div id="app">
    <home-page
        :user='@json($user)'
        :currently-reading='@json($currentlyReading)'
        :want-to-read='@json($wantToRead)'
        :read-books='@json($readBooks)'
        :recent-activity="{{ $recentActivity ?? 'null' }}"
        :average-rating="{{ $averageRating ?? 0 }}"
:recent-review="{{ $recentReview ?? 'null' }}"
        :profile-picture-url="'{{ $user->profile_picture ?? asset('img/default_picture.avif') }}'"

    ></home-page>
</div>
  </div>
@endsection