<template>
  <div class="bg-white rounded-lg shadow-xl w-full max-w-3xl p-6 relative">
    <button @click="$emit('close')" class="absolute top-3 right-4 text-gray-500 text-2xl">&times;</button>
    <div class="items-center text-center mb-4 bg-[#96DEFF] p-4 rounded-3xl">
      <h2 class="text-xl font-semibold mb-2">{{ user.first_name }} {{ user.last_name }}'s Comment</h2>
    </div>
    <div class="flex gap-10">
      <div class="flex items-start gap-3 mb-4">
        <img
          :src="review.user?.profile_picture || '/img/default_picture.avif'"
          class="w-15 h-15 rounded-full object-cover"
          alt="Reviewer profile"
        />
        <div>
          <p class="text-sm font-semibold">
            {{ review.user?.first_name ?? 'Anonymous' }} {{ review.user?.last_name ?? 'Anonymous' }}
          </p>
          <p class="text-sm text-[#0890F4] font-medium">
            {{ new Date(review.created_at).toLocaleDateString(undefined, { month: 'long', day: 'numeric', year: 'numeric' }) }}
          </p>
        </div>
      </div>

      <div class="flex-1">
        <p class="text-gray-700 mb-4 whitespace-pre-line">{{ review.review }}</p>
        <div class="mt-4 flex items-center gap-6 text-sm text-[#0369A1] mb-5">
          <span>{{ review.likes_count }} Likes</span>
          <span>{{ review.comments_count || 0 }} Comments</span>
        </div>

        <div class="bg-[#B5E2FF] p-4 rounded-3xl w-full max-w-3xl mx-auto">
          <div v-for="comment in comments" :key="comment.id" class="flex gap-3 items-start mb-4">
            <img
              :src="comment.user?.profile_picture || '/img/default_picture.avif'"
              class="w-10 h-10 rounded-full object-cover"
              alt="Commenter profile"
            />
            <div class="flex flex-col">
              <p class="text-sm font-semibold">
                {{ comment.user?.first_name ?? 'Anonymous' }} {{ comment.user?.last_name ?? 'Anonymous' }}
              </p>
              <div class="flex items-center gap-3 max-w-lg">
                <p class="text-sm bg-white p-3 rounded-xl whitespace-pre-line flex-grow">
                  {{ comment.message }}
                </p>
                <button
                  @click.prevent="$emit('report', 'comment', comment.id)"
                  class="flex items-center gap-1 text-sm text-[#0369A1] pt-3 hover:underline self-start"
                  title="Report this comment"
                >
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle" viewBox="0 0 16 16">
                    <path d="M7.938 2.016A.13.13 0 0 1 8.002 2a.13.13 0 0 1 .063.016.15.15 0 0 1 .054.057l6.857 11.667c.036.06.035.124.002.183a.2.2 0 0 1-.054.06.1.1 0 0 1-.066.017H1.146a.1.1 0 0 1-.066-.017.2.2 0 0 1-.054-.06.18.18 0 0 1 .002-.183L7.884 2.073a.15.15 0 0 1 .054-.057m1.044-.45a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767z"/>
                    <path d="M7.002 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 5.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0z"/>
                  </svg>
                  Report
                </button>
              </div>
            </div>
          </div>

          <div class="flex items-start gap-3 border-t pt-4 mt-4">
            <img :src="computedProfilePicture" class="w-10 h-10 rounded-full object-cover" alt="User profile" />
            <input
              type="text"
              v-model="newComment"
              placeholder="Write a comment..."
              class="w-full min-w-[250px] px-4 py-2 rounded-xl bg-white border focus:outline-none"
            />
            <button @click="submitComment" class="bg-blue-500 text-white px-4 py-1.5 rounded-full hover:bg-blue-600">
              Send
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  props: {
    review: {
      type: Object,
      required: true
    },
    show: {
      type: Boolean,
      required: true
    },
    user: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      comments: [],
      newComment: "",
    };
  },
  watch: {
    show(newVal) {
      if (newVal) {
        this.fetchComments();
      }
    },
  },
  mounted() {
    if (this.show) {
      this.fetchComments();
    }
  },
  computed: {
    computedProfilePicture() {
      return this.user?.profile_picture || "/img/default_picture.avif";
    },
  },
  methods: {
    async fetchComments() {
      try {
        const res = await axios.get(`/review/${this.review.id}/comments`);
        this.comments = res.data;
      } catch (error) {
        console.error("Failed to load comments", error);
      }
    },
    async submitComment() {
      if (!this.newComment.trim()) return;

      try {
        const res = await axios.post(`/review/${this.review.id}/comments`, {
          message: this.newComment,
        });
        this.comments.push(res.data);
        this.newComment = "";
        if (typeof this.review.comments_count === "number") {
          this.review.comments_count++;
        } else {
          this.review.comments_count = 1;
        }
      } catch (error) {
        console.error("Failed to post comment", error);
        alert("Please login to comment.");
      }
    },
  },
};
</script>
