<template>
  <nav class="fixed top-0 left-0 w-full z-50 bg-white shadow-md">
    <div class="max-w-7xl mx-auto px-4 py-6 flex justify-between items-center">
      <!-- Logo -->
      <div class="text-2xl font-extrabold text-black"><a href="/home">RateMyReads</a></div>

      <!-- Hamburger Icon (Mobile only) -->
      <button class="md:hidden text-black focus:outline-none" @click="mobileMenuOpen = !mobileMenuOpen">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>

      <!-- Desktop Links -->
      <ul class="hidden md:flex space-x-10 text-black text-sm font-semibold">
        <li><a href="/home" class="hover:text-blue-500">Home</a></li>
        <li><a href="/book">Book List</a></li>
        <li><a href="/library">Library</a></li>
        <li><a href="/dashboard">Book Entry</a></li>
        <li><a href="/contact_us">Contact Us</a></li>
      </ul>

      <!-- Profile Section (Desktop) -->
      <div class="relative hidden md:flex items-center gap-2">
        <span class="font-medium text-sm text-black pr-2">{{ userName }}</span>
        <img :src="profileImage" alt="Profile" class="w-8 h-10 rounded-full object-cover  cursor-pointer" @click="toggleDropdown" />
        <input type="file" ref="fileInput" class="hidden" @change="handleImageUpload" />
        <div v-show="dropdownVisible" class="absolute top-full right-0 mt-2 w-40 bg-white border shadow-md py-2 z-50">
          <a href="/profile" class="block px-4 py-2 hover:bg-gray-100">Profile Details</a>
          <a href="#" class="block px-4 py-2 hover:bg-gray-100" @click.prevent="logout">Log Out</a>
        </div>
      </div>
    </div>
  </nav>

  <!-- Mobile Menu -->
  <div v-show="mobileMenuOpen" class="md:hidden px-4 pb-4 space-y-3 text-black text-sm font-semibold">
    <a href="/home" class="block hover:text-blue-500">Home</a>
    <a href="#" class="block">Book List</a>
    <a href="#" class="block">Library</a>
    <a href="/dashboard" class="block">Book Entry</a>
    <a href="/contact_us" class="block">Contact Us</a>

    <!-- Mobile Profile -->
    <div class="border-t pt-3 mt-3 flex items-center justify-between">
      <div class="text-gray-700 text-sm">{{ userName }}</div>
      <div class="relative">
        <img :src="profileImage" alt="Profile" class="w-10 h-10 rounded-full cursor-pointer" @click="toggleDropdown" />
        <input type="file" ref="fileInput" class="hidden" @change="handleImageUpload" />
        <div v-show="dropdownVisible" class="absolute right-0 mt-2 w-40 bg-white border shadow-md py-2 z-50">
          <a href="/profile" class="block px-4 py-2 hover:bg-gray-100">Profile Details</a>
          <a href="#" class="block px-4 py-2 hover:bg-gray-100" @click.prevent="logout">Log Out</a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    userName: String,
    userImage: String,
  },
  data() {
    return {
      profileImage: this.userImage || "/img/default_picture.avif",
      dropdownVisible: false,
      mobileMenuOpen: false,
    };
  },
  watch: {
    userImage(newVal) {
      this.profileImage = newVal || "/img/default_picture.avif";
    }
  },
  methods: {
    toggleDropdown(event) {
      event.stopPropagation();
      this.dropdownVisible = !this.dropdownVisible;
    },
    openFileInput(event) {
      event.stopPropagation();
      this.$refs.fileInput.click();
    },
    handleImageUpload(event) {
      const file = event.target.files[0];
      if (file) {
        this.profileImage = URL.createObjectURL(file);
      }
    },
    async logout() {
      try {
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const response = await fetch('/logout', {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': token,
            'Content-Type': 'application/json',
          },
        });

        if (response.ok) {
          window.location.href = '/login';
        } else {
          console.error('Logout failed:', await response.text());
        }
      } catch (err) {
        console.error('Logout error:', err);
      }
    },
  },
};
</script>