<template>
  <div class="container mx-auto px-6 py-10 pt-36" v-if="book">
    <!-- Book Overview -->
    <div class="flex flex-col md:flex-row gap-8">
      <div>
        <img :src="book.image" alt="Book Image" class="w-full md:w-64 h-auto object-cover rounded-xl shadow-md" />

        <!-- Dropdown -->
        <div class="relative inline-block text-left ml-7.5 mt-5">
          <div class="flex">
            <button @click="toggleDropdown"
              class="rounded-l-full w-40 rounded-r-none px-4 py-2 bg-[#B5E2FF] text-black border border-black hover:bg-[#45B6FE]">
              Add to Library
            </button>
            <button @click="toggleDropdown"
              class="rounded-r-full px-2 bg-[#B5E2FF] border-t border-b border-r border-black hover:bg-[#45B6FE]">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#45B6FE"
                class="bi bi-caret-down-fill" viewBox="0 0 16 16">
                <path
                  d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z" />
              </svg>
            </button>
          </div>
          <div v-if="isOpen"
            class="absolute right-0 mt-2 w-40 bg-white border border-[#45B6FE] rounded-lg shadow-lg z-10">
            <ul>
              <li v-for="option in options" :key="option.value" @click="selectOption(option.value)"
                class="px-4 py-2 hover:bg-[#45B6FE] cursor-pointer text-gray-700">
                {{ option.label }}
              </li>
            </ul>
          </div>
        </div>
      </div>

      <div class="flex-1 space-y-4">
        <h1 class="text-3xl font-bold leading-tight">{{ book.title }}</h1>
        <p class="text-lg text-[#0890F4] font-medium">By {{ book.author }}</p>

        <!-- Average Rating -->
        <div class="flex items-center gap-5 mb-4">
          <div class="flex items-center gap-2 mb-2">
            <p class="text-lg font-semibold text-black">{{ averageRating.toFixed(1) }} / 5</p>
            <div class="flex items-center gap-1 text-yellow-400" v-html="renderStars(averageRating)"></div>
          </div>
          <div class="text-sm text-[#0890F4] underline mb-2">{{ reviews.length }} Ratings & Reviews</div>
        </div>

        <div class="mt-4">
          <h3 class="text-lg font-semibold mb-2">Book Description</h3>
          <p class="text-gray-700 text-base leading-relaxed">{{ book.description }}</p>
        </div>

        <div class="mt-4">
          <h3 class="text-lg font-semibold mb-2">Genre</h3>
          <p class="text-gray-700 text-base leading-relaxed">
            <span class="inline-block bg-gray-200 text-gray-800 px-3 py-1 rounded-full text-sm">
              {{ book.genre }}
            </span>
          </p>
        </div>

        <div class="mt-4">
          <h3 class="text-lg font-semibold mb-2">Book Details</h3>
          <p class="text-gray-700 text-base leading-relaxed">
            <span class="text-[#0890F4] font-semibold">Publisher: </span>
            <span class="text-black">{{ book.publisher?.first_name || 'Unknown' }} {{ book.publisher?.last_name ||
              'Unknown'
            }}</span>
          </p>

          <p class="text-gray-700 text-base leading-relaxed">
            <span class="text-[#0890F4] font-semibold">Published Date: </span>
            <span class="text-black">{{ book.published_date }}</span>
          </p>
          <p class="text-gray-700 text-base leading-relaxed">
            <span class="text-[#0890F4] font-semibold">Hardcover: </span>
            <span class="text-black">{{ book.pages }} pages</span>
          </p>
        </div>
      </div>
    </div>

    <!-- Ratings Summary -->
    <div class="my-12">
      <h2 class="text-xl font-semibold mb-4">Ratings and Reviews</h2>
      <div class="border-t pt-7">
        <div class="flex flex-col md:flex-row justify-between gap-8 px-15">
          <div>
            <h2 class="text-lg font-semibold mb-4">COMMUNITY REVIEW</h2>
            <div class="flex items-center gap-5 mb-4">
              <div class="flex items-center gap-2 mb-2">
                <p class="text-2xl font-semibold text-black">{{ averageRating.toFixed(1) }} / 5</p>
                <div class="flex items-center gap-1 text-yellow-400" v-html="renderStars(averageRating)"></div>
              </div>
              <div class="text-sm text-[#0890F4] underline mb-2">{{ reviews.length }} Ratings & Reviews</div>
            </div>
            <div v-for="star in [5, 4, 3, 2, 1]" :key="star" class="flex items-center gap-2 text-sm mb-1">
              <span>{{ star }} star</span>
              <div class="w-48 bg-gray-200 rounded h-2">
                <div class="h-2 rounded" :class="{
                  'bg-[#26A541]': star >= 3,
                  'bg-[#FF9F00]': star === 2,
                  'bg-[#FF0000]': star === 1,
                }" :style="{ width: ratingPercentage(star) + '%' }"></div>
              </div>
            </div>
          </div>

          <!-- Rate this book -->
          <div>
            <h2 class="text-lg font-semibold mb-4">WHAT DO YOU THINK?</h2>
            <div class="flex items-center gap-5 mb-4">
              <div class="flex gap-5 mb-2 text-2xl cursor-pointer">
                <!-- <div>
                  <span class="text-[#0890F4] text-lg my-15">Rate this book:</span> <br>
                  <span v-for="i in 5" :key="'new-star-' + i" @click="newReview.rating = i"
                    :class="i <= newReview.rating ? 'text-yellow-400' : 'text-gray-300'">★</span>
                </div> -->
                <div>
                  <a :href="`/books/${book.id}/write-review`"
                    class="text-lg text-[#0890F4] underline hover:text-blue-700">
                    Write a Review
                  </a>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>

      <!-- Community Reviews -->
      <div v-if="reviews.length" class="space-y-4 pt-10">
        <div v-for="(review, index) in reviews" :key="index" class="bg-[#96DEFF] rounded-2xl p-6 shadow-md">
          <div class="flex items-center gap-10">
            <div>
              <img :src="review.user?.profile_picture || '/img/default_picture.avif'" alt="Reviewer Profile Picture"
                class="rounded-full w-12 h-12 object-cover mx-3 mb-2" />
              <p class="text-sm font-semibold">
                {{ review.user?.first_name ?? 'Anonymous' }} {{ review.user?.last_name ?? 'Anonymous' }}
              </p>
            </div>
            <div class="flex-1">
              <p class="text-sm text-[#0890F4] font-medium">
                {{ new Date(review.created_at).toLocaleDateString(undefined, {
                  month: 'long', day: 'numeric', year: 'numeric'
                })
                }}
              </p>
              <p class="text-black text-base mt-1 whitespace-pre-line">{{ review.review }}</p>
              <div class="mt-4 flex items-center gap-6 text-sm text-[#0369A1]">
                <span>{{ review.likes_count }} Likes</span>
                <span>{{ review.comments_count || 0 }} Comments</span>
                <button class="flex items-center gap-1 hover:underline" @click="likeReview(review.id, index)">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="#0369A1" class="w-4 h-4" viewBox="0 0 24 24">
                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 6 
                     3.5 4 5.5 4c1.54 0 3.04.99 3.57 2.36h1.87C13.46 4.99 
                     14.96 4 16.5 4 18.5 4 20 6 20 8.5c0 3.78-3.4 
                     6.86-8.55 11.54L12 21.35z" />
                  </svg>
                  Like
                </button>
                <button class="flex items-center gap-1 hover:underline" @click="openCommentModal(review)">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat"
                    viewBox="0 0 16 16">
                    <path
                      d="M2.678 11.894a1 1 0 0 1 .287.801 11 11 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8 8 0 0 0 8 14c3.996 0 7-2.807 7-6s-3.004-6-7-6-7 2.808-7 6c0 1.468.617 2.83 1.678 3.894m-.493 3.905a22 22 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a10 10 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9 9 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105" />
                  </svg>
                  Comment
                </button>

                <button @click="openReportModal('review', review.id)" class="flex items-center gap-1 hover:underline">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-exclamation-triangle" viewBox="0 0 16 16">
                    <path
                      d="M7.938 2.016A.13.13 0 0 1 8.002 2a.13.13 0 0 1 .063.016.15.15 0 0 1 .054.057l6.857 11.667c.036.06.035.124.002.183a.2.2 0 0 1-.054.06.1.1 0 0 1-.066.017H1.146a.1.1 0 0 1-.066-.017.2.2 0 0 1-.054-.06.18.18 0 0 1 .002-.183L7.884 2.073a.15.15 0 0 1 .054-.057m1.044-.45a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767z" />
                    <path
                      d="M7.002 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 5.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0z" />
                  </svg>
                  Report
                </button>

              </div>
            </div>
          </div>
        </div>
        <div v-if="showCommentModal" class="fixed inset-0 z-50 flex justify-center items-center"
          style="background-color: rgba(0, 0, 0, 0.5);">
          <ReviewCommentModal 
            :review="selectedReview" 
            :show="showCommentModal" 
            :user="user" 
            @close="closeCommentModal"
            @report="openReportModal"
            class="z-60" />
        </div>

      </div>
      <div v-else class="text-gray-500">No reviews yet.</div>
    </div>
  </div>



  <div v-else class="text-center py-10 text-gray-500">Loading book details...</div>

<ReportModal
  v-if="showReportModal"
  :type="reportType"
  :itemId="reportId"
  :show="showReportModal"
  @close="closeReportModal"
  @submitted="closeReportModal"
/>


</template>

<script>
import axios from "axios";
import ReviewCommentModal from './ReviewCommentModal.vue';
import ReportModal from './ReportModal.vue';

export default {
  name: "BookDetail",
  props: {
    bookId: {
      type: Number,
      required: true,
    },
  },
  components: {
    ReviewCommentModal,
    ReportModal,
  },
  data() {
    return {
      book: null,
      reviews: [],
      relatedBooks: [],
      showCommentModal: false,
      selectReview: null,
      showReportModal: false,
      reportType: '', // 'review' or 'comment'
      reportId: null,
      user: null,
      fullStar: '<svg xmlns="http://www.w3.org/2000/svg" fill="#FFD700" class="w-4 h-4" viewBox="0 0 24 24"><path d="M12 .587l3.668 7.568 8.332 1.21-6.042 5.882 1.428 8.32L12 18.896l-7.386 3.88 1.428-8.32L.001 9.365l8.332-1.21L12 .587z"/></svg>',
      halfStar: '<svg xmlns="http://www.w3.org/2000/svg" fill="#FFD700" class="w-4 h-4" viewBox="0 0 24 24"><path d="M12 .587l3.668 7.568 8.332 1.21-6.042 5.882 1.428 8.32L12 18.896l-7.386 3.88 1.428-8.32L.001 9.365l8.332-1.21L12 .587zM12 15.4l3.668 1.926-1.428-8.32L20 .587l-8.332-1.21L12 .587z"/></svg>',
      emptyStar: '<svg xmlns="http://www.w3.org/2000/svg" fill="#D3D3D3" class="w-4 h-4" viewBox="0 0 24 24"><path d="M12 .587l3.668 7.568 8.332 1.21-6.042 5.882 1.428 8.32L12 18.896l-7.386 3.88 1.428-8.32L.001 9.365l8.332-1.21L12 .587z"/></svg>',
      newReview: {
        rating: 0,
        text: "",
      },
      isOpen: false,
      options: [
        { label: 'Current Read', value: 'current' },
        { label: 'Want to Read', value: 'want' },
        { label: 'Read', value: 'read' },
      ]
    };
  },
  created() {
    this.fetchBook();
    this.fetchReviews();
    // this.fetchRelatedBooks();
    this.fetchUser(); // ✅ Add this

  },
  computed: {
    averageRating() {
      if (!this.reviews.length) return 0;
      const sum = this.reviews.reduce((acc, r) => acc + r.rating, 0);
      return sum / this.reviews.length;
    },
  },
  methods: {
    openCommentModal(review) {
      this.selectedReview = review;
      this.showCommentModal = true;
    },
    closeCommentModal() {
      this.showCommentModal = false;
      this.selectedReview = null;
    },
    openReportModal(type, id) {
  this.reportType = type;
  this.reportId = id;
  this.showReportModal = true;
},
closeReportModal() {
  this.showReportModal = false;
  this.reportType = '';
  this.reportId = null;
},

    toggleDropdown() {
      this.isOpen = !this.isOpen;
    },
    renderStars(rating) {
      const fullStar = `
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
  <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
</svg>`;

      const halfStar = `
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-half" viewBox="0 0 16 16">
  <path d="M5.354 5.119 7.538.792A.52.52 0 0 1 8 .5c.183 0 .366.097.465.292l2.184 4.327 4.898.696A.54.54 0 0 1 16 6.32a.55.55 0 0 1-.17.445l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256a.5.5 0 0 1-.146.05c-.342.06-.668-.254-.6-.642l.83-4.73L.173 6.765a.55.55 0 0 1-.172-.403.6.6 0 0 1 .085-.302.51.51 0 0 1 .37-.245zM8 12.027a.5.5 0 0 1 .232.056l3.686 1.894-.694-3.957a.56.56 0 0 1 .162-.505l2.907-2.77-4.052-.576a.53.53 0 0 1-.393-.288L8.001 2.223 8 2.226z"/>
</svg>`;

      const emptyStar = `
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
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
    },

    async fetchUser() {
      try {
        const response = await axios.get('/api/user');
        this.user = response.data;
      } catch (error) {
        console.error('Failed to load user:', error);
        this.user = null;
      }
    },
    async selectOption(status) {
      this.isOpen = false;
      try {
        await axios.post('/api/library', {
          book_id: this.book.id,
          status,
        });
        alert(`Book saved as "${status}"`);
      } catch (error) {
        console.error("Error saving to library:", error);
        alert("Failed to save book.");
      }
    },
    ratingPercentage(star) {
      const count = this.reviews.filter(r => r.rating === star).length;
      return this.reviews.length ? (count / this.reviews.length) * 100 : 0;
    },
    async fetchBook() {
      try {
        const response = await axios.get(`/api/books/${this.bookId}`);
        this.book = response.data;
      } catch (error) {
        console.error("Error fetching book:", error);
      }
    },
    async fetchReviews() {
      try {
        const response = await axios.get(`/api/books/${this.bookId}/reviews`);
        this.reviews = response.data;
      } catch (error) {
        console.error("Error fetching reviews:", error);
      }
    },
    async likeReview(reviewId, index) {
      try {
        const response = await axios.post(`/review/${reviewId}/like`);
        const { liked, likes_count } = response.data;

        // Update the likes count in the UI
        this.reviews[index].likes_count = likes_count;
      } catch (error) {
        console.error("Error liking review:", error);
        alert("You must be logged in to like a review.");
      }
    },
    // async fetchRelatedBooks() {
    //   try {
    //     const response = await axios.get(`/api/books/${this.bookId}/related`);
    //     this.relatedBooks = response.data;
    //   } catch (error) {
    //     console.error("Error fetching related books:", error);
    //   }
    // },
    async submitReview() {
      if (!this.newReview.rating || !this.newReview.text.trim()) {
        alert("Please provide a rating and comment.");
        return;
      }
      try {
        const response = await axios.post(`/api/books/${this.bookId}/reviews`, {
          rating: this.newReview.rating,
          review: this.newReview.text,
        });
        this.reviews.push(response.data); // Add new review
        this.newReview.rating = 0;
        this.newReview.text = '';
        alert("Review submitted!");
      } catch (error) {
        console.error("Error submitting review:", error);
        alert("Failed to submit review.");
      }
    },
  },
};
</script>
