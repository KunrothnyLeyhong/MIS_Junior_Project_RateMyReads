@extends('guestUser.layouts.app')

@section('content')

  <!-- Contact Section -->
  <main class="min-h-screen flex flex-col md:flex-row items-center justify-center px-5 space-y-10 md:space-y-0 md:space-x-20 w-full">
        <!-- Illustration -->
        <div class="w-full md:w-3/5">
            <img src="{{ asset('/img/contact_us.png') }}" alt="Contact Illustration" class="w-full max-w-4xl mx-auto -ml-10">
        </div>

    <!-- Form Right -->
    <div class="w-full max-w-md bg-[#B5E2FF] p-8 rounded-xl shadow-md">
      <h2 class="text-2xl font-bold text-center mb-6">CONTACT US</h2>
      <form method="POST" action="{{ route('contact.G_store') }}">
        @csrf
        <div class="flex justify-end gap-4">
        <input type="text" name="first_name" placeholder="first Name" required
          class="w-full p-3 rounded-full mb-4 border bg-white border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400">
        <input type="text" name="last_name" placeholder="Last Name" required
          class="w-full p-3 rounded-full mb-4 border bg-white border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>
        <input type="email" name="email" placeholder="Email" required
          class="w-full p-3 rounded-full mb-4 border  bg-white border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400">        
        <textarea name="message" placeholder="Type your message" rows="5" required
          class="w-full p-3 rounded-xl mb-4 border  bg-white border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400"></textarea>
        <button type="submit"
          class="w-full bg-[#45B6FE] text-black py-2 rounded-full hover:bg-blue-600 transition duration-200">
          Send
        </button>
        @if(session('success'))
      <div class="text-green-600 mb-4">
        {{ session('success') }}
      </div>
    @endif
      </form>
    </div>
</main>

@endsection