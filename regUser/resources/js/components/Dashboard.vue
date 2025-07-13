<template>
  <div class="pt-50 pb-10">
    <div class="flex flex-wrap gap-4 mb-6 justify-between items-center px-4 md:px-20">
      <h2 class="text-xl font-semibold mb-4">Summary Dashboard</h2>

      <div class="flex gap-4 mb-6">
        <a href="/books">
          <button class="bg-white px-7 py-2 border-2 border-[#B5E2FF] shadow-lg rounded-lg flex flex-col items-center">
            <span class="py-2"><img src="img/search_icon.webp" class="w-6"> </span>
            <span class="pb-2">View Books</span>
          </button>
        </a>
        <a href="/addBook">
          <button class="bg-white px-9 py-2 border-2 border-[#B5E2FF] shadow-lg rounded-lg flex flex-col items-center">
            <span class="py-2"><img src="img/plus_icon.webp" class="w-6"> </span>
            <span class="pb-2">Add Book</span>
          </button>
        </a>
      </div>
    </div>

    <!-- Cards Section -->
    <div class="bg-[#B5E2FF] p-6 md:p-10 rounded-lg grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-20">
      <div v-for="(card, index) in cards" :key="index" class="bg-white px-6 py-10 rounded-lg shadow text-center">
        <h3 class="font-bold mb-2">{{ card.title }}</h3>
        <p class="text-xl font-semibold">{{ card.value }}</p>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  props: {
    totalBooks: {
      type: Number,
      required: true
    },
    pendingBooks: {
      type: Number,
      required: true
    },
    approvedBooks: {
      type: Number,
      required: true
    }
  },
  data() {
    return {
      cards: [
        { title: 'Total Book', value: this.totalBooks },
        { title: 'Pending Book', value: this.pendingBooks },
        { title: 'Approved Book', value: this.approvedBooks },
        // You can add more cards dynamically if you pass more data from Blade
      ]
    };
  },
  methods: {
    async fetchData() {
      try {
        const response = await axios.get('/api/dashboard'); // Replace with your backend endpoint
        if (response.data) {
          this.cards = response.data.cards; // Assuming the backend returns the data in a 'cards' array
        }
      } catch (error) {
        console.error('Error fetching dashboard data:', error);
      }
    }
  },
  created() {
    this.fetchData(); // Fetch the data when the component is created
  }
};
</script>

<style scoped>
</style>
