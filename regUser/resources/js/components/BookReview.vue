<template>
  <div class="mt-10">
    <h3 class="text-lg font-semibold mb-2">Ratings and Reviews</h3>
    <div v-for="review in reviews" :key="review.id" class="bg-gray-100 rounded-lg p-4 mb-2">
      <p class="font-bold">{{ review.user.name }}</p>
      <p class="text-sm text-gray-600">{{ review.created_at }}</p>
      <p class="mt-2">{{ review.content }}</p>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    reviews: Array,
    bookId: Number,
  },
};
</script>
