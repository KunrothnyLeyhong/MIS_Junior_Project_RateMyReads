<template>
  <div class="mt-6">
    <h3 class="font-bold text-lg mb-2">Rate this Book</h3>
    <div class="flex space-x-1 mb-4">
      <span v-for="star in 5" :key="star" @click="rating = star" class="cursor-pointer text-2xl"
        :class="{ 'text-yellow-400': star <= rating, 'text-gray-400': star > rating }">
        ★
      </span>
    </div>

    <h4 class="font-bold mb-2">Give Us Your Thoughts On This Book!</h4>
    <textarea v-model="review" rows="4"
      class="w-full p-3 rounded-lg border bg-white border-gray-300 focus:outline-none focus:ring focus:border-blue-300"
      placeholder="Write your review about this book..."></textarea>

    <button @click="submitReview"
      class="mt-4 bg-gradient-to-r bg-[#D9D9D9] hover:from-gray-300 hover:to-gray-500 font-semibold px-6 py-2 rounded shadow">
      Submit
    </button>
  </div>
</template>

<script>
export default {
  props: {
    bookId: Number,
  },
  data() {
    return {
      rating: 0,
      review: '',
    };
  },
  methods: {
    async submitReview() {
  if (this.rating === 0) {
    alert("Please give a rating.");
    return;
  }
  if (this.review.trim() === '') {
    alert("Please write a review.");
    return;
  }

  try {
    const response = await axios.post(`/books/${this.bookId}/write-review`, {
      rating: this.rating,
      review: this.review
    });

    alert('Review submitted successfully!');
    this.rating = 0;
    this.review = '';
    // Redirect to the book detail page
    window.location.href = `/books/${this.bookId}`;
  } catch (error) {
    if (error.response && error.response.data.errors) {
      // Laravel validation errors
      console.log(error.response.data.errors);
      alert(Object.values(error.response.data.errors).flat().join('\n'));
    } else {
      alert('Failed to submit review.');
    }
  }
}

  },
};
</script>
