@extends('guestUser.layouts.app')

@section('content')

  <main class="mx-[60px]">
    <!-- About Us Section -->
    <section class="max-w-6xl mx-auto px-4 py-12 pt-40">
    <div class="bg-[#B5E2FF] rounded-xl shadow-md p-8 w-full flex flex-col md:flex-row items-center gap-15">
      <img src="{{ asset('img/about.png') }}" alt="Reading illustration" class="w-2/5 max-w-full rounded-lg" />
      <div>
      <h2 class="text-2xl font-bold mb-4">ABOUT US</h2>
      <p class="text-base leading-relaxed">
        Welcome to RateMyReads – a community-driven platform for book lovers! Here, readers can discover honest
        reviews from fellow users, share their thoughts on the books they’ve read, and build their personal digital
        library. Registered users can also contribute by adding new books to the site, helping us grow a diverse and
        ever-expanding collection. Whether you’re looking for your next great read or want to connect with others
        who share your passion for books, you're in the right place.
      </p>
      </div>
    </div>
    </section>

    <!-- Team Section -->
    <section class="max-w-6xl mx-auto px-4 py-12">
    <div class="grid md:grid-cols-2 gap-8 mb-12">
      @php
      $teamMembers = [
        [ 
          'name' => 'KUNROTHNY LEYHONG', 
          'role' => 'Team Leader and Registered User Side Developer',
          'image' => asset('img/ny.JPG'),
        ],
        [ 
          'name' => 'SOSETHIKA KOU', 
          'role' => 'Administrator Side Developer and UI/UX Designer',
          'image' => asset('img/ka.JPG'),
        ],
        [
          'name' => 'SEAP LUN', 
          'role' => 'Guest User Side Developer',         
          'image' => asset('img/lun.jpg'),
        ],
        [
          'name' => 'SUNZANA SRENG', 
          'role' => 'Administrator Side Developer and UI/UX Designer',         
          'image' => asset('img/zana.JPG'),
        ],
      ];
      @endphp
      <!-- Team Members -->
      <div class="grid grid-cols-2 gap-6">
      @foreach ($teamMembers as $member)
      <div class="text-center">
      <img src="{{ asset($member['image']) }}" alt="{{ $member['name'] }}"
      class="w-36 h-40 mx-auto object-cover rounded-lg mb-3" />
      <h4 class="text-base font-bold">{{ $member['name'] }}</h4>
      <p class="text-sm text-gray-600">{{ $member['role'] }}</p>
      </div>
    @endforeach
      </div>

      <!-- Team Description -->
      <div>
      <h2 class="text-2xl font-bold mb-4">OUR TEAM</h2>
      <p class="text-base leading-loose my-6">
        Behind RateMyReads is a small but passionate team of book enthusiasts, tech lovers, and creative thinkers.
        We’re united by our love for storytelling and our mission to build a space where readers can connect, share,
        and discover amazing books. From designing user-friendly features to curating a welcoming community, our
        team works hard to make your reading experience engaging and enjoyable. Whether we’re coding, reviewing, or
        reading the next bestseller, we’re here to bring book lovers together.
      </p>
      </div>
    </div>
    </section>
  </main>

@endsection