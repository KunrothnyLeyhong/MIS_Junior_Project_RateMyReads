@extends('regUser.layouts.app')

@section('content')
<div class="min-h-screen flex flex-col justify-center items-center pt-15">

    <!-- Success Modal -->
    @if(session('success'))
    <div id="successModal" style="display:none;"
         class="fixed inset-0 flex items-center justify-center z-50 bg-[rgba(108,114,118,0.5)]">
      <div class="bg-[#B5E2FF] rounded-xl p-8 w-96 text-center shadow-xl">
        <div class="text-4xl mb-4">✅</div>
        <p class="mb-6 font-semibold text-[#45B6FE]">{{ session('success') }}</p>
        <button id="closeSuccessModal" 
                class="bg-[#45B6FE] hover:bg-[#45B6FE] text-white font-bold py-2 px-6 rounded-xl">
          Close
        </button>
      </div>
    </div>
    @endif

    <!-- Main Content -->
    <main class="flex flex-col md:flex-row items-center justify-center px-5 py-10 space-y-10 md:space-y-0 md:space-x-20 w-full">
        <!-- Illustration -->
        <div class="w-full md:w-3/5">
            <img src="{{ asset('/img/contact_us.png') }}" alt="Contact Illustration" class="w-full max-w-4xl mx-auto -ml-10">
        </div>

        <!-- Contact Form -->
        <div class="w-full md:w-3/5 bg-[#B5E2FF] p-10 rounded-xl shadow-md max-w-lg">
            <h2 class="text-center text-3xl font-bold mb-8">CONTACT US</h2>
            <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
                @csrf
                <div class="flex items-center justify-center space-x-2 mb-4">
                    <input type="text" name="first_name" placeholder="First Name" class="w-full px-6 py-4 rounded-3xl border border-white focus:outline-none shadow-xl focus:ring-2 bg-white text-lg">
                    <input type="text" name="last_name" placeholder="Last Name" class="w-full px-6 py-4 rounded-3xl border border-white focus:outline-none shadow-xl focus:ring-2 bg-white text-lg">
                </div>
                <input type="email" name="email" placeholder="Email" class="w-full px-6 py-4 rounded-3xl border border-white focus:outline-none shadow-xl focus:ring-2 bg-white text-lg">
                <textarea name="message" rows="5" placeholder="Type your message" class="w-full px-6 py-4 rounded-3xl border border-white focus:outline-none shadow-xl focus:ring-2 bg-white resize-none text-lg"></textarea>
                <button type="submit" class="bg-[#45B6FE] text-black px-8 py-4 rounded-full font-semibold hover:bg-blue-600 text-xl transition duration-300">
                    Send
                </button>
            </form>
        </div>
    </main>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('successModal');
    const closeBtn = document.getElementById('closeSuccessModal');

    if(modal) {
      // Show modal when page loads
      modal.style.display = 'flex';

      // Close modal on button click
      closeBtn.addEventListener('click', function() {
        modal.style.display = 'none';
      });

      // Optional: close modal when clicking outside the modal content
      modal.addEventListener('click', function(e) {
        if(e.target === modal) {
          modal.style.display = 'none';
        }
      });
    }
  });
</script>
@endsection
