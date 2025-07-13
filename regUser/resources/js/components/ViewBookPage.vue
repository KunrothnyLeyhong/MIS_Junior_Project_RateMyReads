<template>
  <div class="py-20 pt-36">
    <div class="min-h-screen bg-[#B5E2FF] px-4 py-8 rounded-xl">
      <div class="flex justify-end px-4 py-10">
        <input type="text" placeholder="Search book by title, genre, author"
          class="px-3 py-2 border-white rounded-lg shadow-lg text-sm w-1/4 max-w-sm bg-white" v-model="searchQuery"
          @input="searchBooks" />
      </div>
      <div class="max-w-7xl mx-auto">
        <div class="bg-white rounded-xl border-4 border-white overflow-hidden shadow-md mx-10">
          <h2 class="text-center py-7 text-lg">Listed Books</h2>
          <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-center">
              <thead class="bg-[#D9D9D9] text-black">
                <tr>
                  <th class="px-6 py-3 font-semibold">No</th>
                  <th class="px-6 py-3 font-semibold">Title</th>
                  <th class="px-6 py-3 font-semibold">Genre</th>
                  <th class="px-6 py-3 font-semibold">Author</th>
                  <th class="px-6 py-3 font-semibold">Published Date</th>
                  <th class="px-6 py-3 font-semibold">Action</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-300">
                <tr v-for="(book, index) in filteredBooks.data" :key="index">
                  <td class="px-6 py-4">{{ (filteredBooks.current_page - 1) * filteredBooks.per_page + index + 1 }}</td>
                  <td class="py-4">{{ book.title }}</td>
                  <td class="px-6 py-4">{{ book.genre }}</td>
                  <td class="px-6 py-4">{{ book.author }}</td>
                  <td class="px-6 py-4">{{ book.published_date }}</td>
                  <!-- just replace this one cell -->
<td
  class="px-6 py-4 flex items-center space-x-2 whitespace-nowrap"
>
  <a
    :href="`/books/${book.id}`"
    class="bg-[rgba(50,201,249,0.75)] hover:bg-blue-500 px-4 py-2 rounded-xl font-semibold text-sm"
  >
    Detail
  </a>

  <button
    @click="redirectToEdit(book.id)"
    class="bg-[rgba(18,208,18,0.75)] hover:bg-green-500 px-4 py-2 rounded-xl font-semibold text-sm"
  >
    Update
  </button>

  <button
    @click="deleteBook(book.id)"
    class="bg-[rgba(255,0,0,0.75)] hover:bg-red-500 px-4 py-2 rounded-xl font-semibold text-sm"
  >
    Delete
  </button>
</td>


                </tr>
              </tbody>
            </table>
          </div>

          <!-- Pagination Controls -->
          <div class="flex justify-between mt-8 mx-10 mb-10">
            <button @click="changePage(filteredBooks.current_page - 1)" :disabled="filteredBooks.current_page === 1"
              class="px-8 py-4 bg-[#45B6FE] hover:bg-blue-500 rounded-lg font-semibold text-center">
              Previous
            </button>
            <button @click="changePage(filteredBooks.current_page + 1)"
              :disabled="filteredBooks.current_page === filteredBooks.last_page"
              class="px-8 py-4 bg-[#45B6FE] hover:bg-blue-500 font-semibold rounded-lg">
              Next
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Delete Confirmation Modal -->
<div v-if="showDeleteModal"
     class="fixed inset-0 flex items-center justify-center z-50"
     style="background-color: rgba(108, 114, 118, 0.5) !important;">
       <div class="bg-[#B5E2FF] rounded-xl p-8 w-96 text-center shadow-xl">
    <div class="text-4xl mb-4">ℹ️</div>
    <p class="mb-6 font-semibold">Are you sure you want to delete <br>"{{ selectedBookTitle }}"?</p>
    <div class="flex justify-center gap-4">
      <button @click="showDeleteModal = false"
        class="bg-gray-300 hover:bg-gray-400 text-black font-bold py-2 px-4 rounded-xl">
        Cancel
      </button>
      <button @click="confirmDelete"
        class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-xl">
        Delete
      </button>
    </div>
  </div>
</div>

</template>

<script>
export default {
  props: ['initialBooks'], // Accept initialBooks as prop from Blade
  data() {
    return {
      filteredBooks: this.initialBooks, // Initialize with initial data
      searchQuery: '',
      showDeleteModal: false,
    selectedBookId: null,
    selectedBookTitle: '',
    };
  },
  mounted() {
    this.fetchBooks(); // Optional: Remove if you already passed initialBooks
  },
  methods: {
    redirectToEdit(id) {
      window.location.href = `/books/${id}/edit`;
    },
    async fetchBooks(page = 1) {
      try {
        const response = await axios.get(`/books?page=${page}&search=${this.searchQuery}`);
        this.filteredBooks = response.data;
      } catch (error) {
        console.error("Error fetching books:", error);
      }
    },
    searchBooks() {
      this.fetchBooks(1); // Reset to first page on new search
    },
    changePage(page) {
      if (page > 0 && page <= this.filteredBooks.last_page) {
        this.fetchBooks(page);
      }
    },
    async viewDetails(id) {
      this.$router.push({ name: 'book.show', params: { id } });
    },
    async editBook(id) {
      this.$router.push({ name: 'book.edit', params: { id } });
    },
    async deleteBook(id) {
  const book = this.filteredBooks.data.find(b => b.id === id);
  if (!book) return alert("Book not found.");

  this.selectedBookId = id;
  this.selectedBookTitle = book.title;
  this.showDeleteModal = true;
},

async confirmDelete() {
  try {
    const response = await axios.delete(`/books/${this.selectedBookId}`);
    alert(response.data.message);
    this.fetchBooks(this.filteredBooks.current_page);
  } catch (error) {
    alert("Failed to delete book.");
    console.error(error);
  } finally {
    this.showDeleteModal = false;
    this.selectedBookId = null;
    this.selectedBookTitle = '';
  }
},

  }
};
</script>
