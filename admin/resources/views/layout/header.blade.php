<!-- <script src="https://cdn.tailwindcss.com"></script>
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script> -->

<div class="w-64 bg-white border-r flex flex-col">
  <div class="flex items-center justify-between p-4 border-b relative">
    <div class="flex items-center">
      @php
  $admin = Auth::guard('admin')->user();
  $photo = $admin && $admin->photo ? asset('storage/' . $admin->photo) : asset('img/default_picture.avif');
@endphp

<img 
  src="{{ $photo }}" 
  alt="Admin Photo" 
  class="w-10 h-10 rounded-full mr-2"
/>
        <p class="font-semibold">{{ Auth::guard('admin')->user()->firstname }} {{ Auth::guard('admin')->user()->lastname }}</p>
        <p class="text-sm text-gray-500">
    </div>

    <!-- Toggle Icon -->
    <button id="dropdownToggle" class="text-gray-500 hover:text-gray-800 focus:outline-none">
        <i class="fa-solid fa-caret-down"></i>
    </button>

    <!-- Dropdown -->
    <div id="dropdownMenu" class="hidden absolute right-4 top-16 w-40 bg-white border rounded shadow-lg z-10">
      <a href="/adminprofile/profile" class="block px-4 py-2 text-sm hover:bg-gray-100">
        <i class="fa-regular fa-user mr-2"></i> Profile
      </a>
      <a href="/adminprofile/password" class="block px-4 py-2 text-sm hover:bg-gray-100">
        <i class="fa-solid fa-key mr-2"></i> Password
      </a>
      <hr class="my-1">
      <a href="/" class="block px-4 py-2 text-sm hover:bg-gray-100 text-red-500">
        <i class="fa-solid fa-arrow-right-from-bracket mr-2"></i> Log out
      </a>
    </div>
  </div>
</div>

<script>
  const toggleBtn = document.getElementById("dropdownToggle");
  const dropdownMenu = document.getElementById("dropdownMenu");

  toggleBtn.addEventListener("click", () => {
    dropdownMenu.classList.toggle("hidden");
  });

  // Optional: Click outside to close
  document.addEventListener("click", (e) => {
    if (!toggleBtn.contains(e.target) && !dropdownMenu.contains(e.target)) {
      dropdownMenu.classList.add("hidden");
    }
  });
</script>
