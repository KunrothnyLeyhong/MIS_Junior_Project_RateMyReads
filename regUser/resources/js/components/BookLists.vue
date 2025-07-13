<template>
  <div class="min-h-screen text-gray-900 pb-20 pt-30">
    <!-- Header Section -->
    <section
      class="p-4 sm:p-6 md:p-10 bg-[#B5E2FF] rounded-xl m-4 sm:m-6 flex flex-col md:flex-row justify-around items-center">
      <div class="max-w-md">
        <h2 class="text-2xl font-bold py-3">Build Your Library<br>With Us!</h2>
        <p class="text-sm">Browse the books that are listed and<br>uncover stories you'll love!</p>
      </div>
      <div class="flex my-15 -space-x-20">
        <img src="/img/bookList1.png" alt="Book Mockup 2" class="md:h-50 object-contain -rotate-12">
        <img src="/img/bookList2.png" alt="Book Mockup 1" class="md:h-50 object-contain rotate-45">
      </div>
    </section>

    <!-- Search Bar -->
    <div class="flex justify-end px-4 py-10">
      <div class="relative w-2/4 max-w-sm">
        <input type="text" placeholder="Search book by title, author"
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


    <div class="max-w-6xl mx-auto flex justify-between items-start gap-10">
      <!-- Filters -->
      <div class="w-3/4 md:w-1/4 bg-[#96DEFF] rounded-xl p-4 shadow">
        <h2 class="text-lg font-semibold mb-4 text-center">Filter by Genre</h2>
        <div v-for="genre in genres" :key="genre" class="mb-3">
          <label class="w-full">
            <span
              class="bg-white flex items-center justify-start gap-3 px-4 py-2 rounded-full w-full shadow-sm cursor-pointer">
              <input type="checkbox" :value="genre" v-model="selectedGenres" class="custom-checkbox appearance-none w-5 h-5 rounded cursor-pointer 
                bg-[#0000001A] border-[#7A7A7A] checked:bg-blue-500 checked:border-blue-500 border relative">
              <span class="text-sm font-medium text-gray-800">{{ genre }}</span>
            </span>
          </label>
        </div>
      </div>

      <!-- Book Listings -->
      <main class="w-3/4 bg-[#B5E2FF] rounded-xl p-4">
        <div v-if="books.length" class="grid grid-cols-3 gap-6">
          <a v-for="book in books" :key="book.id" :href="`/books/${book.id}`"
            class="bg-white p-4 rounded-xl shadow cursor-pointer hover:shadow-lg transition block">
            <img :src="book.image" alt="cover" class="mb-2 h-48 w-full object-cover rounded" />
            <h3 class="font-bold text-lg text-center">{{ book.title }}</h3>
            <p class="text-sm text-gray-600 text-center">By {{ book.author }}</p>
            <div class="flex items-center px-7 space-x-2 mt-2 ">
              <div class="flex items-center space-x-2" v-html="renderStars(book.averageRating)"></div>
              <span class="text-gray-700 font-semibold text-sm">
                {{ (book.averageRating ?? 0).toFixed(1) }}/5
              </span>
            </div>
          </a>
        </div>
        
        <div v-else class="text-center text-gray-600 py-5">
          <p class="text-lg">No books found.</p>
        </div>

        <!-- Pagination Controls -->
        <div v-if="totalPages > 1" class="flex justify-center items-center mt-8 mb-10">
          <!-- Previous Button -->
          <a @click.prevent="changePage(currentPage - 1)" href="#" :class="[
            'px-4 py-2 bg-gray-200 text-gray-800 rounded-full hover:bg-[#1c4966] hover:text-white transition',
            currentPage === 1 ? 'opacity-50 cursor-not-allowed' : ''
          ]">
            &lt;
          </a>

          <!-- Page Numbers -->
          <a v-for="page in totalPages" :key="page" @click.prevent="changePage(page)" href="#" :class="[
            'mx-2 px-4 py-2 text-sm rounded-full',
            currentPage === page
              ? 'bg-[#346d98] text-white'
              : 'bg-gray-100 text-gray-700 hover:bg-[#1c4966] hover:text-white'
          ]">
            {{ page }}
          </a>

          <!-- Next Button -->
          <a @click.prevent="changePage(currentPage + 1)" href="#" :class="[
            'px-4 py-2 bg-gray-200 text-gray-800 rounded-full hover:bg-[#1c4966] hover:text-white transition',
            currentPage === totalPages ? 'opacity-50 cursor-not-allowed' : ''
          ]">
            &gt;
          </a>
        </div>

      </main>

    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      searchQuery: '',
      selectedGenres: [],
      genres: ['Romance', 'Fiction', 'Non-fiction', 'Mystery', 'Fantasy', 'Sci-Fi', 'Historical', 'Thriller', 'Horror', 'Young Adult', "Children's", 'Biography/Memoir', 'Self-Help', 'Poetry', 'Graphic Novels', 'Others'],
      books: [],
      currentPage: 1,
      totalPages: 1,
      averageRating: Number,
    };
  },
  computed: {
    formattedAverageRating() {
      return typeof this.averageRating === 'number' ? this.averageRating.toFixed(1) : '0.0';
    }
  },
  mounted() {
    this.fetchBooks(); // initial load
  },
  watch: {
    searchQuery() {
      this.currentPage = 1;
      this.fetchBooks();
    },
    selectedGenres() {
      this.currentPage = 1;
      this.fetchBooks();
    },
    currentPage() {
      this.fetchBooks();
    }
  },
  methods: {
    renderStars(rating = 0) {
      const fullStar = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#FFD700" class="bi bi-star-fill" viewBox="0 0 16 16">\n<path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/></svg>';
      const halfStar = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#FFD700" class="bi bi-star-half" viewBox="0 0 16 16">\n<path d="M5.354 5.119 7.538.792A.52.52 0 0 1 8 .5c.183 0 .366.097.465.292l2.184 4.327 4.898.696A.54.54 0 0 1 16 6.32a.55.55 0 0 1-.17.445l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256a.5.5 0 0 1-.146.05c-.342.06-.668-.254-.6-.642l.83-4.73L.173 6.765a.55.55 0 0 1-.172-.403.6.6 0 0 1 .085-.302.51.51 0 0 1 .37-.245zM8 12.027a.5.5 0 0 1 .232.056l3.686 1.894-.694-3.957a.56.56 0 0 1 .162-.505l2.907-2.77-4.052-.576a.53.53 0 0 1-.393-.288L8.001 2.223 8 2.226z"/></svg>';
      const emptyStar = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#FFD700" class="bi bi-star" viewBox="0 0 16 16">\n<path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.56.56 0 0 0-.163-.505L1.71 6.745l4.052-.576a.53.53 0 0 0 .393-.288L8 2.223l1.847 3.658a.53.53 0 0 0 .393.288l4.052.575-2.906 2.77a.56.56 0 0 0-.163.506l.694 3.957-3.686-1.894a.5.5 0 0 0-.461 0z"/></svg>';

      let full = Math.floor(rating);
      let half = 0;
      const fraction = rating - full;

      if (fraction >= 0.75) {
        full++;
      } else if (fraction >= 0.25) {
        half = 1;
      }

      let stars = '';
      for (let i = 0; i < 5; i++) {
        if (i < full) {
          stars += fullStar;
        } else if (half === 1) {
          stars += halfStar;
          half = 0;
        } else {
          stars += emptyStar;
        }
      }
      return stars;
    },
    fetchBooks() {
      const genreParam = this.selectedGenres.join(',');
      const url = `/api/books?page=${this.currentPage}&search=${this.searchQuery}&genres=${genreParam}`;

      fetch(url)
        .then(res => res.json())
        .then(data => {
          this.books = data.data;             // books for current page
          this.totalPages = data.last_page;
          this.currentPage = data.current_page;
        })
        .catch(err => {
          console.error("Failed to fetch books:", err);
        });
    },
    changePage(page) {
      if (page >= 1 && page <= this.totalPages) {
        this.currentPage = page;
      }
    }
  }
};
</script>