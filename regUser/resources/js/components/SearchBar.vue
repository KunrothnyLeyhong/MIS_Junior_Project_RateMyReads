<template>
  <!-- Search Bar -->
    <div class="flex justify-end px-4 py-10">
      <div class="relative w-3/4 max-w-sm">
        <input type="text" placeholder="Search book by title, genre, author"
          class="pl-10 pr-3 py-3 rounded-xl shadow-xl text-md w-full bg-white border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#96DEFF]"
          v-model="searchQuery" />
        <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
          <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 103.5 3.5a7.5 7.5 0 0013.65 13.65z" />
          </svg>
        </div>
      </div>
    </div>
</template>

<script>
export default {
  data() {
    return {
      searchQuery: '',
    };
  },
  methods: {
    emitSearch() {
      this.$emit('search', this.searchQuery);
    },
  },
};
</script>
