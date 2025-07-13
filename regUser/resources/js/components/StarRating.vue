<template>
  <div class="flex">
    <template v-for="star in 5" :key="star">
      <svg @click="rate(star)" :class="star <= rating ? 'text-yellow-400' : 'text-gray-300'" class="w-5 h-5 cursor-pointer" fill="currentColor" viewBox="0 0 20 20">
        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.973h4.174c.969 0 1.371 1.24.588 1.81l-3.38 2.455 1.287 3.972c.3.922-.755 1.688-1.539 1.117L10 13.347l-3.377 2.455c-.783.57-1.838-.195-1.539-1.117l1.287-3.972-3.38-2.455c-.782-.57-.38-1.81.588-1.81h4.174l1.286-3.973z"/>
      </svg>
    </template>
  </div>
</template>

<script>
export default {
  props: {
    initial: {
      type: Number,
      default: 0,
    },
  },
  data() {
    return {
      rating: this.initial,
    };
  },
  methods: {
    rate(star) {
      this.rating = star;
    },
  },
};
</script>
