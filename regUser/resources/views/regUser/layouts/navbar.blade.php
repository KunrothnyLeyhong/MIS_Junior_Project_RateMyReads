
<div id="app">
  <navbar
    :user-name="'{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}'"
    :user-image='@json(Auth::user()->profile_picture ?? asset("img/default_picture.avif"))' />
  ></navbar>
</div>

