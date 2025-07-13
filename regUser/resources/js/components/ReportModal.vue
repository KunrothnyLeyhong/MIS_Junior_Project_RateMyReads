<template>
  <div v-if="show" class="fixed inset-0 z-50 flex justify-center items-center" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="bg-white rounded-xl p-6 w-80 shadow-xl text-center">
      <div class="items-center text-center mb-4 bg-[#96DEFF] p-2 rounded-3xl">
      <h2 class="text-lg font-semibold text-black">Report Issue?</h2>
    </div>
      <p class="text-sm mb-4 font-medium">Select your reason</p>

      <div v-for="option in reportOptions" :key="option.value" class="mb-2">
        <label class="flex items-center gap-2 bg-[#D9D9D9] cursor-pointer px-4 py-2 border rounded-md hover:bg-blue-50"
          :class="{ 'border-blue-400': reason === option.value }">
          <input type="radio" :value="option.value" v-model="reason" class="accent-blue-600" />
          {{ option.label }}
        </label>
      </div>

      <div class="mt-6 flex justify-between gap-4">
        <button @click="$emit('close')"
          class="flex-1 py-2 rounded-md bg-gray-300 text-black hover:bg-gray-400">Cancel</button>
        <button @click="submitReport"
          class="flex-1 py-2 rounded-md bg-[#96DEFF] text-black hover:bg-blue-700">Submit</button>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'ReportModal',
  props: {
    show: Boolean,
    type: String,     // 'review' or 'comment'
    itemId: Number
  },
  data() {
    return {
      reason: '',
      reportOptions: [
        { value: 'inappropriate', label: 'Inappropriate content' },
        { value: 'spam', label: 'Spam or misleading' },
        { value: 'harassment', label: 'Harassment or hate speech' },
      ]
    };
  },
  methods: {
    async submitReport() {
      if (!this.reason) {
        alert('Please select a reason.');
        return;
      }

      try {
        await axios.post('/api/report', {
          type: this.type,
          id: this.itemId,
          reason: this.reason
        });

        alert('Report submitted successfully.');
        this.$emit('submitted');
      } catch (error) {
        console.error('Report error:', error);
        alert(error.response?.data?.message || 'Failed to submit report.');
      }
    }
  }
};
</script>
