<template>
  <div class="max-w-7xl p-4 mb-15 mx-10 pt-35">

    <!-- Hero Section -->
    <section
      class="p-4 sm:p-6 md:p-10 bg-[#B5E2FF] rounded-xl mb-20 flex flex-col md:flex-row justify-around items-center">
      <div class="max-w-md">
        <h2 class="text-2xl font-bold py-3">Discover The Books<br>In Your Library</h2>
        <p class="text-sm">{{ description }}</p>
      </div>
      <div class="flex my-15 md:my-0">
        <img src="/img/library.png" class="h-60 md:h-80 object-contain" alt="Library Image" />
      </div>
    </section>

    <!-- Search Input -->
    <section class="flex justify-end px-4 py-10">
      <div class="relative w-2/4 max-w-sm">
        <input v-model="searchQuery" @input="searchBooks" type="text" placeholder="Search by title or author..."
          class="border border-gray-300 pl-10 pr-4 py-2 rounded-full focus:outline-none focus:ring focus:border-blue-300 w-full max-w-sm" />
        <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
          <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 103.5 3.5a7.5 7.5 0 0013.65 13.65z" />
          </svg>
        </div>
      </div>
    </section>



    <div :class="bgColor + ' px-6 py-6 rounded-xl overflow-x-auto'">
      <table class="min-w-full table-auto bg-white shadow-md rounded-xl overflow-hidden">
        <thead class="bg-blue-100 text-blue-800">
          <tr class="text-left text-sm uppercase tracking-wider">
            <th class="px-4 py-3">Book</th>
            <th class="px-4 py-3">Author</th>
            <th class="px-4 py-3">Rating</th>
            <th class="px-4 py-3">Date Added</th>
            <th class="px-4 py-3">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 text-sm">
          <tr v-if="books.length === 0">
            <td colspan="6" class="text-center italic px-4 py-6 text-gray-500">
              No books in this category yet.
            </td>
          </tr>
          <tr v-for="library in books" :key="library.book.id" class="hover:bg-gray-50 transition">
            <td class="px-4 py-3">
              <div class="flex items-center space-x-3">
                <img :src="library.book.image" :alt="library.book.title" class="w-30 object-cover rounded shadow-sm" />
                <span class="font-medium text-gray-900">{{ library.book.title }}</span>
              </div>
            </td>

            <td class="px-4 py-3 text-gray-600">{{ library.book.author }}</td>

            <td class="px-4 py-3 text-gray-600">
              <div class="flex items-center space-x-2">
                <span class="flex" v-html="getStars(parseFloat(library.avg_rating || 0))"></span>
                <span class="text-gray-700 font-semibold text-sm">
                  {{ parseFloat(library.avg_rating || 0).toFixed(1) }}/5
                </span>
              </div>
            </td>





            <td class="px-4 py-3 text-gray-500">
              {{ new Date(library.created_at).toLocaleDateString() }}
            </td>

            <td class="px-4 py-3 text-gray-600">
              <div class="flex items-center space-x-2 whitespace-nowrap">
                <a :href="`/books/${library.book.id}`"
                  class="bg-[rgba(50,201,249,0.75)] hover:bg-[#3792cb] px-4 py-2 rounded-xl font-semibold text-sm">
                  Detail
                </a>
                <button @click="openStatusModal(library.book.id, $event)"
                  class="bg-[rgba(50,201,249,0.75)] hover:bg-[#3792cb] px-4 py-2 rounded-xl font-semibold text-sm ml-2">
                  Edit Status
                </button>
              </div>
            </td>

          </tr>
        </tbody>
      </table>
    </div>
    <!-- Back Button -->
    <div class="mt-8 text-center">
      <a :href="backUrl"
        class="inline-block bg-[#B5E2FF] text-black px-6 py-2 rounded-full shadow hover:bg-[#65D5FF] transition">
        ← Back to Library Overview
      </a>
    </div>
  </div>

  <!-- Edit Status Dropdown Modal -->
  <div v-if="showStatusModal"
    class="absolute z-50 bg-white shadow-lg rounded-lg p-4 w-48 space-y-2 border border-[#96DEFF]"
    :style="{ top: `${dropdownPosition.top}px`, left: `${dropdownPosition.left}px` }">
    <button @click="updateStatus('current')"
      class="w-full text-left px-3 py-2 rounded-md hover:bg-[#B5E2FF] transition">
      Current Read
    </button>
    <button @click="updateStatus('want')" class="w-full text-left px-3 py-2 rounded-md hover:bg-[#B5E2FF] transition">
      Want to Read
    </button>
    <button @click="updateStatus('read')" class="w-full text-left px-3 py-2 rounded-md hover:bg-[#B5E2FF] transition">
      Read
    </button>
  </div>

</template>


<script>
export default {
  props: {
    status: String,
    initialBooks: Array,
    backUrl: {
      type: String,
      required: true,
    },
  },
  data() {
    return {
      searchQuery: '',
      books: this.initialBooks || [],
      showStatusModal: false,
      selectedBookId: null,
      bgColors: {
        current: 'bg-[#B5E2FF]',
        want: 'bg-[#96DEFF]',
        read: 'bg-[#6FD7FF]',
      },
      titles: {
        current: 'Current Reads',
        want: 'Want to Read',
        read: 'Read',
      },
      descriptions: {
        current: 'Find Out What Your Current Reads Are!',
        want: 'Discover the Books You Want to Read!',
        read: 'Find Out Which Books You Have Already Read!',
      },
      dropdownPosition: {
        top: 0,
        left: 0,
      },
    };
  },
  computed: {
    bgColor() {
      return this.bgColors[this.status] || 'bg-gray-300';
    },
    title() {
      return this.titles[this.status] || 'Library';
    },
    description() {
      return this.descriptions[this.status] || '';
    },
  },
  methods: {
    openStatusModal(bookId, event) {
      this.selectedBookId = bookId;
      this.showStatusModal = true;

      const rect = event.target.getBoundingClientRect();
      this.dropdownPosition = {
        top: rect.bottom + window.scrollY + 5,
        left: rect.left + window.scrollX,
      };
    },
    closeStatusModal() {
      this.showStatusModal = false;
      this.selectedBookId = null;
    },
    updateStatus(status) {
      if (!this.selectedBookId) return;

      fetch(`/library/update-status`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Laravel only
        },
        body: JSON.stringify({
          book_id: this.selectedBookId,
          status: status
        })
      })
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            // Option 1: Refetch books from server (recommended for accuracy)
            this.searchBooks();
            // Option 2 (Optional): Manually remove the book from current list
            this.books = this.books.filter(library => library.book.id !== this.selectedBookId);
          } else {
            alert('Failed to update status');
          }
          this.closeStatusModal();
        })
        .catch(err => {
          console.error('Error updating status:', err);
          this.closeStatusModal();
        });
    },
    searchBooks() {
      if (!this.searchQuery.trim()) {
        this.books = this.initialBooks;
        return;
      }

      fetch(`/library/search-live?q=${encodeURIComponent(this.searchQuery)}&status=${encodeURIComponent(this.status)}`)
        .then((res) => res.json())
        .then((data) => {
          if (Array.isArray(data)) {
            this.books = data;
          } else {
            this.books = [];
          }
        })
        .catch(() => {
          this.books = [];
        });
    },

    getStars(rating) {
      const fullStar = `
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#FFD700" class="bi bi-star-fill" viewBox="0 0 16 16">
  <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
</svg>`;

      const halfStar = `
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#FFD700" class="bi bi-star-half" viewBox="0 0 16 16">
  <path d="M5.354 5.119 7.538.792A.52.52 0 0 1 8 .5c.183 0 .366.097.465.292l2.184 4.327 4.898.696A.54.54 0 0 1 16 6.32a.55.55 0 0 1-.17.445l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256a.5.5 0 0 1-.146.05c-.342.06-.668-.254-.6-.642l.83-4.73L.173 6.765a.55.55 0 0 1-.172-.403.6.6 0 0 1 .085-.302.51.51 0 0 1 .37-.245zM8 12.027a.5.5 0 0 1 .232.056l3.686 1.894-.694-3.957a.56.56 0 0 1 .162-.505l2.907-2.77-4.052-.576a.53.53 0 0 1-.393-.288L8.001 2.223 8 2.226z"/>
</svg>`;

      const emptyStar = `
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#FFD700" class="bi bi-star" viewBox="0 0 16 16">
  <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.56.56 0 0 0-.163-.505L1.71 6.745l4.052-.576a.53.53 0 0 0 .393-.288L8 2.223l1.847 3.658a.53.53 0 0 0 .393.288l4.052.575-2.906 2.77a.56.56 0 0 0-.163.506l.694 3.957-3.686-1.894a.5.5 0 0 0-.461 0z"/>
</svg>`;

      const stars = [];
      const full = Math.floor(rating);
      const hasHalf = rating % 1 >= 0.25 && rating % 1 < 0.75;

      for (let i = 0; i < 5; i++) {
        if (i < full) {
          stars.push(fullStar);
        } else if (i === full && hasHalf) {
          stars.push(halfStar);
        } else {
          stars.push(emptyStar);
        }
      }

      return stars.join('');
    }
  }

};
</script>