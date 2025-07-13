<template>
  <div class="min-h-screen text-gray-900 pb-20 pt-30">
    <!-- Welcome Section -->
    <section
      class="p-4 sm:p-6 md:p-10 bg-[#B5E2FF] rounded-xl m-4 sm:m-6 flex flex-col md:flex-row justify-around items-center">
      <div class="text-center md:text-left mb-6 md:mb-0">
        <h1 class="text-2xl font-bold py-3">Welcome back, {{ user.first_name }}!</h1>
        <p class="text-sm">Let's pick up where you left off.</p>
      </div>
      <img src="/img/regUser_homepage_picture.png" class="h-60 md:h-80 object-contain" alt="Reading Lady" />
    </section>

    <!-- Profile & Library -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 px-4 sm:px-6 md:px-12 py-6">
      <!-- User Profile -->
      <div>
        <h2 class="font-semibold text-lg mb-4">User Profile</h2>
        <div class="bg-[#96DEFF] p-4 rounded-xl">
          <div class="flex flex-col sm:flex-row items-center gap-6 px-4 sm:px-10 py-5">
            <img :src="profilePictureUrl" alt="User Image" class="w-24 h-24 rounded-full object-cover" />
            <div class="text-center sm:text-left">
              <p class="py-2"><strong>Name:</strong> {{ user.first_name }} {{ user.last_name }}</p>
              <p class="py-2"><strong>Date of Joining:</strong> {{ formatDate(user.created_at) }}</p>
              <!-- <p class="py-2"><strong>Status:</strong> Active</p> -->
            </div>
          </div>
        </div>
      </div>

      <!-- Library Categories -->
      <div class="px-2 sm:px-4 md:px-6">
        <h2 class="font-semibold text-lg mb-4">Library</h2>
        <div class="space-y-4">
          <div class="bg-[#65D5FF] p-4 rounded-xl">
            <p class="font-medium text-center">Currently Reading ({{ currentlyReading }})</p>
            <div class="flex justify-center items-center gap-2 flex-wrap text-center">
              <a href="addBook" class="text-sm text-white underline">Add a book</a>
              <span>|</span>
              <a href="library" class="text-sm text-white underline">View all books</a>
            </div>
          </div>
          <div class="bg-[#3ECAFF] p-4 rounded-xl">
            <p class="font-medium text-center">Want to Read ({{ wantToRead }})</p>
            <div class="flex justify-center items-center gap-2 flex-wrap text-center">
              <a href="addBook" class="text-sm text-white underline">Add a book</a>
              <span>|</span>
              <a href="library" class="text-sm text-white underline">View all books</a>
            </div>
          </div>
          <div class="bg-[#02B6FA] p-4 rounded-xl">
            <p class="font-medium text-center">Read ({{ readBooks }})</p>
            <div class="flex justify-center items-center gap-2 flex-wrap text-center">
              <a href="addBook" class="text-sm text-white underline">Add a book</a>
              <span>|</span>
              <a href="library" class="text-sm text-white underline">View all books</a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Recent Updates -->
    <section class="px-4 sm:px-6 md:px-15 mt-10 pt-5">
      <h2 class="font-semibold text-lg mb-4">{{ user.first_name }}'s Recent Update</h2>

      <!-- Book Action Box -->
      <div class="space-y-6 py-5">
        <div v-if="recentActivity" class="space-y-6 py-5">
          <div class="bg-[#B5E2FF] p-4 rounded-xl">
            <p class="text-md mb-2 px-4 sm:px-8 md:px-20 py-3">
              {{ user.first_name }} added a book to
              <template v-if="validStatuses.includes(recentActivity.status)">
                <a :href="`/library/${recentActivity.status}`" class="text-[#0890F4] underline">
                  "{{ formatStatus(recentActivity.status) }}"
                </a>
              </template>
              <template v-else>
                <span class="text-gray-500">{{ formatStatus(recentActivity.status) }}</span>
              </template>
            </p>

            <div class="flex flex-col lg:flex-row justify-between items-center gap-6 px-20 py-5">
              <!-- Book Info -->
              <div class="flex items-center gap-13">
                <img :src="recentActivity.book?.image" class="h-40 object-cover rounded"
                  :alt="recentActivity.book?.title || 'Book Image'" />
                <div>
                  <p class="font-semibold">{{ recentActivity.book?.title || 'Unknown Title' }}</p>
                  <p class="text-sm">By {{ recentActivity.book?.author || 'Unknown Author' }}</p>

                  <div class="flex items-center space-x-2 mt-2">
                    <div class="flex items-center space-x-2" v-html="renderStars(averageRating)"></div>
                    <span class="text-gray-700 font-semibold text-sm">
                      {{ formattedAverageRating }}/5
                    </span>
                  </div>


                </div>
              </div>

              <!-- Review Link -->
              <div class="w-1/2 pl-20 pr-10">
                <p class="text-sm font-medium mb-2">Rate this Book</p>
                <a :href="`/books/${recentActivity.book?.id}/write-review`"
                  class="text-lg text-[#0890F4] underline hover:text-blue-700">
                  Write a Review
                </a>
              </div>
            </div>
          </div>
        </div>
        <p v-else>No recent library's activity found.</p>

        <div v-if="recentReview" class="space-y-6 py-5">
          <div class="bg-[#96DEFF] p-4 rounded-xl">
          <p class="text-md mb-2 px-4 sm:px-8 md:px-20 py-3">
            {{ recentReview.user.first_name }} added a Review on
            <a :href="`/books/${recentReview.book.id}`" class="text-[#0890F4] underline">
              “{{ recentReview.book.title }}”
            </a>
          </p>

            <div class="flex flex-col lg:flex-row justify-between items-center gap-6 px-20 py-5">
            <!-- Book Info -->
            <div class="flex items-center gap-13">
              <img :src="recentReview.book.image || '/img/default_book.jpg'" class="h-40 object-cover rounded"
                :alt="recentReview.book.title" />
              <div>
                <p class="font-semibold">{{ recentReview.book.title }}</p>
                <p class="text-sm">By {{ recentReview.book.author }}</p>

                <!-- Star Rating -->
                <div class="flex items-center space-x-2 mt-2">
                  <template v-for="i in 5" :key="i">
                    <svg v-if="i <= Math.round(recentReview.rating)" xmlns="http://www.w3.org/2000/svg" width="16"
                      height="16" fill="#FFD700" class="bi bi-star-fill" viewBox="0 0 16 16">\n
                      <path
                        d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                    </svg>
                    <svg v-else xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#FFD700"
                      class="bi bi-star" viewBox="0 0 16 16">\n
                      <path
                        d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.56.56 0 0 0-.163-.505L1.71 6.745l4.052-.576a.53.53 0 0 0 .393-.288L8 2.223l1.847 3.658a.53.53 0 0 0 .393.288l4.052.575-2.906 2.77a.56.56 0 0 0-.163.506l.694 3.957-3.686-1.894a.5.5 0 0 0-.461 0z" />
                    </svg>
                  </template>
                  <span class="text-gray-700 font-semibold text-sm pr-2">
                    {{ Number(recentReview.rating).toFixed(1) }}/5
                  </span>
                </div>
              </div>
            </div>

            <!-- Review Text -->
            <div class="w-full lg:w-[300px]">
              <p class="text-sm font-medium mb-2">Review</p>
              <p class="text-sm italic text-gray-800 leading-relaxed">
                “{{ recentReview.review }}”
              </p>
            </div>
          </div>
        </div>
</div>
        <p v-else class="mt-8">No recent reviews found.</p>

      </div>
    </section>
  </div>
</template>

<script>
export default {
  props: {
    user: Object,
    currentlyReading: Number,
    wantToRead: Number,
    readBooks: Number,
    recentActivity: Object,
    averageRating: Number,
    recentReviews: Array,
    profilePictureUrl: {
      type: String,
      required: true
    },
    someValue: {
      type: Number,
      default: 0
    },
    recentReview: {
      type: Object,
      default: null,
    },
  },
  data() {
    return {
      validStatuses: ['current', 'want', 'read']
    };
  },
  computed: {
    latestReview() {
      // recentReviews is an array of review objects passed as a prop
      if (this.recentReviews && this.recentReviews.length > 0) {
        // Assuming the latest review is the first in the array (sorted by date)
        return this.recentReviews[0];
      }
      return null;
    },
    formattedAverageRating() {
      return typeof this.averageRating === 'number' ? this.averageRating.toFixed(1) : '0.0';
    }
  },
  methods: {
    formatDate(dateString) {
      const options = { year: 'numeric', month: 'long', day: 'numeric' };
      return new Date(dateString).toLocaleDateString(undefined, options);
    },
    formatStatus(status) {
      switch (status) {
        case 'current': return 'Currently Reading';
        case 'want': return 'Want to Read';
        case 'read': return 'Read';
        default: return 'Unknown Status';
      }
    },
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
    mounted() {
      console.log('User:', this.user);
    },
  }
};
</script>
